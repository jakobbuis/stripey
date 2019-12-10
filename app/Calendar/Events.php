<?php

namespace App\Calendar;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class Events extends Collection
{
    /**
     * Filter down to events to straddle a specific moment in time
     */
    public function at(CarbonInterface $time): self
    {
        return $this->filter(function ($event) use ($time) {
            $start = Carbon::parse($event->start->dateTime);
            $end = Carbon::parse($event->end->dateTime);

            return $time >= $start && $time <= $end;
        });
    }

    /**
     * Remove events created by Timewax
     */
    public function notTimewax(): self
    {
        return $this->filter(function ($event) {
            $noDescription = empty($event->description);
            $timewaxEvent = strpos($event->description, 'Timewax boeking') !== false;
            return $noDescription || !$timewaxEvent;
        });
    }
}
