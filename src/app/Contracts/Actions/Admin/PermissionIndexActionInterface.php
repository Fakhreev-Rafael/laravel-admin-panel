<?php

declare(strict_types=1);

namespace App\Contracts\Actions\Admin;

use App\ViewModels\Admin\PermissionIndexViewModel;

interface PermissionIndexActionInterface
{
    /**
     * Execute this action.
     * 
     * @param string|null $sort
     * 
     * @return \App\ViewModels\Admin\PermissionIndexViewModel
     */
    public function execute(?string $sort): PermissionIndexViewModel;
}