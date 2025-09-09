<?php

namespace App\Services;

use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Builder;
use App\Mail\AnnouncementMail;

class AnnouncementService
{
    private MailService $mailService;
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }
    public function getAnnouncements(): Builder
    {
        return Announcement::query();
    }

    public function store(array $data, $request)
    {
        $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? null;
        $announcement = Announcement::create($data);
        $discordSettings = $request->input('discord') ?? null;

        DiscordService::notifyDiscord($announcement, $discordSettings, 'announcement');

        $this->sendAnnouncementEmails($announcement);

        return $announcement;
    }

    private function sendAnnouncementEmails(Announcement $announcement)
    {
        $subscribers = \App\Models\User::where('announcement_subscription', true)->get();

        if ($subscribers->isEmpty()) {
            return;
        }

        $emails = $subscribers->pluck('email')->toArray();

        $this->mailService->sendAnnouncementMail($announcement, $emails);
    }

    public function update(Announcement $announcement, array $data, $request)
    {
        if ($request->hasFile('image')) {
            ImageService::deleteImage(Announcement::class, $announcement, 'image');
            $data['image'] = ImageService::StoreImage($request, 'image', '/announcements') ?? ($data['image'] ?? null);
        }

        $announcement->update($data);
        $discordSettings = $request->input('discord') ?? null;

        event(new AnnouncementCreated($announcement, $discordSettings));
    }

    public function delete(Announcement $announcement): void
    {
        ImageService::deleteImage(Announcement::class, $announcement, 'image');
        $announcement->delete();
    }

    public function getPaginatedPublicAnnouncements(int $perPage = 10)
    {
        return Announcement::query()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }
}
