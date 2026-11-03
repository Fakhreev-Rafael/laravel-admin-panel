<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Collections\FilterCollection;
use App\Collections\PermissionCollection;
use App\Contracts\Sorts\PermissionSortInterface;
use App\Models\SortField;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    /**
     * Return permissions with paginate.
     * 
     * @param int $perPage
     * @param array $sort
     * @param array $fields
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getWithPaginate(int $perPage, array $sort, array $fields): LengthAwarePaginator;

}