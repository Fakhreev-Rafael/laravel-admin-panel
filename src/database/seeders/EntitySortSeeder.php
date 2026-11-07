<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\EntitySort;
use Illuminate\Database\Seeder;

final class EntitySortSeeder extends Seeder
{
    public function run(): void
    {
        $sorts = [
            'permissions' => [
                ['id', 'asc', true],
                ['id', 'desc', false],
                ['slug', 'asc', false],
                ['slug', 'desc', false],
                ['entity', 'asc', false],
                ['entity', 'desc', false],
            ],
            'roles' => [
                ['name', 'asc', true],
                ['name', 'desc', false],
                ['created_at', 'asc', false],
                ['created_at', 'desc', false],
            ],
            'employees' => [
                ['lastname', 'asc', true],
                ['lastname', 'desc', false],
                ['email', 'asc', false],
                ['email', 'desc', false],
            ],
        ];

        foreach ($sorts as $entity => $items) {
            foreach ($items as [$field, $direction, $isDefault]) {
                EntitySort::query()->firstOrCreate(
                    [
                        'entity' => $entity,
                        'field' => $field,
                        'direction' => $direction,
                    ],
                    [
                        'is_active' => true,
                        'is_default' => $isDefault,
                    ]
                );
            }
        }
    }
}