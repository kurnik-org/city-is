<?php

namespace App\Enums;

enum UserSeederEnum: int
{
    case CITIZEN = 1;
    case CITY_ADMIN = 2;
    case TECHNICIAN = 3;
}
