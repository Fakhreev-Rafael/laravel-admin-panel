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
     * @param bool $remember
     * 
     * @return bool
     */
    public function login(Guards $guard, array $credentials, bool $remember): bool;

    /**
     * Logout the user.
     * 
     * @return void
     */
    public function logout(): void;

    /**
     * Compare the password and the hashed password.
     * 
     * @param string $password
     * @param string $hashedPassword
     * 
     * @return bool
     */
    public function verifyPassword(string $password, string $hashedPassword): bool;

    /**
     * Return the current user.
     *  
     * @return \App\Models\Employee 
     */
    public function getCurrentEmployee(): Employee;
}