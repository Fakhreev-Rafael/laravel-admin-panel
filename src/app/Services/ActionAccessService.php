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
    ) 
    {}

    /**
     * @inheritdoc
     */
    #[Override]
    public function can(Employee $employee, string $entity, string $action, ?string $scope = null): bool
    {
        if(! $this->entityRegistry->has($entity)) {
            return false;
        }

        $actions = $this->entityRegistry->actions($entity);

        if(! array_key_exists($action, $actions)) {
            return false;
        }

        $availableScopes = $actions[$action]['scopes'] ?? [];

        if(empty($availableScopes)) {
            if($scope !== null) {
                return false;
            }

            $slugs = ["{$entity}.{$action}"];
        } else {
            if($scope === null || !in_array($scope, $availableScopes, true)) {
                $slugs = ["{$entity}.{$action}.{$scope}"];

                if($scope === 'own' && in_array('all', $availableScopes, true)) {
                    $slugs[] = "{$entity}.{$action}.all";
                }
            }
        }

        return $employee->roles()
            ->whereHas('permissions', function ($query) use ($slugs) {
                $query->whereIn('slug', $slugs);
            })
            ->exists();
    }
}