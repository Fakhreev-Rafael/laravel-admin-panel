<?php

namespace App\Providers;

use App\Contracts\Services\PermissionServiceInterface;
use App\Enums\Permissions;
use App\Models\Employee;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(PermissionServiceInterface $permissionService): void
    {
        foreach (Permissions::cases() as $permission) {
            Gate::define(
                $permission->value,
                fn (Employee $employee): bool =>
                    $permissionService->can($employee, $permission)
            );
        }
    }
}
