<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Contracts\Actions\Admin\LoginHandleActionInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\DataTransferObjects\Admin\LoginHandleData;
use App\Exceptions\EmployeeNotFoundException;
use App\Exceptions\InvalidPasswordException;
use App\Enums\Guards;

class LoginHandleAction implements LoginHandleActionInterface
{
    /**
     * @param \App\Contracts\Repositories\EmployeeRepositoryInterface $employeeRepository
     * @param \App\Contracts\Services\AuthServiceInterface $authService
     */
    public function __construct(
        protected EmployeeRepositoryInterface $employeeRepository,
        protected AuthServiceInterface $authService
        )
    {}

    /**
     * @inheritdoc
     */
    public function execute(LoginHandleData $data): void
    {
        $employee = $this->employeeRepository->getByEmail($data->email);

        if(is_null($employee)) {
            throw new EmployeeNotFoundException("Employee is not found by email: {$data->email}");
        }

        if (!$this->authService->verifyPassword($data->password, $employee->password)) {
            throw new InvalidPasswordException("Password is invalid");
        }

        $credentials = [
            'email' => $data->email,
            'password' => $data->password,
        ];

        $this->authService->login(Guards::Employee, $credentials, $data->remember);
    }
}