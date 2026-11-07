<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\Enums\Guards;
use App\Helpers\Logger;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Override;

class AuthService implements AuthServiceInterface
{
    /**
     * @inheritdoc
     */
    #[Override]
    public function login(Guards $guard, array $credentials, bool $remember = false): bool
    {
        return Auth::guard($guard->value)
            ->attempt($credentials, $remember);
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function logout(Guards $guard): void
    {
        Auth::guard($guard->value)->logout();
    }
}
