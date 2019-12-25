<?php

return [
    /*
     * The main menu contains a button for users to direct their support questions.
     */
    'support_url' => 'slack://user?team=' . env('SLACK_TEAM_ID') . '&id=' . env('SLACK_CONVERSATION_ID'),
];
