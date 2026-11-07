<?php

declare(strict_types=1);

namespace App\ViewModels\Admin;

use App\Collections\EntitySortCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionIndexViewModel
{
    /**
     * @param \Illuminate\Pagination\LengthAwarePaginator $permissions
     * @param \App\Collections\EntitySortCollection $availableSorts
     */
    public function __construct(
        protected LengthAwarePaginator $permissions,
        protected EntitySortCollection $availableSorts,
    ) {}

    /**
     * Return permissions.
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function permissions(): LengthAwarePaginator
    {
        return $this->permissions;
    }

    /**
     * Return sort options.
     * 
     * @return array
     */
    public function sortOptions(): array
    {
        $fieldLabels = [
            'id' => 'ID',
            'slug' => __('headings.name'),
            'entity' => __('headings.entity'),
            'created_at' => __('headings.created_at'),
            'updated_at' => __('headings.updated_at'),
        ];

        $options = [];

        foreach ($this->availableSorts as $sort) {
            $field = $sort->field;
            $direction = $sort->direction;

            $options[] = [
                'value' => "{$field}_{$direction}",
                'translated_name' => (
                    $fieldLabels[$field] ?? $field
                ) . ': ' . (
                    $direction === 'asc'
                    ? __('labels.ascending')
                    : __('labels.descending')
                ),
                'is_default' => $sort->is_default,
            ];
        }

        return $options;
    }
    /*

                    


                              <div class="table__data table__data-actions">
                    <a class="button button-icon button-icon--primary" title="{{ __('titles.edit') }}" href="#">
                        <x-admin.icons.pencil class="icon--s icon--primary" />
                    </a>
                    <form action="#">
                        <button class="button button-icon button-icon--small button-icon--primary" title="{{ __('titles.delete') }}">
                            <x-admin.icons.delete class="icon--s icon--error" />
                        </button>
                    </form>
                </div>
                    */
}
