<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = $this->getEntities();

        DB::transaction(function () use ($entities): void {
            foreach ($entities as $slug => $config) {
                // Не перезаписываем существующую конфигурацию.
                if (Entity::where('slug', $slug)->exists()) {
                    continue;
                }

                $entity = Entity::create([
                    'slug' => $slug,
                    'model' => $config['model'],
                    'label' => $config['label'],
                    'owner_field' => $config['owner_field'] ?? null,
                ]);

                foreach ($config['actions'] as $action => $scopes) {
                    $entityAction = $entity->actions()->create([
                        'action' => $action,
                    ]);

                    foreach ($scopes as $scope) {
                        $entityAction->scopes()->create([
                            'scope' => $scope,
                        ]);
                    }
                }

                foreach ($config['fields'] as $field => $fieldConfig) {
                    $entityField = $entity->fields()->create([
                        'field' => $field,
                    ]);

                    foreach ($fieldConfig['actions'] as $action) {
                        $entityField->actions()->create([
                            'action' => $action,
                        ]);
                    }

                    if (isset($fieldConfig['sort'])) {
                        $sort = $fieldConfig['sort'];

                        $directions = $sort['directions']
                            ?? ['asc', 'desc'];

                        $entityField->sort()->create([
                            'is_default' => $sort['default'] ?? false,
                            'default_direction' =>
                            $sort['default_direction'] ?? 'asc',
                            'allow_asc' => in_array(
                                'asc',
                                $directions,
                                true
                            ),
                            'allow_desc' => in_array(
                                'desc',
                                $directions,
                                true
                            ),
                        ]);
                    }
                }

                foreach ($config['record_scopes'] as $scope) {
                    $entity->recordScopes()->create([
                        'scope' => $scope,
                    ]);
                }
            }
        });
    }

    private function getEntities(): array
    {
        $actions = [
            'view' => ['own', 'all'],
            'create' => ['own', 'all'],
            'update' => ['own', 'all'],
            'delete' => ['own', 'all'],
        ];

        return [
            'permissions' => [
                'model' => \App\Models\Permission::class,
                'label' => 'entities.permission',
                'actions' => $actions,
                'fields' => [
                    'id' => [
                        'actions' => ['view'],
                        'sort' => [
                            'default' => true,
                            'default_direction' => 'desc',
                        ],
                    ],
                    'slug' => [
                        'actions' => ['view'],
                        'sort' => [],
                    ],
                    'entity' => [
                        'actions' => ['view'],
                    ],
                    'action' => [
                        'actions' => ['view'],
                    ],
                    'scope' => [
                        'actions' => ['view'],
                    ],
                    'field' => [
                        'actions' => ['view'],
                    ],
                    'is_system' => [
                        'actions' => ['view'],
                    ],
                    'created_at' => [
                        'actions' => ['view'],
                    ],
                    'updated_at' => [
                        'actions' => ['view'],
                    ],
                ],
                'record_scopes' => ['all'],
            ],

            'roles' => [
                'model' => \App\Models\Role::class,
                'label' => 'entities.role',
                'actions' => $actions,
                'fields' => [
                    'id' => [
                        'actions' => ['view'],
                        'sort' => [
                            'default' => true,
                            'default_direction' => 'desc',
                        ],
                    ],
                    'name' => [
                        'actions' => ['view', 'update'],
                        'sort' => [],
                    ],
                    'slug' => [
                        'actions' => ['view'],
                    ],
                    'description' => [
                        'actions' => ['view', 'update'],
                    ],
                    'is_system' => [
                        'actions' => ['view'],
                    ],
                    'created_at' => [
                        'actions' => ['view'],
                    ],
                    'updated_at' => [
                        'actions' => ['view'],
                    ],
                ],
                'record_scopes' => ['all'],
            ],

            'employees' => [
                'model' => \App\Models\Employee::class,
                'label' => 'entities.employee',
                'owner_field' => 'id',
                'actions' => $actions,
                'fields' => [
                    'id' => [
                        'actions' => ['view'],
                        'sort' => [
                            'default' => true,
                            'default_direction' => 'desc',
                        ],
                    ],
                    'email' => [
                        'actions' => ['view', 'update'],
                        'sort' => [],
                    ],
                    'lastname' => [
                        'actions' => ['view', 'update'],
                        'sort' => [],
                    ],
                    'firstname' => [
                        'actions' => ['view', 'update'],
                        'sort' => [],
                    ],
                    'avatar' => [
                        'actions' => ['view', 'update'],
                    ],
                    'created_at' => [
                        'actions' => ['view'],
                    ],
                    'updated_at' => [
                        'actions' => ['view'],
                    ],
                ],
                'record_scopes' => ['own', 'all'],
            ],
        ];
    }
}
