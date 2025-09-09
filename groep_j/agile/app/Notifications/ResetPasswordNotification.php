<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->greeting('Hallo!')
            ->subject('Reset je wachtwoord')
            ->line('Je ontvangt dit bericht omdat we een verzoek hebben ontvangen om het wachtwoord van je account te resetten.')
            ->line('Klik op de knop hieronder om je wachtwoord te resetten.')
            ->action('Reset je wachtwoord', $resetUrl)
            ->line('Als je geen wachtwoordreset hebt aangevraagd, hoef je verder niets te doen.')
            ->salutation('Met vriendelijke groet, SVConcat');
    }
}


