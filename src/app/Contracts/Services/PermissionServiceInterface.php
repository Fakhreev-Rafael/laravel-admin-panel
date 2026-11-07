<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Enums\Permissions;
use App\Models\Employee;

interface PermissionServiceInterface
{
    /**
     * Check for permission.
     * 
     * @param \App\Models\Employee $employee
     * @param \App\Enum\Permission $permission
     * 
     * @return bool
     */
    public function can(Employee $employee, Permissions $permission): bool;
}