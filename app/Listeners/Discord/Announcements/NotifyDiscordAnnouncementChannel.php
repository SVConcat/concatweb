<?php

namespace App\Listeners\Discord\Announcements;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NotifyDiscordAnnouncementChannel
{
    public function handle(NewAnnouncementAdded $event): void
    {
        $announcementWebhookUrl = env('DISCORD_WEBHOOK_ANNOUNCEMENTS');
        $description = $event->description ?? 'Geen beschrijving beschikbaar';
        $quotedDescription = '> ' . str_replace("\n", "\n> ", $description);

        if (!$announcementWebhookUrl) {
            Log::error('Discord webhook URL ontbreekt! Controleer .env bestand.');
            return;
        }

        $client = new Client();

        $message = [
            'embeds' => [
                [
                    'author' => [
                        'name' => 'SV Concat Aankondigingen',
                        'icon_url' => 'https://media.licdn.com/dms/image/v2/C4D0BAQFWHZvu8s8ugg/company-logo_400_400-alternative/company-logo_400_400-alternative/0/1630520127352?e=2147483647&v=beta&t=g331t3valI0YipGszLqGl4MhTak2EiiCNgGsv-7YOLQ'
                    ],

                    'title' => null,
                    'description' => "# [{$event->title} ➜](" . ($event->url ?? route('announcements.index')) . ")\n\n{$quotedDescription}",
                    'color' => 7506394,
                ],
            ],
        ];

        try {
            $client->post($announcementWebhookUrl, ['json' => $message]);
        } catch (\Exception $e) {
            Log::error('Fout bij het versturen naar Discord webhook: ' . $e->getMessage());
        }
    }
}
