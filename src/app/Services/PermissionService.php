<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\PermissionServiceInterface;
use App\Enums\Permissions;
use App\Models\Employee;

final class PermissionService implements PermissionServiceInterface
{
    /**
     * @inheritdoc
     */
    public function can(Employee $employee, Permissions $permission): bool {
        
        return $employee->roles()
            ->whereHas(
                'permissions',
                fn ($query) => $query->where(
                    'slug',
                    $permission->value
                )
            )
            ->exists();
    }
}