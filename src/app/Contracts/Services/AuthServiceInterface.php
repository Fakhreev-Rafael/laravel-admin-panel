<?php

declare(strict_types=1);

namespace App\Contracts\Services;

use App\Enums\Guards;
use App\Models\Employee;

interface AuthServiceInterface
{
    /**
     * Login the user.
     * 
     * @param \App\Enums\Guards $guard
     * @param array $credentials
     * @param bool $remember = false
     * 
     * @return bool
     */
    public function login(Guards $guard, array $credentials, bool $remember = false): bool;

    /**
     * Logout the user.
     * 
     * @param \App\Enums\Guards $guard
     * 
     * @return void
     */
    public function logout(Guards $guard): void;
}