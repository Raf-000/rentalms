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

        // House 1, Floor 1, Room B - add 5 more vacant bedspaces (you already have bedspace 6)
        for ($i = 1; $i <= 5; $i++) {
            DB::table('bedspaces')->insert([
                'unitCode' => 'H1F1RB-' . $i,
                'houseNo' => 1,
                'floor' => 1,
                'roomNo' => 'B',
                'bedspaceNo' => $i,
                'price' => 3300.00,
                'restriction' => 'boys',
                'tenantID' => null,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // House 2, Floor 2, Room A - add 9 more vacant bedspaces (you already have bedspace 10)
        for ($i = 1; $i <= 9; $i++) {
            DB::table('bedspaces')->insert([
                'unitCode' => 'H2F2RA-' . $i,
                'houseNo' => 2,
                'floor' => 2,
                'roomNo' => 'A',
                'bedspaceNo' => $i,
                'price' => 2900.00,
                'restriction' => 'girls',
                'tenantID' => null,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create some bills for tenants
        DB::table('bills')->insert([
            [
                'tenantID' => 201, // Alden Richards
                'amount' => 3300.00,
                'dueDate' => '2026-02-01',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenantID' => 201,
                'amount' => 3300.00,
                'dueDate' => '2026-01-01',
                'status' => 'verified',
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subMonth(),
            ],
            [
                'tenantID' => 202, // Lexi Gonzales
                'amount' => 2900.00,
                'dueDate' => '2026-02-01',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create some payments
        DB::table('payments')->insert([
            [
                'billID' => 2, // Alden's verified bill
                'tenantID' => 201,
                'receiptImage' => null,
                'paymentMethod' => 'cash',
                'paidAt' => now()->subMonth(),
                'verifiedBy' => 101, // Admin verified it
                'verifiedAt' => now()->subMonth(),
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subMonth(),
            ],
        ]);

        // Create some maintenance requests
        DB::table('maintenance_requests')->insert([
            [
                'tenantID' => 201,
                'description' => 'Bathroom sink is clogged',
                'photo' => null,
                'status' => 'pending',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'tenantID' => 202,
                'description' => 'WiFi connection is very slow in my room',
                'photo' => null,
                'status' => 'scheduled',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDay(),
            ],
            [
                'tenantID' => 201,
                'description' => 'Light bulb needs replacement',
                'photo' => null,
                'status' => 'completed',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subDays(3),
            ],
        ]);
    }
}