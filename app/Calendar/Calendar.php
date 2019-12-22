<?php

namespace App\Calendar;

use App\Time;
use Google_Service_Calendar;
use Illuminate\Support\Facades\Cache;

/**
 * Abstraction over a Google Calendar
 */
class Calendar
{
    private $id;
    private $email;
    private $now;
    private $events;

    public function __construct(string $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;

        // Allow time-shifting for easier testing
        $this->now = app(Time::class)->now();

        $this->events = new Events(Cache::get("person.{$id}.calendar"));
    }

    public function currentEvent(): ?Event
    {
        $event = $this->events
                    ->at($this->now)
                    ->notTimewax()
                    ->attending($this->email)
                    ->first();

        return $event ? new Event($event) : null;
    }

    public function isOutSick(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Ziek:')
                    ->count() > 0;
    }

    public function hasDayOff(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Vrij:')
                    ->count() > 0;
    }

    public function onVacation(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Vakantie:')
                    ->count() > 0;
    }
}
