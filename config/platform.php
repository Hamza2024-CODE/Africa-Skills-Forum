<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Africa Skills Forum (ASF) Platform Dynamic Configuration
    |--------------------------------------------------------------------------
    |
    | Central configuration repository for ASF branding, metadata, organization,
    | domain, and contact credentials. Consumed via PlatformService / platform().
    |
    */

    'name' => env('PLATFORM_NAME', 'Africa Skills Forum'),

    'short_name' => env('PLATFORM_SHORT_NAME', 'ASF'),

    'domain' => env('PLATFORM_DOMAIN', 'africaskillsforum.org'),

    'email' => env('PLATFORM_EMAIL', 'contact@africaskillsforum.org'),

    'organization' => env(
        'PLATFORM_ORGANIZATION',
        'Africa Skills Forum Executive Committee'
    ),

    'event' => env(
        'PLATFORM_EVENT',
        'Africa Skills Forum 2026/2027'
    ),
];
