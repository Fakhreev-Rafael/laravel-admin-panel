<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * Return employee by email or return null.
     * 
     * @param string $email
     * 
     * @return \App\Models\Employee|null
     */
    public function getByEmail(string $email): ?Employee;
}