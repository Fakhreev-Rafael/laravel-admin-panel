<?php

namespace Database\Seeders;

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
        $role = Role::query()->firstOrCreate(
            [
                'slug' => 'root',
            ],
            [
                'name' => 'Root',
                'description' => 'System root',
                'is_system' => true,
            ]
        );

        $role->permissions()->sync(
            Permission::query()->pluck('id')->all()
        );
    }
}
