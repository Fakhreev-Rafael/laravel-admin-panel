<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Models\EntitySort;
use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getWithPaginate(int $perPage, EntitySort $entitySort): LengthAwarePaginator
    {
        $query = Permission::query()
            ->orderBy($entitySort->field, $entitySort->direction);

        if($entitySort->field !== 'id') {
            $query->orderBy('id', 'asc');
        }
        return $query
            ->paginate($perPage)
            ->withQueryString();
    }
}
