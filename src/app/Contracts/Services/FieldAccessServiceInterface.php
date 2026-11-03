<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Employee;

interface FieldAccessServiceInterface
{
    /**
     * Check for field level.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * @param string $field
     * @param string $action
     * 
     * @return bool
     */
    public function can(
        Employee $employee,
        string $entity,
        string $field,
        string $action
    ): bool;

    /**
     * Return allowed fields.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * @param string $action
     *
     * @return array 
     */
    public function getAllowedFields(
        Employee $employee,
        string $entity,
        string $action
    ): array;
}