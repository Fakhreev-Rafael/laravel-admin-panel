<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Contracts\Actions\Admin\LogoutHandleActionInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Helpers\Logger;

class LogoutHandleAction implements LogoutHandleActionInterface
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
    public function execute(): void
    {
        $this->authService->logout();
    }
}