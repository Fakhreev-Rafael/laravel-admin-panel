<?php

declare(strict_types=1);

namespace App\Contracts\Sorts;

use App\Builders\PermissionBuilder;
use App\Models\SortField;

interface PermissionSortInterface
{
    /**
     * Applying the current sorting for permissions.
     * 
     * @param \App\Buiders\PermissionBuidler $query
     * @param \App\Models\SortField $sortField
     * 
     * @return \App\Builders\PermissionBuilder
     */
    public function apply(PermissionBuilder $query, SortField $sortField): PermissionBuilder;

}