<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        foreach (Permissions::cases() as $permission) {
            [$entity, $action] = explode('.', $permission->value, 2);

            Permission::query()->updateOrCreate(
                ['slug' => $permission->value],
                [
                    'entity' => $entity,
                    'action' => $action,
                    'is_system' => true,
                ]
            );
        }
    }
}
