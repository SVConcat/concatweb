<?php

namespace App\Services;

use App\Mail\AnnouncementMail;
use App\Mail\NewsLettermail;
use App\Mail\NotificationMail;
use App\Models\Announcement;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendAnnouncementMail(Announcement $ann, string|array $to) : void
    {
        if (config('mail.enabled')) {
            Mail::to($to)->send(new NotificationMail([
                'subject' => "nieuwe melding van concat: {$ann->title}",
                'title' => $ann->title,
                'id' => $ann->id,
                'body' => $ann->description,
                'imageUrl' => $ann->banner ? $ann->banner_url : null,
                'btnText' => 'Bekijk op de website',
                'btnUrl' => route('user.announcement.show', $ann),
                'type' => 'announcement',
            ]));
        }
    }
    public function sendEvent(Event $event, string|array $to): void
    {
        $price = $event->price ? "Prijs: €{$event->price}\n" : '';
        $dates = "Datum: {$event->start_date}\n";

        if (config('mail.enabled')) {
            Mail::to($to)->send(new NotificationMail([
                'subject' => " Nieuw evenement van concat: {$event->title}",
                'title' => $event->title,
                'id' => $event->id,
                'body' => "{$event->description}\n\n{$price}{$dates}",
                'imageUrl' => $event->banner ? $event->banner_url : null,
                'btnText' => 'Meer informatie & tickets',
                'btnUrl' => route('user.event.show', $event),
                'type' => 'event',
            ]));
        }
    }

    public function sendGendNewsLetter(array|string $to, array $data, string $newsLetterTemplateview = 'pdf.newsletter')
    {
        $pdf = pdf::loadView($newsLetterTemplateview, ['data' => $data])->output();

        if (config('mail.enabled')) {
        mail::to($to)->send(new newsletterMail($data,$pdf));
        }
    }

    public function sendNewsLetter(array|string $to, $pdf)
    {
        if (config('mail.enabled')) {
            mail::to($to)->send(new newsletterMail([], $pdf));
        }
    }
}
