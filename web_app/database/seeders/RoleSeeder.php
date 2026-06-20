<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $admin = Role::firstOrCreate(['name' => 'Super Admin']);
        $operator = Role::firstOrCreate(['name' => 'Operator']);
        $affiliator = Role::firstOrCreate(['name' => 'Affiliator']);

        // Attach first user as Super Admin if exists
        $user = User::first();
        if ($user) {
            $user->assignRole($admin);
        }
    }
}
