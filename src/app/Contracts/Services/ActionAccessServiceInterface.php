<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Employee;

interface ActionAccessServiceInterface
{
    /**
     * Check for action level.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * @param string $action
     * @param ?string $scope = null
     * 
     * @return bool
     */
    public function can(Employee $employee, string $entity, string $action, ?string $scope = null): bool;
}