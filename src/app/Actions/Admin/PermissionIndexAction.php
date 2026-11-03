<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Contracts\Actions\Admin\PermissionIndexActionInterface;
use App\Contracts\Repositories\PermissionRepositoryInterface;
use App\Contracts\Repositories\SortFieldRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\FieldAccessServiceInterface;
use App\Contracts\Services\SortServiceInterface;
use App\ViewModels\Admin\PermissionIndexViewModel;
use Illuminate\Auth\Access\AuthorizationException;

class PermissionIndexAction implements PermissionIndexActionInterface
{
    /**
     * @param \App\Contracts\Repositories\PermissionRepositoryInterface $permissionRepository
     * @param \App\Contracts\Services\FieldAccessServiceInterface $fieldAccessService
     * @param \App\Contracts\Services\AuthServiceInterface $authService
     * @param \App\Contracts\Services\SortServiceInterface $sortService
     */
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository,
        protected FieldAccessServiceInterface $fieldAccessService,
        protected AuthServiceInterface $authService,
        protected SortServiceInterface $sortService
    ) {}

    /**
     * @inheritdoc
     */
    public function execute(?string $sort): PermissionIndexViewModel
    {
        $employee = $this->authService->getCurrentEmployee();

        $allowedFields = $this->fieldAccessService->getAllowedFields(
            $employee,
            'permissions',
            'view'
        );

        if (empty($allowedFields)) {
            throw new AuthorizationException(
                'No permitted fields are available.'
            );
        }

        $sort = $this->sortService->resolve(
            $employee,
            'permissions',
            $sort
        );

        $permissions = $this->permissionRepository
            ->getWithPaginate(10, $sort, $allowedFields);

        $availableSort = $this->sortService->getAvailable(
            $employee,
            'permissions'
        );

        return new PermissionIndexViewModel(
            $permissions,
            $availableSort,
            $sort
        );
    }
}
