<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\PermissionSyncServiceInterface;
use App\Models\Permission;
use Override;

class PermissionSyncService implements PermissionSyncServiceInterface
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
    public function sync(): void
    {
        foreach ($this->entityRegistry->all() as $entity => $config) {
            foreach ($config['actions'] as $action => $actionConfig) {
                $scopes = $actionConfig['scopes'] ?? [];

                if (empty($scopes)) {
                    $this->createPermission($entity, $action);

                    continue;
                }

                foreach ($scopes as $scope) {
                    $this->createPermission($entity, $action, $scope);
                }
            }

            foreach ($config['fields'] ?? [] as $field => $fieldConfig) {
                foreach ($fieldConfig['actions'] as $action) {
                    Permission::firstOrCreate(
                        [
                            'slug' => "{$entity}.field.{$field}.{$action}",
                        ],
                        [
                            'entity' => $entity,
                            'action' => $action,
                            'scope' => null,
                            'field' => $field,
                            'is_system' => true,
                        ]
                    );
                }
            }
        }
    }

    /**
     * Create a permission.
     * 
     * @param string $entity
     * @param string $action
     * @param ?string $scope = null
     * 
     * @return void
     */
    private function createPermission(string $entity, string $action, ?string $scope = null): void
    {
        $slug = "{$entity}.{$action}";

        if ($scope !== null) {
            $slug .= ".{$scope}";
        }

        Permission::firstOrCreate(
            ['slug' => $slug],
            [
                'entity' => $entity,
                'action' => $action,
                'scope' => $scope,
                'field' => null,
                'is_system' => true,
            ]
        );
    }
}
