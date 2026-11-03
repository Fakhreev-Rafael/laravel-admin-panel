<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('auth.init_root.email');
        $password = config('auth.init_root.password');

        if (! $email || ! $password) {
            throw new RuntimeException(
                'Initial administrator credentials are not configured.'
            );
        }

        $employee = Employee::query()->firstOrCreate(
            ['email' => $email],
            [
                'firstname' => 'System',
                'lastname' => 'Root',
                'password' => $password,
            ]
        );

        $role = Role::query()
            ->where('slug', 'root')
            ->firstOrFail();

        $employee->roles()->syncWithoutDetaching([$role->id]);
    }
}
