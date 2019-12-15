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

    /**
     * Only include events this $email is attending
     */
    public function attending(string $email): self
    {
        return $this->filter(function ($event) use ($email) {
            $attendees = $event->attendees ?? [];
            if (count($attendees) === 0) {
                // If no attendees are set (but it is on our calendar), assume we are going
                return true;
            }
            // Otherwise, check our response
            $me = array_filter($attendees, function ($attendee) use ($email) {
                return $attendee->email === $email;
            });
            if (count($me) === 0) {
                // If we are not listed as an attendee (but it is on our calendar), assume we are going
                return true;
            }
            return in_array($me->responseStatus, ['accepted', 'tentative']);
        });
    }
}
