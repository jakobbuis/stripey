<?php

namespace App;

/**
 * Rendering profile pictures based on Google and Gravatar
 */
trait HasAvatar
{
    public function avatar(): string
    {
        if (!empty($this->photo)) {
            return $this->photo;
        }

        // Fallback to Gravatar
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=96";
    }
}
