<?php

namespace App\Http\Resources;

use App\Locator\Locator;
use Illuminate\Http\Resources\Json\JsonResource;

class Person extends JsonResource
{
    public function toArray($request)
    {
        $status = (new Locator($this->resource))->status();

        return [
            'name' => $this->name,
            'avatar' => $this->avatar(),
            'status' => $status,
        ];
    }
}
