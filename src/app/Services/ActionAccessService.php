<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\ActionAccessServiceInterface;
use App\Contracts\Services\EntityRegistryInterface;
use App\Models\Employee;
use Override;

class ActionAccessService implements ActionAccessServiceInterface
{
    /**
     * @param \App\Contracts\Services\EntityRegistryInterface $entityRegistry
     */
    public function __construct(
        private readonly EntityRegistryInterface $entityRegistry
    ) {}

    /**
     * @inheritdoc
     */
    #[Override]
    public function can(Employee $employee, string $entity, string $action, ?string $scope = null): bool
    {
        if (!$this->entityRegistry->has($entity)) {
            return false;
        }

        $actions = $this->entityRegistry->actions($entity);

        if (!isset($actions[$action])) {
            return false;
        }

        $scopes = $actions[$action]['scopes'] ?? [];

        if ($scope === null) {
            if (!empty($scopes)) {
                return false;
            }

            return $this->hasPermission(
                $employee,
                "{$entity}.{$action}"
            );
        }

        if (!in_array($scope, $scopes, true)) {
            return false;
        }

        if ($this->hasPermission(
            $employee,
            "{$entity}.{$action}.{$scope}"
        )) {
            return true;
        }

        // Разрешение all включает own.
        if ($scope === 'own' && in_array('all', $scopes, true)) {
            return $this->hasPermission(
                $employee,
                "{$entity}.{$action}.all"
            );
        }

        return false;
    }

    /**
     * Check for existing permission.
     * 
     * @param \App\Models\Employee $employee
     * @param string $slug
     * 
     * @return bool
     */
    private function hasPermission(Employee $employee, string $slug): bool {
        return $employee->roles()
            ->whereHas('permissions', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->exists();
    }
}
