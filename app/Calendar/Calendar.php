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
        $events = $this->events
                    ->at($this->now)
                    ->notTimewax()
                    ->attending($this->email);

        if ($events->count() === 0) {
            return null;
        } elseif ($events->count() === 1) {
            return new Event($events->first());
        }

        // If we have multiple options, prefer the event that started last
        return $events->map(function ($googleEvent) {
            return new Event($googleEvent);
        })->sort(function ($event) {
            return $event->start()->getTimestamp();
        })->first();
    }

    public function isOutSick(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Ziek:')
                    ->attending($this->email)
                    ->count() > 0;
    }

    public function hasDayOff(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Vrij:')
                    ->attending($this->email)
                    ->count() > 0;
    }

    public function onVacation(): bool
    {
        return $this->events
                    ->onAfwezig()
                    ->startsWith('Vakantie:')
                    ->attending($this->email)
                    ->count() > 0;
    }
}
