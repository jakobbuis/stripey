<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasAvatar;

    protected $fillable = ['name', 'email', 'photo'];
}
