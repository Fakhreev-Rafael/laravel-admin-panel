<?php

declare(strict_types=1);

namespace App\ViewModels\Admin;

use App\Collections\FilterCollection;
use App\Collections\SortFieldCollection;
use App\Models\SortField;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PermissionIndexViewModel
{
    /**
     * @param \Illuminate\Pagination\LengthAwarePaginator $permissions
     * @param array $availableSort
     * @param array $sort
     */
    public function __construct(
        protected LengthAwarePaginator $permissions,
        protected array $availableSort,
        protected array $sort,
    ) {}    

    /**
     * Return permissions for displaying.
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function permissions(): LengthAwarePaginator
    {
        return $this->permissions;
    }

}
