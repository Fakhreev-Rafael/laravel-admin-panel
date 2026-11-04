<?php

declare(strict_types=1);

namespace App\ViewModels\Admin;

use Illuminate\Pagination\LengthAwarePaginator;

class PermissionIndexViewModel
{
    public function __construct(
        protected LengthAwarePaginator $permissions,
        protected array $availableSort,
        protected array $sort,
        protected array $allowedFields,
    ) {}

    public function permissions(): LengthAwarePaginator
    {
        return $this->permissions;
    }

    public function availableSort(): array
    {
        return $this->availableSort;
    }

    public function sort(): array
    {
        return $this->sort;
    }

    public function canViewField(string $field): bool
    {
        return in_array($field, $this->allowedFields, true);
    }

    public function sortOptions(): array
    {
        $options = [];

        $fieldLabels = [
            'id' => 'ID',
            'slug' => __('headings.name'),
            'entity' => __('headings.entity'),
            'created_at' => __('headings.created_at'),
            'updated_at' => __('headings.updated_at'),
        ];

        foreach ($this->availableSort as $field => $config) {
            $label = $fieldLabels[$field] ?? $field;

            foreach ($config['sort']['directions'] ?? [] as $direction) {
                $options[] = [
                    'value' => "{$field}_{$direction}",
                    'translated_name' => $label . ': ' . (
                        $direction === 'asc'
                        ? __('labels.ascending')
                        : __('labels.descending')
                    ),
                ];
            }
        }

        return $options;
    }

    public function currentSort(): array
    {
        $value = "{$this->sort['field']}_{$this->sort['direction']}";

        foreach ($this->sortOptions() as $option) {
            if ($option['value'] === $value) {
                return $option;
            }
        }

        return [
            'value' => $value,
            'translated_name' => $value,
        ];
    }
}
