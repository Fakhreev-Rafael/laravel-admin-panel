<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Foundation\Http\FormRequest;

abstract class DataTransferObject
{
    /**
     * Create data object from request.
     * 
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * 
     * @return static
     */
    abstract public static function fromRequest(FormRequest $request): static;
}