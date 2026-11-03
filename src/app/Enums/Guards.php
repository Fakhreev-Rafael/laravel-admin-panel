<?php

declare(strict_types=1);

namespace App\Enums;

enum Guards: string 
{
    case User = 'user';
    case Employee = 'employee';
}