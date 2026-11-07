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
use Illuminate\Validation\ValidationException;

class LoginHandleAction implements LoginHandleActionInterface
{
    /**
     * @param \App\Contracts\Services\AuthServiceInterface $authService
     */
    public function __construct(
        protected AuthServiceInterface $authService
        )
    {}

    /**
     * @inheritdoc
     */
    public function execute(LoginHandleData $data): void
    {
        $credentials = [
            'email' => $data->email,
            'password' => $data->password,
        ];

        $authenticated = $this->authService->login(
            Guards::Employee,
            $credentials,
            $data->remember
        );

        if (!$authenticated) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }
}