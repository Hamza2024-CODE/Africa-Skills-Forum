<?php

namespace App\Services;

class PlatformService
{
    /**
     * Get the full platform name.
     */
    public function name(): string
    {
        return (string) config('platform.name', 'Africa Skills Forum');
    }

    /**
     * Get the short platform identifier.
     */
    public function shortName(): string
    {
        return (string) config('platform.short_name', 'ASF');
    }

    /**
     * Get the primary platform domain.
     */
    public function domain(): string
    {
        return (string) config('platform.domain', 'africaskillsforum.org');
    }

    /**
     * Get the official platform contact email.
     */
    public function email(): string
    {
        return (string) config('platform.email', 'contact@africaskillsforum.org');
    }

    /**
     * Get the executive organization name.
     */
    public function organization(): string
    {
        return (string) config('platform.organization', 'Africa Skills Forum Executive Committee');
    }

    /**
     * Get the active event title.
     */
    public function event(): string
    {
        return (string) config('platform.event', 'Africa Skills Forum 2026/2027');
    }

    /**
     * Get dynamic setting value from database settings engine.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return app(SettingsEngine::class)->get($key, $default);
    }

    /**
     * Get array of all platform parameters.
     */
    public function toArray(): array
    {
        return [
            'name'         => $this->name(),
            'short_name'   => $this->shortName(),
            'domain'       => $this->domain(),
            'email'        => $this->email(),
            'organization' => $this->organization(),
            'event'        => $this->event(),
        ];
    }
}
