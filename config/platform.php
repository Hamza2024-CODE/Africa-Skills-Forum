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

    'name' => env('PLATFORM_NAME', 'African Skills Policy Forum'),

    'short_name' => env('PLATFORM_SHORT_NAME', 'ASPF'),

    'domain' => env('PLATFORM_DOMAIN', 'africaskills-policyforum.worldskills.dz'),

    'email' => env('PLATFORM_EMAIL', 'contact@africaskills-policyforum.worldskills.dz'),

    'organization' => env(
        'PLATFORM_ORGANIZATION',
        'African Skills Policy Forum Executive Committee'
    ),

    'event' => env(
        'PLATFORM_EVENT',
        'African Skills Policy Forum 2026'
    ),
];
