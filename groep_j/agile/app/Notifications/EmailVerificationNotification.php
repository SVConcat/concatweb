<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class EmailVerificationNotification extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->greeting('Hallo!')
            ->subject('Bevestig je e-mailadres')
            ->line('Klik op de knop hieronder om je e-mailadres te bevestigen.')
            ->action('Bevestig e-mailadres', $verificationUrl)
            ->line('Als je je niet hebt geregistreerd, hoef je verder niets te doen.')
            ->salutation('Met vriendelijke groet, SVConcat');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
