<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Services\RecordQueryServiceInterface;
use App\Models\Employee;
use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionRepository implements PermissionRepositoryInterface
{
    /**
     * @param \App\Contracts\Services\RecordQueryServiceInterface $recordQueryService
     */
    public function __construct(
        protected RecordQueryServiceInterface $recordQueryService
    ) {}

    /**
     * @inheritdoc
     */
    public function getWithPaginate(Employee $employee, int $perPage, array $sort, array $fields): LengthAwarePaginator
    {
        $query = $this->recordQueryService->apply(
            $employee,
            'permissions',
            'view',
            Permission::query()
        );

        $selectFields = array_values(array_unique([
            'id',
            ...$fields,
        ]));

        return $query
            ->select($selectFields)
            ->orderBy(
                $sort['field'],
                $sort['direction']
            )
            ->paginate($perPage)
            ->withQueryString();
    }
}
