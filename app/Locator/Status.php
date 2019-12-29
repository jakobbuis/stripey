<?php

namespace App\Locator;

use App\Calendar\Event;
use Carbon\CarbonImmutable;

class Status
{
    public $state;
    public $data;

    public static function atOffice(): self
    {
        return new self('at_office');
    }

    public static function fromEvent(Event $event): self
    {
        // Distinguish between working from home and meetings
        if ($event->isWorkingFromHome()) {
            if ($event->isAllDay()) {
                $until = 'on ' . $event->until()->nextWeekday()->formatLocalized('%A %e %B');
            } else {
                $until = 'at ' . $event->until()->format('H:i');
            }
            return new self('working_from_home', compact('until'));
        }

        // In meeting
        return new self('in_meeting', [
            'until' => $event->until()->format('H:i'),
            'location' => $event->location(),
            'summary' => $event->summary(),
        ]);
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

    private function __construct(string $state, array $data = [])
    {
        $this->state = $state;
        $this->data = $data;
    }
}
