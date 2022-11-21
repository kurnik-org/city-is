<?php

namespace App\Enums;

enum TicketStateEnum: int
{
    case REPORTED = 0;
    case WIP = 1;
    case FIXED = 2;

    public function user_friendly_string(): string
    {
        return match($this)
        {
            self::REPORTED => 'Reported',
            self::WIP => 'Work in progress',
            self::FIXED => 'Solved',
        };
    }
}
