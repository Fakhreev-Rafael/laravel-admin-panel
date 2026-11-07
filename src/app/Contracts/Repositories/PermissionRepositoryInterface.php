<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Employee;
use App\Models\EntitySort;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    /**
     * Return permissions with paginate.
     * 
     * @param int $perPage
     * @param \App\Models\EntitySort $entitySort
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getWithPaginate(int $perPage, EntitySort $entitySort): LengthAwarePaginator;

}