<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\FieldAccessServiceInterface;
use App\Models\Employee;

class FieldAccessService implements FieldAccessServiceInterface
{
    /**
     * @param \App\Contracts\Services\EntityRegistryInterface $entityRegistry
     */
    public function __construct(
        protected EntityRegistryInterface $entityRegistry
    ) {}

    /**
     * @inheritdoc
     */
    public function can(
        Employee $employee,
        string $entity,
        string $field,
        string $action
    ): bool {
        $fields = $this->entityRegistry->fields($entity);

        if (!isset($fields[$field])) {
            return false;
        }

        if (!in_array(
            $action,
            $fields[$field]['actions'] ?? [],
            true
        )) {
            return false;
        }

        return $employee->roles()
            ->whereHas('permissions', function ($query) use (
                $entity,
                $field,
                $action
            ) {
                $query->where(
                    'slug',
                    "{$entity}.field.{$field}.{$action}"
                );
            })
            ->exists();
    }

    /**
     * @inheritdoc
     */
    public function getAllowedFields(
        Employee $employee,
        string $entity,
        string $action
    ): array {
        $fields = $this->entityRegistry->fields($entity);

        if (empty($fields)) {
            return [];
        }

        $available = [];

        foreach ($fields as $field => $config) {
            if (in_array(
                $action,
                $config['actions'] ?? [],
                true
            )) {
                $available[] = $field;
            }
        }

        if (empty($available)) {
            return [];
        }

        $slugs = array_map(
            fn(string $field): string =>
            "{$entity}.field.{$field}.{$action}",
            $available
        );

        $allowedSlugs = $employee->roles()
            ->whereHas('permissions', function ($query) use ($slugs) {
                $query->whereIn('slug', $slugs);
            })
            ->with([
                'permissions' => function ($query) use ($slugs) {
                    $query->whereIn('slug', $slugs);
                },
            ])
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->unique()
            ->all();

        return array_values(array_filter(
            $available,
            fn(string $field): bool => in_array(
                "{$entity}.field.{$field}.{$action}",
                $allowedSlugs,
                true
            )
        ));
    }
}
