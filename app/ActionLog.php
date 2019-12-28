<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = ['action', 'user_id'];

    public static function logUsage(User $user): void
    {
        self::create(['action' => 'usage', 'user_id' => $user->id]);
    }
}
