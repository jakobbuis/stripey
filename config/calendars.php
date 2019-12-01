<?php

return [
    /**
     * The shared calendar that lists people as away
     */
    'afwezig' => env('CALENDAR_AFWEZIG'),

    /**
     * A lot of logic in stripey is dependent on the current day, which makes it
     * tough to work on Stripey development on weekends. Setting the date override
     * overrides the Carbon::now() call.
     */
    'carbon_override' => env('CARBON_OVERRIDE', null),
];
