<?php

namespace App\Services;

class EventContextService
{
    protected ?int $countryId = null;
    protected ?int $organizationId = null;
    protected ?int $eventId = null;
    protected ?int $editionId = null;
    protected string $activeModule = 'FORUM';

    public function setContext(?int $countryId = null, ?int $organizationId = null, ?int $eventId = null, ?int $editionId = null, string $module = 'FORUM'): self
    {
        $this->countryId = $countryId;
        $this->organizationId = $organizationId;
        $this->eventId = $eventId;
        $this->editionId = $editionId;
        $this->activeModule = strtoupper($module);

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function getEditionId(): ?int
    {
        return $this->editionId;
    }

    public function getActiveModule(): string
    {
        return $this->activeModule;
    }

    public function toArray(): array
    {
        return [
            'country_id'      => $this->countryId,
            'organization_id' => $this->organizationId,
            'event_id'        => $this->eventId,
            'edition_id'      => $this->editionId,
            'active_module'   => $this->activeModule,
        ];
    }
}
