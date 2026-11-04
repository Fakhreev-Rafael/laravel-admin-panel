<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

interface RecordQueryServiceInterface
{
    /**
     * Apply record query.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * @param string $action
     * @param \Illuminate\Database\Eloquent\Builder $query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(
        Employee $employee,
        string $entity,
        string $action,
        Builder $query
    ): Builder;
}