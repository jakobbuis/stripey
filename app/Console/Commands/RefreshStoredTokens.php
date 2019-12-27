<?php

namespace App\Console\Commands;

use App\StoredTokens;
use Illuminate\Console\Command;

/**
 * Refresh all OAuth tokens on file that are going to expire in the next
 * fifteen minutes.
 */
class RefreshStoredTokens extends Command
{
    protected $signature = 'oauth:tokens:refresh';
    protected $description = 'Refresh stale OAuth tokens';

    public function handle()
    {
        StoredTokens::refreshTokens();
    }
}
