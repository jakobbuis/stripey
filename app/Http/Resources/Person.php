<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Person extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'avatar' => $this->avatar(),
            'location' => $this->location(),
        ];
    }
}
