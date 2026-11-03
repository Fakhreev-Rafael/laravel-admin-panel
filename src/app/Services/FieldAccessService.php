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
        if (!$this->entityRegistry->has($entity)) {
            return false;
        }

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

        $slug = "{$entity}.field.{$field}.{$action}";

        return $employee->roles()
            ->whereHas('permissions', function ($query) use ($slug) {
                $query->where('slug', $slug);
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
        $allowedFields = [];

        foreach ($this->entityRegistry->fields($entity) as $field => $config) {
            if ($this->can($employee, $entity, $field, $action)) {
                $allowedFields[] = $field;
            }
        }

        return $allowedFields;
    }
}