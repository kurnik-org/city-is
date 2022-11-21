<?php

namespace App\Enums;

enum ServiceRequestStateEnum: int
{
    case ASSIGNED = 0;
    case CLOSED = 1;

    public function user_friendly_string(): string
    {
        return match($this)
        {
            self::ASSIGNED => 'Assigned',
            self::CLOSED => 'Closed',
        };
    }
}
