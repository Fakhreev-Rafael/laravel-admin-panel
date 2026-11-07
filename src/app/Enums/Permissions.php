<?php

declare(strict_types=1);

namespace App\Enums;

enum Permissions: string
{
    case EmployeesView = 'employees.view';
    case EmployeesCreate = 'employees.create';
    case EmployeesUpdate = 'employees.update';
    case EmployeesDelete = 'employees.delete';

    case RolesView = 'roles.view';
    case RolesCreate = 'roles.create';
    case RolesUpdate = 'roles.update';
    case RolesDelete = 'roles.delete';

    case PermissionsView = 'permissions.view';
}