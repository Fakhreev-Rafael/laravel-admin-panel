<?php

declare(strict_types=1);

namespace App\Contracts\Actions\Admin;

interface LogoutHandleActionInterface
{
    /**
     * Execute this action.
     *  
     * @return void
     */
    public function execute(): void;
    
}