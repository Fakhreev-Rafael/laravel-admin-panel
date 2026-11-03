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
    public function can(Employee $employee, string $entity, string $action, Model $record): bool {
        $config = $this->entityRegistry->get($entity);

        if ($config === null) {
            return false;
        }

        if (!isset($config['model']) || !$record instanceof $config['model']) {
            return false;
        }

        $actions = $this->entityRegistry->actions($entity);

        if (!isset($actions[$action])) {
            return false;
        }

        $scopes = $actions[$action]['scopes'] ?? [];

        if (empty($scopes)) {
            return $this->actionAccessService->can(
                $employee,
                $entity,
                $action
            );
        }

        if (
            in_array('all', $scopes, true)
            && $this->actionAccessService->can($employee, $entity, $action, 'all')
        ) {
            return true;
        }

        if (!in_array('own', $scopes, true)) {
            return false;
        }

        if (!$this->actionAccessService->can($employee, $entity, $action, 'own')) {
            return false;
        }

        $ownerField = $config['owner_field'] ?? null;

        if ($ownerField === null) {
            return false;
        }

        $ownerId = $record->getAttribute($ownerField);

        return $ownerId !== null
            && (string) $ownerId === (string) $employee->getKey();
    }
}