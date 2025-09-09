<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Events\EventCreated;
use Illuminate\Support\Facades\Http;

class SendDiscordWebhookNotification
{
    public function handle($event): void
    {
        if (!$event->discordSettings || ($event->discordSettings['enabled'] ?? '0') !== '1') {
            return;
        }

        $model = $this->getModelFromEvent($event);

        if ($model) {
            $this->sendDiscordMessage($model, $event->discordSettings, $this->getEventType($event));
        }
    }

    private function getModelFromEvent($event)
    {
        if ($event instanceof AnnouncementCreated) {
            return $event->announcement;
        } elseif ($event instanceof EventCreated) {
            return $event->event;
        }

        return null;
    }

    private function getEventType($event): string
    {
        if ($event instanceof AnnouncementCreated) {
            return 'announcement';
        } elseif ($event instanceof EventCreated) {
            return 'event_created';
        }
        return 'unknown';
    }

    private function sendDiscordMessage($model, $discordSettings, $eventType)
    {
        $channel = $discordSettings['channel'] ?? null;

        if (!$channel) {
            return;
        }

        $webhookUrl = config("discord.channels.{$channel}.webhook_url");

        if (!$webhookUrl) {
            return;
        }

        $payload = $this->buildDiscordPayload($model, $discordSettings, $eventType);

        try {
            $response = Http::post($webhookUrl, $payload);
        } catch (\Exception $e) {
            \Log::error('Discord Webhook failed: ' . $e->getMessage());
        }
    }

    private function buildDiscordPayload($model, $settings, $eventType)
    {
        $content = '';

        if (!empty($settings['tag'])) {
            $tagConfig = config("discord.tags.{$settings['tag']}");
            $content = $tagConfig['value'] ?? '';
        }

        if ($settings['type'] === 'embed') {
            $embed = $this->buildEmbed($model, $settings, $eventType);

            $payload = [
                'embeds' => [$embed]
            ];

            if (!empty($content)) {
                $payload['content'] = $content;
            }

        } else {
            $message = $content;
            if (!empty($settings['title'])) {
                $suffix = $eventType === 'event_updated' ? ' (Bijgewerkt)' : '';
                $message .= "\n**" . $settings['title'] . $suffix . "**";
            }
            if (!empty($settings['description'])) {
                $message .= "\n" . $settings['description'];
            }

            $payload = ['content' => trim($message)];
        }

        return $payload;
    }

    private function buildEmbed($model, $settings, $eventType)
    {
        $title = $settings['title'] ?? $model->title;

        if ($eventType === 'event_updated') {
            $title .= ' (Bijgewerkt)';
        }

        $embed = [
            'title' => $title,
            'description' => $settings['description'] ?? $model->description,
            'color' => hexdec(ltrim($settings['embed_color'] ?? config('discord.default_embed_color'), '#')),
            'timestamp' => now()->toISOString(),
            'footer' => [
                'text' => config('app.name', 'Laravel App') . ($eventType === 'event_updated' ? ' • Bijgewerkt' : '')
            ]
        ];

        if (in_array($eventType, ['event_created', 'event_updated'])) {
            $embed['fields'] = $this->buildEventFields($model);
        }

        return $embed;
    }

    private function buildEventFields($event)
    {
        $fields = [
            [
                'name' => 'Start Datum',
                'value' => \Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i'),
                'inline' => true,
            ],
            [
                'name' => 'Categorie',
                'value' => $event->category ? __($event->category->value) : 'Geen categorie',
                'inline' => true,
            ],
            [
                'name' => 'Status',
                'value' => __($event->status->value),
                'inline' => true,
            ]
        ];

        if ($event->end_date) {
            $fields[] = [
                'name' => 'Eind Datum',
                'value' => \Carbon\Carbon::parse($event->end_date)->format('d-m-Y H:i'),
                'inline' => true,
            ];
        }

        if (isset($event->is_open)) {
            $fields[] = [
                'name' => 'Inschrijving',
                'value' => $event->is_open ? 'Open' : 'Gesloten',
                'inline' => true,
            ];
        }

        return $fields;
    }
}
