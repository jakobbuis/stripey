<?php

return [
    /*
     * The main menu contains a button for users to direct their support questions.
     * This links directly into Slack, to the given team & user.
     */
    'support_url' = 'slack://user?team=' . env('SLACK_TEAM_ID') . '&id=' . env('SLACK_CONVERSATION_ID'),
];
