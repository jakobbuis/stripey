<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['name', 'email', 'photo'];

    public function avatar(): string
    {
        // Once a user logs in, we store their avatar URL
        if ($this->photo) {
            return $this->photo;
        }

        // Fallback to Gravatar
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=96";
    }
}
