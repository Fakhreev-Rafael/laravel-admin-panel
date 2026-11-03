<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

interface RecordAccessServiceInterface
{
    /**
     * Check for record level.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * @param string $action
     * @param \Illuminate\Database\Eloquent\Model $record
     * 
     * @return bool
     */
    public function can(
        Employee $employee,
        string $entity,
        string $action,
        Model $record
    ): bool;
}