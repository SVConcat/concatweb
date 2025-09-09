<?php

return [
    'channels' => [
        'announcements' => [
            'name' => 'Announcements',
            'webhook_url' => env('DISCORD_WEBHOOK_ANNOUNCEMENTS'),
            'description' => 'Important announcements and news'
        ],
        'test' => [
            'name' => 'Test',
            'webhook_url' => env('DISCORD_WEBHOOK_TEST'),
            'description' => 'Important announcements and news'
        ],
    ],

    'tags' => [
        'everyone' => [
            'name' => '@everyone',
            'value' => '@everyone',
            'description' => 'Notify all server members'
        ],
        'here' => [
            'name' => '@here',
            'value' => '@here',
            'description' => 'Notify online members only'
        ],
    ],

    'default_embed_color' => '#3498db',
    'bot_name' => env('DISCORD_BOT_NAME', 'Announcement Bot'),
];
