<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Helpers\Logger;
use App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getByEmail(string $email): ?Employee
    {
        $employee = Employee::where('email', $email)->first();

        Logger::database()->debug('Querying employee by email', [
            'email' => $email,
            'found' => !is_null($employee),
        ]);

        return $employee;
    }
}