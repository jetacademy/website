<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Affiliate;
use App\Models\Lead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@jetschool.id'],
            [
                'name' => 'Admin Jetschool',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Optional: Assign Admin role if roles table exists and has Admin role
        if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
            $adminRole = \Illuminate\Support\Facades\DB::table('roles')->where('name', 'Admin')->first();
            if ($adminRole) {
                \Illuminate\Support\Facades\DB::table('model_has_roles')->updateOrInsert(
                    ['role_id' => $adminRole->id, 'model_id' => $admin->id, 'model_type' => 'App\Models\User']
                );
            }
        }

        // 2. Create Affiliator User
        $affiliator = User::firstOrCreate(
            ['email' => 'affiliator@jetschool.id'],
            [
                'name' => 'Mitra Affiliator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign Affiliator role
        if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
            $affRole = \Illuminate\Support\Facades\DB::table('roles')->where('name', 'Affiliator')->first();
            if ($affRole) {
                // Ensure model_has_roles uses the right structure (Spatie permission format usually)
                \Illuminate\Support\Facades\DB::table('model_has_roles')->updateOrInsert(
                    ['role_id' => $affRole->id, 'model_id' => $affiliator->id, 'model_type' => 'App\Models\User']
                );
            }
        }

        // 3. Create Affiliate profile record
        $affiliateProfile = Affiliate::firstOrCreate(
            ['user_id' => $affiliator->id],
            [
                'referral_code' => 'JET-DEMO',
                'commission_type' => 'percentage',
                'commission_rate' => 10.00,
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'Mitra Affiliator',
            ]
        );

        // 4. Create some demo leads for this affiliator to make dashboard look good
        if ($affiliateProfile->wasRecentlyCreated || Lead::where('affiliate_id', $affiliateProfile->id)->count() === 0) {
            $demoLeads = [
                [
                    'name' => 'Budi Santoso',
                    'school_name' => 'SMA Nusantara 1',
                    'phone_number' => '081234567890',
                    'status' => 'new',
                    'created_at' => Carbon::now()->subDays(2),
                    'updated_at' => Carbon::now()->subDays(2),
                ],
                [
                    'name' => 'Ahmad Dahlan',
                    'school_name' => 'SMK Bina Karya',
                    'phone_number' => '082198765432',
                    'status' => 'demo_scheduled',
                    'created_at' => Carbon::now()->subDays(5),
                    'updated_at' => Carbon::now()->subDays(4),
                ],
                [
                    'name' => 'Siti Aminah',
                    'school_name' => 'Yayasan Pendidikan Islam',
                    'phone_number' => '085511223344',
                    'status' => 'closed_won',
                    'created_at' => Carbon::now()->subDays(10),
                    'updated_at' => Carbon::now()->subDays(1),
                ]
            ];

            foreach ($demoLeads as $leadData) {
                $lead = new Lead($leadData);
                $lead->affiliate_id = $affiliateProfile->id;
                $lead->save();

                // If closed_won, create commission
                if ($leadData['status'] === 'closed_won') {
                    \App\Models\Commission::firstOrCreate(
                        [
                            'affiliate_id' => $affiliateProfile->id,
                            'lead_id' => $lead->id,
                        ],
                        [
                            'amount' => 1500000, // Example fixed commission for demo
                            'status' => 'pending',
                        ]
                    );
                }
            }
        }
    }
}
