<?php

namespace App\Listeners\Discord\CommunityNights;

use App\Listeners\Discord\CommunityNights\NewCommunityNightAdded;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NotifyDiscordCommunityNightChannel
{
    public function handle(NewCommunityNightAdded $event): void
    {
        $communityNightWebhookUrl = env('DISCORD_WEBHOOK_COMMUNITY_NIGHTS');

        if (!$communityNightWebhookUrl) {
            Log::error('Discord webhook URL voor community nights ontbreekt! Controleer .env bestand.');
            return;
        }

        $client = new Client();

        $embed = [
            // Gebruik author voor de SV Concat link bovenaan
            'author' => [
                'name' => 'SV Concat Community Avonden',
                'url' => $event->url ?? route('community-nights.index'), // Fallback URL
                'icon_url' => 'https://media.licdn.com/dms/image/v2/C4D0BAQFWHZvu8s8ugg/company-logo_400_400-alternative/company-logo_400_400-alternative/0/1630520127352?e=2147483647&v=beta&t=g331t3valI0YipGszLqGl4MhTak2EiiCNgGsv-7YOLQ'
            ],
            // Verplaats de titel naar de beschrijving met Markdown
            'description' => "# [{$event->title} ➜]({$event->url})\n\n{$event->description}\n\n### ➤ Community Avond Details:",
            'color' => 3447003, // Blauwe kleur

            'fields' => [
                [
                    'name' => 'Datum:',
                    'value' => "> " . ($event->startDate ?? 'Datum nog niet bekend'),
                    'inline' => true,
                ],
                [
                    'name' => 'Begintijd:',
                    'value' => "> " . ($event->startTime ?? 'Tijd nog niet bekend'),
                    'inline' => true,
                ],
                [
                    'name' => 'Locatie:',
                    'value' => "> " . ($event->location ?? 'Locatie nog niet bekend'),
                    'inline' => true,
                ],
                [
                    'name' => 'Beschikbare plaatsen:',
                    'value' => "> " . ($event->spotsAvailable ?? 'Onbeperkt'),
                    'inline' => true,
                ],
            ],
        ];

        // Voeg thumbnail toe als er een afbeelding is
        if ($event->imageUrl) {
            $embed['thumbnail'] = [
                'url' => $event->imageUrl
            ];
        }

        // Voeg de standaard banner afbeelding toe
        $embed['image'] = [
            'url' => 'https://media.licdn.com/dms/image/v2/C4D1BAQEsBgAIDepVEQ/company-background_10000/company-background_10000/0/1628857370852/sv_concat_cover?e=2147483647&v=beta&t=DNJgiP1z1agixG0WVtcOTirtMmUNP8BiwzK127i13j4'
        ];

        $message = [
            'embeds' => [$embed],
        ];

        try {
            $client->post($communityNightWebhookUrl, ['json' => $message]);
        } catch (\Exception $e) {
            Log::error('Fout bij het versturen naar Discord webhook: ' . $e->getMessage());
        }
    }
}
