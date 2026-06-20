<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AffiliateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengecek jika tabel roles ada untuk mencegah error sebelum modul RBAC selesai
        if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
            $role = \Illuminate\Support\Facades\DB::table('roles')->where('name', 'Affiliator')->first();

            if (!$role) {
                $roleId = \Illuminate\Support\Facades\DB::table('roles')->insertGetId([
                    'name' => 'Affiliator',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $roleId = $role->id;
            }

            $permissions = [
                'view_affiliate_dashboard',
                'view_own_leads'
            ];

            foreach ($permissions as $permName) {
                $perm = \Illuminate\Support\Facades\DB::table('permissions')->where('name', $permName)->first();
                if (!$perm) {
                    $permId = \Illuminate\Support\Facades\DB::table('permissions')->insertGetId([
                        'name' => $permName,
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    $permId = $perm->id;
                }

                // Attach to role if not attached
                $rolePerm = \Illuminate\Support\Facades\DB::table('role_permissions')
                    ->where('role_id', $roleId)
                    ->where('permission_id', $permId)
                    ->first();

                if (!$rolePerm) {
                    \Illuminate\Support\Facades\DB::table('role_permissions')->insert([
                        'role_id' => $roleId,
                        'permission_id' => $permId
                    ]);
                }
            }
        }
    }
}
