<?php

declare(strict_types=1);

namespace App\Contracts\Actions\Admin;

use App\DataTransferObjects\Admin\LoginHandleData;

interface LoginHandleActionInterface
{
    /**
     * Execute this action.
     * 
     * @param \App\DataTransferObjects\Admin\LoginHandleData $data
     * 
     * @return void
     * 
     * @throws \App\Exceptions\EmployeeNotFoundException
     * @throws \App\Exceptions\InvalidPasswordException
     */
    public function execute(LoginHandleData $data): void;
    
}