<?php

namespace App\Locator;

class Status
{
    public $state;
    public $data;

    public static function atOffice(): self
    {
        return new self('at_office');
    }

    public static function inMeeting(string $until, ?string $location, ?string $summary): self
    {
        return new self('in_meeting', compact('until', 'location', 'summary'));
    }

    private function __construct(string $state, array $data = [])
    {
        $this->state = $state;
        $this->data = $data;
    }
}
