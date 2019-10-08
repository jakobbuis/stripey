<?php

namespace App;

use App\Locator;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['name', 'email'];

    public function avatar() : string
    {
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=32";
    }

    public function location() : string
    {
        return app(Locator::class)->locate($this);
    }
}
