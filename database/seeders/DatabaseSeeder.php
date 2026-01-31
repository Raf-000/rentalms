<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks temporarily
        Schema::disableForeignKeyConstraints();

        // Truncate all tables before seeding
        DB::table('users')->truncate();
        DB::table('bedspaces')->truncate();
        DB::table('bills')->truncate();
        DB::table('payments')->truncate();
        DB::table('maintenance_requests')->truncate();
        DB::table('viewing_bookings')->truncate();

        // Re‑enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Call each seeder (no transaction wrapper)
        $this->call([
            UsersTableSeeder::class,
            BedspacesTableSeeder::class,
            BillsTableSeeder::class,
            PaymentsTableSeeder::class,
            MaintenanceRequestsTableSeeder::class,
            ViewingBookingsTableSeeder::class,
        ]);
    }
}
