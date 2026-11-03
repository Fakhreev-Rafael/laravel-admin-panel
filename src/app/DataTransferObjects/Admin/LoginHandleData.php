<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Admin;

use App\Helpers\DataTransferObject;
use Illuminate\Foundation\Http\FormRequest;

class LoginHandleData extends DataTransferObject
{
    /**
     * @param string $email
     * @param string $password
     * @param bool $remember
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember = false
    )
    {}

    /**
     * @inheritdoc
     */
    public static function fromRequest(FormRequest $request): static
    {
        return new static(
            $request->input('email'),
            $request->input('password'),
            $request->input('remember')
        );
    }
}