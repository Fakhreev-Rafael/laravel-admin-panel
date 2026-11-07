<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        $root = Role::query()->updateOrCreate(
            [
                'slug' => Roles::Root->value,
            ],
            [
                'name' => 'Root',
                'description' => 'Полный доступ к системе',
                'is_system' => true,
            ]
        );

        $slugs = array_map(
            fn(Permissions $permission) => $permission->value,
            Permissions::cases()
        );

        $permissionIds = Permission::query()
            ->whereIn('slug', $slugs)
            ->pluck('id')
            ->all();

        $root->permissions()->sync($permissionIds);
    }
}
