<?php

declare(strict_types=1);

namespace App\Sorts;

use App\Builders\PermissionBuilder;
use App\Contracts\Sorts\PermissionSortInterface;
use App\Models\SortField;

class PermissionSort implements PermissionSortInterface
{

    /**
     * @inheritdoc
     */
    public function apply(PermissionBuilder $query, SortField $sortField): PermissionBuilder
    {
        return $query->orderBy($sortField->field, $sortField->direction);
    }

}