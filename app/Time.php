<?php

namespace App;

use Carbon\CarbonImmutable;

/*
 * To allow for time-shifting for testing and debugging, we encapsulate the
 * current
 */
class Time
{
    private $override;
    private $now;

    public function __construct()
    {
        $this->override = config('time.carbon_override');
        if ($this->override) {
            $this->now = CarbonImmutable::parse($this->override);
        } else {
            $this->now = CarbonImmutable::now();
        }
    }

    /**
     * Determine if we are current inside working hours (9AM - 17:30)
     */
    public function isWorkingHours(): bool
    {
        $now = $this->now;
        $sob = $now->setTimeFromTimeString(config('time.sob'));
        $cob = $now->setTimeFromTimeString(config('time.cob'));

        return $now->isWeekday() && $now >= $sob && $now <= $cob;
    }

    public function now(): CarbonImmutable
    {
        return $this->now;
    }
}
