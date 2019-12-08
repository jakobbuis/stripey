<?php

return [
    /*
     * Start of the business day
     */
    'sob' => '09:00',

    /*
     * Close of business
     */
    'cob' => '17:30',

    /**
     * A lot of logic in stripey is dependent on the current day, which makes it
     * tough to work on Stripey development on weekends. Setting the date override
     * overrides the Carbon::now() behaviour when dealing with calendars.
     */
    'carbon_override' => env('CARBON_OVERRIDE', null),
];
