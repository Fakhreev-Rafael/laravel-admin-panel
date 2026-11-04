<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\ActionAccessServiceInterface;
use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\RecordQueryServiceInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class RecordQueryService implements RecordQueryServiceInterface
{
    /**
     * @param \App\Contracts\Services\EntityRegistryInterface $entityRegistry
     * @param \App\Contracts\Services\ActionAccessServiceInterface $actionAccessService
     */
    public function __construct(
        protected EntityRegistryInterface $entityRegistry,
        protected ActionAccessServiceInterface $actionAccessService
    ) {}

    /**
     * @inheritdoc
     */
    public function apply(
        Employee $employee,
        string $entity,
        string $action,
        Builder $query
    ): Builder {
        $config = $this->entityRegistry->get($entity);

        if (empty($config)) {
            return $this->deny($query);
        }

        $model = $config['model'] ?? null;

        if (
            !is_string($model) ||
            !is_a($query->getModel(), $model)
        ) {
            return $this->deny($query);
        }

        $actionScopes = $config['actions'][$action]['scopes']
            ?? null;

        if ($actionScopes === null) {
            return $this->deny($query);
        }

        $recordScopes = $config['record_scopes'] ?? [];

        // Доступ ко всем записям.
        if (
            in_array('all', $actionScopes, true) &&
            in_array('all', $recordScopes, true) &&
            $this->actionAccessService->can(
                $employee,
                $entity,
                $action,
                'all'
            )
        ) {
            return $query;
        }

        // Доступ только к собственным записям.
        if (
            in_array('own', $actionScopes, true) &&
            in_array('own', $recordScopes, true) &&
            $this->actionAccessService->can(
                $employee,
                $entity,
                $action,
                'own'
            )
        ) {
            $ownerField = $config['owner_field'] ?? null;

            if (
                !is_string($ownerField) ||
                $ownerField === ''
            ) {
                return $this->deny($query);
            }

            // Поле владельца должно быть зарегистрировано.
            if (!array_key_exists(
                $ownerField,
                $config['fields'] ?? []
            )) {
                return $this->deny($query);
            }

            return $query->where(
                $query->getModel()->qualifyColumn($ownerField),
                $employee->getKey()
            );
        }

        return $this->deny($query);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function deny(Builder $query): Builder
    {
        return $query->whereRaw('1 = 0');
    }
}