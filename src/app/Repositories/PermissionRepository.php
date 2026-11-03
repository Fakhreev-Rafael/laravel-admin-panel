<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Collections\FilterCollection;
use App\Collections\PermissionCollection;
use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Sorts\PermissionSortInterface;
use App\Helpers\Logger;
use App\Models\Permission;
use App\Models\SortField;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * @param \App\Contracts\Sorts\PermissionSortInterface $permissionSort
     */
    public function __construct(
        protected PermissionSortInterface $permissionSort
    ) {}

    /**
     * @inheritdoc
     */
    public function getWithPaginate(int $perPage, array $sort, array $fields): LengthAwarePaginator
    {
        return Permission::query()
            ->select($fields)
            ->orderBy(
                $sort['field'],
                $sort['direction']
            )
            ->paginate($perPage);
    }
}
