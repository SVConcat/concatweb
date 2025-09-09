<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;


    public array $payload;
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }


    public function build()
    {
        return $this->markdown('emails.notification')->subject($this->payload['subject']);
    }
}
