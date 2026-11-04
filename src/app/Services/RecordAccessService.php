<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\ActionAccessServiceInterface;
use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\RecordAccessServiceInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class RecordAccessService implements RecordAccessServiceInterface
{
    /**
     * @param \App\Contracts\Services\ActionAccessServiceInterface $actioinAccessService
     * @param \App\Contracts\Services\EntityRegistryInterface $entityRegistry
     */
    public function __construct(
        protected ActionAccessServiceInterface $actionAccessService,
        protected EntityRegistryInterface $entityRegistry,
    ) {}

    /**
     * @inheritdoc
     */
    public function can(Employee $employee, string $entity, string $action, Model $record): bool
    {
        if (!$this->entityRegistry->has($entity)) {
            return false;
        }

        $config = $this->entityRegistry->get($entity);

        if (!is_a($record, $config['model'])) {
            return false;
        }

        $actions = $config['actions'] ?? [];

        if (!isset($actions[$action])) {
            return false;
        }

        $actionScopes = $actions[$action]['scopes'] ?? [];

        // Действие без scopes.
        if (empty($actionScopes)) {
            return $this->actionAccessService->can(
                $employee,
                $entity,
                $action
            );
        }

        $recordScopes = $this->entityRegistry->recordScopes($entity);

        // Проверяем доступ ко всем записям.
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
            return true;
        }

        // Проверяем доступ только к собственной записи.
        if (
            !in_array('own', $actionScopes, true) ||
            !in_array('own', $recordScopes, true)
        ) {
            return false;
        }

        $ownerField = $config['owner_field'] ?? null;

        if ($ownerField === null) {
            return false;
        }

        if (!$this->actionAccessService->can(
            $employee,
            $entity,
            $action,
            'own'
        )) {
            return false;
        }

        return (string) $record->getAttribute($ownerField)
            === (string) $employee->getKey();
    }
}
