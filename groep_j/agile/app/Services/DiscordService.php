<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiscordService
{
    public static function notifyDiscord($model, ?array $discordSettings = null, string $eventType = 'generic'): void
    {
        if (!$discordSettings || ($discordSettings['enabled'] ?? '0') !== '1') {
            return;
        }
        $payload = self::buildPayload($discordSettings, $model, $eventType);
        self::send($discordSettings, $payload);
    }

    public static function send(array $settings, array $payload): void
    {
        $channel = $settings['channel'] ?? null;
        if (!$channel) {
            return;
        }

        $webhookUrl = config("discord.channels.{$channel}.webhook_url");
        if (!$webhookUrl) {
            return;
        }

        try {
            Http::post($webhookUrl, $payload);
        } catch (\Exception $e) {
            Log::error('Discord Webhook failed: ' . $e->getMessage());
        }
    }

    public static function buildPayload(array $settings, $model, string $eventType): array
    {
        $content = '';
        if (!empty($settings['tag'])) {
            $tagConfig = config("discord.tags.{$settings['tag']}");
            $content = $tagConfig['value'] ?? '';
        }

        if (($settings['type'] ?? '') === 'embed') {
            $embed = self::buildEmbed($settings, $model, $eventType);
            $payload = ['embeds' => [$embed]];
            if (!empty($content)) {
                $payload['content'] = $content;
            }
        } else {
            $message = $content;
            if (!empty($settings['title'])) {
                $message .= "\n**" . $settings['title'] . "**";
            }
            if (!empty($settings['description'])) {
                $message .= "\n" . $settings['description'];
            }
            $payload = ['content' => trim($message)];
        }

        return $payload;
    }

    private static function buildEmbed(array $settings, $model, string $eventType): array
    {
        $title = $settings['title'] ?? ($model->title ?? '');

        $embed = [
            'title' => $title,
            'description' => $settings['description'] ?? ($model->description ?? ''),
            'color' => hexdec(ltrim($settings['embed_color'] ?? config('discord.default_embed_color'), '#')),
            'timestamp' => now()->toISOString(),
            'footer' => [
                'text' => config('app.name', 'Laravel App')
            ]
        ];

        if (method_exists($model, 'getDiscordEmbedFields')) {
            $embed['fields'] = $model->getDiscordEmbedFields($eventType);
        }

        return $embed;
    }
}
