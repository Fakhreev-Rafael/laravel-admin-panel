<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Employee;

interface SortServiceInterface
{
    /**
     * Return available sort.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * 
     * @return array
     */
    public function getAvailable(Employee $employee, string $entity): array;

    /**
     * Resolve sort values.
     * 
     * @param \App\Models\Employee $employee
     * @param string $entity
     * @param ?string $sort
     * 
     * @return array
     */
    public function resolve(Employee $employee, string $entity, ?string $sort): array;
}