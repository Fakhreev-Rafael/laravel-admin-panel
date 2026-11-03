<?php

declare(strict_types=1);

namespace App\Enums;

enum RecordScope: string
{
    case Own = 'own';
    case Group = 'group';
    case All = 'all';
}