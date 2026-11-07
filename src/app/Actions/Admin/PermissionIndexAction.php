<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Contracts\Actions\Admin\PermissionIndexActionInterface;
use App\Contracts\Repositories\EntitySortRepositoryInterface;
use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\ViewModels\Admin\PermissionIndexViewModel;

class PermissionIndexAction implements PermissionIndexActionInterface
{
    /**
     * @param \App\Contracts\Repositories\PermissionRepositoryInterface $permissionRepository 
     * @param \App\Contracts\Repositories\EntitySortRepositoryInterface $entitySortRepository
     */
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository,
        protected EntitySortRepositoryInterface $entitySortRepository
    ) {}

    public function execute(?string $sort): PermissionIndexViewModel
    {
        $availableSorts = $this->entitySortRepository
            ->getActiveByEntity('permissions');

        $permissions = $this->permissionRepository->getWithPaginate(
            10,
            $availableSorts->resolve($sort)
        );

        return new PermissionIndexViewModel(
            permissions: $permissions,
            availableSorts: $availableSorts,
        );
    }
}
