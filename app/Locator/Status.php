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

    public static function outSick(): self
    {
        return new self('out_sick');
    }

    public static function dayOff(): self
    {
        return new self('day_off');
    }

    public static function onVacation(): self
    {
        return new self('on_vacation');
    }

    public static function workingFromHome(): self
    {
        return new self('working_from_home');
    }

    private function __construct(string $state, array $data = [])
    {
        $this->state = $state;
        $this->data = $data;
    }
}
