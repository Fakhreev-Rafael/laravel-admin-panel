<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\PermissionSyncServiceInterface;
use App\Models\Permission;
use Override;
use Illuminate\Support\Facades\DB;

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
        $slugs = $this->getExpectedSlugs();

        DB::transaction(function () use ($slugs): void {
            foreach ($slugs as $slug) {
                Permission::firstOrCreate(
                    ['slug' => $slug],
                    $this->getAttributes($slug)
                );
            }
        });
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function getObsoleteSlugs(): array
    {
        $expected = $this->getExpectedSlugs();

        return Permission::query()
            ->where('is_system', true)
            ->whereNotIn('slug', $expected)
            ->pluck('slug')
            ->all();
    }

    /**
     * Return slugs.
     * 
     * @return array
     */
    private function getExpectedSlugs(): array
    {
        $slugs = [];

        foreach ($this->entityRegistry->all() as $entity => $config) {
            foreach ($config['actions'] ?? [] as $action => $actionConfig) {
                $scopes = $actionConfig['scopes'] ?? [];

                if (empty($scopes)) {
                    $slugs[] = "{$entity}.{$action}";
                    continue;
                }

                foreach ($scopes as $scope) {
                    $slugs[] = "{$entity}.{$action}.{$scope}";
                }
            }

            foreach ($config['fields'] ?? [] as $field => $fieldConfig) {
                foreach ($fieldConfig['actions'] ?? [] as $action) {
                    $slugs[] = "{$entity}.field.{$field}.{$action}";
                }
            }
        }

        return array_values(array_unique($slugs));
    }

    /**
     * Return attributes.
     * 
     * @param string $slug
     * 
     * @return array
     */
    private function getAttributes(string $slug): array
    {
        $parts = explode('.', $slug);

        if (($parts[1] ?? null) === 'field') {
            return [
                'entity' => $parts[0],
                'action' => $parts[3],
                'scope' => null,
                'field' => $parts[2],
                'is_system' => true,
            ];
        }

        return [
            'entity' => $parts[0],
            'action' => $parts[1],
            'scope' => $parts[2] ?? null,
            'field' => null,
            'is_system' => true,
        ];
    }
}
