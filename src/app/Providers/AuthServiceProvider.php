<?php

namespace App\Providers;

use App\Contracts\Services\ActionAccessServiceInterface;
use App\Contracts\Services\EntityRegistryInterface;
use App\Contracts\Services\FieldAccessServiceInterface;
use App\Contracts\Services\RecordAccessServiceInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(
        EntityRegistryInterface $entityRegistry,
        ActionAccessServiceInterface $actionAccessService,
        RecordAccessServiceInterface $recordAccessService,
        FieldAccessServiceInterface $fieldAccessService
    ): void {
        Gate::before(function (
            Employee $employee,
            string $ability,
            array $arguments = []
        ) use (
            $entityRegistry,
            $actionAccessService,
            $recordAccessService,
            $fieldAccessService
        ): ?bool {
            $parts = explode('.', $ability);

            $entity = $parts[0] ?? null;

            if (!$entity || !$entityRegistry->has($entity)) {
                return null;
            }

            // Проверка доступа к полю
            // employees.field.email.update

            if (
                count($parts) === 4 &&
                $parts[1] === 'field'
            ) {
                return $fieldAccessService->can(
                    $employee,
                    $entity,
                    $parts[2],
                    $parts[3]
                );
            }

            // Проверка доступа к конкретной записи
            // employees.update.record

            if (
                count($parts) === 3 &&
                $parts[2] === 'record'
            ) {
                $record = $arguments[0] ?? null;

                if (!$record instanceof Model) {
                    return false;
                }

                return $recordAccessService->can(
                    $employee,
                    $entity,
                    $parts[1],
                    $record
                );
            }

            // Проверка действия с областью доступа
            // employees.view.all

            if (count($parts) === 3) {
                return $actionAccessService->can(
                    $employee,
                    $entity,
                    $parts[1],
                    $parts[2]
                );
            }

            // Проверка действия без области доступа
            // employees.view

            if (count($parts) === 2) {
                return $actionAccessService->can(
                    $employee,
                    $entity,
                    $parts[1]
                );
            }

            return false;
        });
    }
}
