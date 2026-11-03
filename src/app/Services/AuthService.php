<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\Enums\Guards;
use App\Helpers\Logger;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    /**
     * @inheritdoc
     */
    public function login(Guards $guard, array $credentials, bool $remember): bool
    {
        $result = Auth::guard($guard->value)->attempt($credentials, $remember);

        Logger::application()->info('Authentication', [
            'is_authenticated' => $result,
            'guard' => $guard->value,
            'credentials' => $credentials,
            'remember' => $remember,
        ]);

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function logout(): void
    {
        $user = Auth::user();

        Auth::logout();

        Logger::application()->info('The employee has logged out', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        $result = Hash::check($password, $hashedPassword);

        Logger::application()->info('Verifying password', [
            'password' => $password,
            'is_verified' => $result,
        ]);

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentEmployee(): Employee
    {
        $employee = Auth::user();

        Logger::application()->info('Getting the current authenticated employee', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'email' => $employee->email,
        ]);
        return $employee;
    }
}
