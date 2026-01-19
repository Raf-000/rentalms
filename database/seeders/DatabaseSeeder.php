<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin Account
        DB::table('users')->insert([
            'id' => 101,
            'name' => 'Admin Ako',
            'email' => 'unocutie@gmail.com',
            'password' => Hash::make('123'),
            'phone' => null,
            'role' => 'admin',
            'emergencyContact' => null,
            'leaseStart' => null,
            'leaseEnd' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Tenant 1
        DB::table('users')->insert([
            'id' => 201,
            'name' => 'Alden Richards',
            'email' => 'aldubyou@gmail.com',
            'password' => Hash::make('221'),
            'phone' => null,
            'role' => 'tenant',
            'emergencyContact' => null,
            'leaseStart' => '2025-01-01',
            'leaseEnd' => '2025-12-31',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Tenant 2
        DB::table('users')->insert([
            'id' => 202,
            'name' => 'Lexi Gonzales',
            'email' => 'rmph@gmail.com',
            'password' => Hash::make('222'),
            'phone' => null,
            'role' => 'tenant',
            'emergencyContact' => null,
            'leaseStart' => '2025-01-15',
            'leaseEnd' => '2025-12-15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Bedspace 1
        DB::table('bedspaces')->insert([
            'unitCode' => 'H1F1RB-6',
            'houseNo' => 1,
            'floor' => 1,
            'roomNo' => 'B',
            'bedspaceNo' => 6,
            'price' => 3300.00,
            'restriction' => 'boys',
            'tenantID' => 201,
            'status' => 'occupied',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Bedspace 2
        DB::table('bedspaces')->insert([
            'unitCode' => 'H2F2RA-10',
            'houseNo' => 2,
            'floor' => 2,
            'roomNo' => 'A',
            'bedspaceNo' => 10,
            'price' => 2900.00,
            'restriction' => 'girls',
            'tenantID' => 202,
            'status' => 'occupied',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}