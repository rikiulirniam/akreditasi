<?php

namespace App\Auth;

use Illuminate\Auth\GenericUser;
use JsonSerializable;

class JwtUser extends GenericUser implements JsonSerializable
{
    /**
     * Specify data which should be serialized to JSON.
     */
    public function jsonSerialize(): array
    {
        return $this->attributes;
    }

    /**
     * Mendapatkan role dalam huruf besar.
     */
    public function getRole(): string
    {
        return strtoupper((string) ($this->attributes['role'] ?? ''));
    }
}
