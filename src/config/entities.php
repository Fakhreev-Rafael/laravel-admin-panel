<?php

declare(strict_types=1);

return [
    'permissions' => [
        'model' => App\Models\Permission::class,
        'label' => 'entities.permission',
        'actions' => [
            'view' => [
                'name' => 'permissions.permission.view',
                'description' => 'permissions.permission.view_description',
                'scopes' => ['own', 'all'],
            ],
            'create' => [
                'name' => 'permissions.permission.create',
                'description' => 'permissions.permission.create_description',
                'scopes' => ['own', 'all'],
            ],
            'update' => [
                'name' => 'permissions.permission.update',
                'description' => 'permissions.permission.update_description',
                'scopes' => ['own', 'all'],
            ],
            'delete' => [
                'name' => 'permissions.permission.delete',
                'description' => 'permissions.permission.delete_description',
                'scopes' => ['own', 'all'],
            ],
        ],
        'fields' => [
            'id' => [
                'actions' => ['view'],
                'sort' => [
                    'default' => true,
                    'default_direction' => 'asc',
                    'directions' => [
                        'asc', 
                        'desc',
                    ]
                ],
            ],
            'slug' => [
                'actions' => ['view'],
                'sort' => [],
            ],
            'entity' => [
                'actions' => ['view'],
                'sort' => [],

            ],
            'scope' => [
                'actions' => ['view'],
                'sort' => [],
            ],
            'is_system' => [
                'actions' => ['view'],
                'sort' => [],
            ],
            'created_at' => [
                'actions' => ['view'],
                'sort' => [
                    'directions' => [
                        'asc', 
                        'desc',
                    ]
                ],
            ],
            'updated_at' => [
                'actions' => ['view'],
                'sort' => [
                    'directions' => [
                        'asc', 
                        'desc',
                    ]
                ],
            ],
        ],
        'record_scopes' => ['all'],
    ],

    'roles' => [
        'model' => App\Models\Role::class,
        'label' => 'entities.role',
        'actions' => [
            'view' => [
                'name' => 'permissions.role.view',
                'description' => 'permissions.role.view_description',
                'scopes' => ['own', 'all'],
            ],
            'create' => [
                'name' => 'permissions.role.create',
                'description' => 'permissions.role.create_description',
                'scopes' => ['own', 'all'],
            ],
            'update' => [
                'name' => 'permissions.role.update',
                'description' => 'permissions.role.update_description',
                'scopes' => ['own', 'all'],
            ],
            'delete' => [
                'name' => 'permissions.role.delete',
                'description' => 'permissions.role.delete_description',
                'scopes' => ['own', 'all'],
            ],
        ],
        'fields' => [
            'id' => [
                'actions' => ['view'],
                'sort' => [
                    'default' => true,
                    'default_direction' => 'asc',
                    'directions' => [
                        'asc', 
                        'desc',
                    ]
                ],
            ],
            'name' => [
                'actions' => ['view', 'update'],
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
        'model' => App\Models\Employee::class,
        'label' => 'entities.employee',

        'owner_field' => 'id',

        'actions' => [
            'view' => [
                'name' => 'permissions.employee.view',
                'description' => 'permissions.employee.view_description',
                'scopes' => ['own', 'all'],
            ],
            'create' => [
                'name' => 'permissions.employee.create',
                'description' => 'permissions.employee.create_description',
                'scopes' => ['own', 'all'],
            ],
            'update' => [
                'name' => 'permissions.employee.update',
                'description' => 'permissions.employee.update_description',
                'scopes' => ['own', 'all'],
            ],
            'delete' => [
                'name' => 'permissions.employee.delete',
                'description' => 'permissions.employee.delete_description',
                'scopes' => ['own', 'all'],
            ],
        ],
        'fields' => [
            'id' => [
                'actions' => ['view'],
            ],

            'email' => [
                'actions' => ['view', 'update'],
            ],

            'lastname' => [
                'actions' => ['view', 'update'],
            ],

            'firstname' => [
                'actions' => ['view', 'update'],
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
