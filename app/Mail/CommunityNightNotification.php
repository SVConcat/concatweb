<?php

namespace App\Mail;

use App\Models\CommunityNight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommunityNightNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $communityNight;


    /**
     * Create a new message instance.
     */
    public function __construct(CommunityNight $communityNight)
    {
        $this->communityNight = $communityNight;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Herinnering: Community Avond - ' . $this->communityNight->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.community_night_notification',
            with: [
                'communityNight' => $this->communityNight,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
