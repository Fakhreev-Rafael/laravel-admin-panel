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
        foreach ($entityRegistry->all() as $entity => $config) {
            foreach ($config['actions'] as $action => $actionConfig) {
                $scopes = $actionConfig['scopes'] ?? [];

                if (empty($scopes)) {
                    Gate::define(
                        "{$entity}.{$action}",
                        fn($employee) => $actionAccessService->can(
                            $employee,
                            $entity,
                            $action
                        )
                    );

                    continue;
                }

                foreach ($scopes as $scope) {
                    Gate::define(
                        "{$entity}.{$action}.{$scope}",
                        fn($employee) => $actionAccessService->can(
                            $employee,
                            $entity,
                            $action,
                            $scope
                        )
                    );
                }

                Gate::define(
                    "{$entity}.{$action}.record",
                    fn(Employee $employee, Model $record): bool =>
                    $recordAccessService->can(
                        $employee,
                        $entity,
                        $action,
                        $record
                    )
                );
            }

            foreach ($config['fields'] ?? [] as $field => $fieldConfig) {
                foreach ($fieldConfig['actions'] ?? [] as $action) {
                    Gate::define(
                        "{$entity}.field.{$field}.{$action}",
                        fn(Employee $employee): bool =>
                        $fieldAccessService->can(
                            $employee,
                            $entity,
                            $field,
                            $action
                        )
                    );
                }
            }
        }
    }
}
