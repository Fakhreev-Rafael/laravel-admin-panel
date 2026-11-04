<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    /**
     * Return permissions with paginate.
     * 
     * @param \App\Models\Employee $employee
     * @param int $perPage
     * @param array $sort
     * @param array $fields
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getWithPaginate(Employee $employee, int $perPage, array $sort, array $fields): LengthAwarePaginator;

}