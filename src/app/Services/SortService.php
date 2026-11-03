<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\FieldAccessServiceInterface;
use App\Contracts\Services\SortServiceInterface;
use App\Models\Employee;
use Illuminate\Auth\Access\AuthorizationException;

class SortService implements SortServiceInterface
{
    /**
     * @param \App\Contracts\Services\EntityRegistryInterface $entityRegistry
     * @param \App\Contracts\Services\FieldAccessServiceInterface $fieldAccessService
     */
    public function __construct(
        protected EntityRegistryInterface $entityRegistry,
        protected FieldAccessServiceInterface $fieldAccessService
    ) {}

    /**
     * @inheritdoc
     */
    public function getAvailable(Employee $employee, string $entity): array {
        $sort = $this->entityRegistry->sort($entity);

        $allowedFields = $this->fieldAccessService->getAllowedFields(
            $employee,
            $entity,
            'view'
        );

        return array_filter(
            $sort,
            fn (array $config, string $field): bool =>
                in_array($field, $allowedFields, true),
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * @inheritdoc
     */
    public function resolve(Employee $employee, string $entity, ?string $sort): array {
        $available = $this->getAvailable($employee, $entity);

        if (empty($available)) {
            throw new AuthorizationException(
                'No permitted sort fields are available.'
            );
        }

        if ($sort !== null) {
            foreach ($available as $field => $config) {
                foreach ($config['sort']['directions'] ?? ['asc', 'desc'] as $direction) {
                    if ($sort === "{$field}_{$direction}") {
                        return [
                            'field' => $field,
                            'direction' => $direction,
                        ];
                    }
                }
            }
        }

        foreach ($available as $field => $config) {
            if (($config['sort']['default'] ?? false) === true) {
                $directions = $config['sort']['directions'] ?? ['asc', 'desc'];
                $direction = $config['sort']['default_direction'] ?? 'asc';

                if (in_array($direction, $directions, true)) {
                    return [
                        'field' => $field,
                        'direction' => $direction,
                    ];
                }
            }
        }

        $field = array_key_first($available);
        $config = $available[$field]['sort'];
        $directions = $config['directions'] ?? ['asc', 'desc'];

        return [
            'field' => $field,
            'direction' => $directions[0],
        ];
    }
}