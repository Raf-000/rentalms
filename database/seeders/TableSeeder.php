<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class completeDData extends Seeder
{
    public function run(): void
    {
        // ============================================
        // USERS
        // ============================================
        DB::table('users')->insert([
            // Admins
            ['id' => 101, 'name' => 'Admin Ako', 'email' => 'unocutie@gmail.com', 'password' => Hash::make('123'), 'phone' => '9111111111', 'role' => 'admin', 'emergencyContact' => null, 'leaseStart' => null, 'leaseEnd' => null, 'created_at' => '2026-01-20 09:15:32', 'updated_at' => '2026-01-20 09:15:32'],
            ['id' => 104, 'name' => 'Lucy Darwin', 'email' => 'lucyd1@gmail.com', 'password' => Hash::make('luc'), 'phone' => '9444444444', 'role' => 'admin', 'emergencyContact' => null, 'leaseStart' => null, 'leaseEnd' => null, 'created_at' => '2026-01-20 14:42:10', 'updated_at' => '2026-01-20 18:05:47'],
            ['id' => 105, 'name' => 'John Jaranjan', 'email' => 'jj007@gmail.com', 'password' => Hash::make('jjj'), 'phone' => '9555555555', 'role' => 'admin', 'emergencyContact' => null, 'leaseStart' => null, 'leaseEnd' => null, 'created_at' => '2026-01-20 19:03:55', 'updated_at' => '2026-01-21 08:20:18'],
            
            // Tenants
            ['id' => 201, 'name' => 'Alucard', 'email' => 'aldubyou@gmail.com', 'password' => Hash::make('221'), 'phone' => '9111111112', 'role' => 'tenant', 'emergencyContact' => '9111111113', 'leaseStart' => '2025-01-01', 'leaseEnd' => '2025-12-31', 'created_at' => '2026-01-21 07:25:44', 'updated_at' => '2026-01-21 07:25:44'],
            ['id' => 202, 'name' => 'Haley De Guzman', 'email' => 'haihai@gmail.com', 'password' => Hash::make('hhh'), 'phone' => '9111111114', 'role' => 'tenant', 'emergencyContact' => '9111111115', 'leaseStart' => '2025-05-06', 'leaseEnd' => '2026-05-06', 'created_at' => '2026-01-21 11:12:09', 'updated_at' => '2026-01-21 15:30:01'],
            ['id' => 203, 'name' => 'Robin Hoodas', 'email' => 'robhod@gmail.com', 'password' => Hash::make('robh'), 'phone' => '9111111116', 'role' => 'tenant', 'emergencyContact' => '9111111117', 'leaseStart' => '2025-07-12', 'leaseEnd' => '2026-07-12', 'created_at' => '2026-01-21 16:45:27', 'updated_at' => '2026-01-21 16:45:27'],
            ['id' => 204, 'name' => 'Maria Leonora', 'email' => 'marile@gmail.com', 'password' => Hash::make('mal22'), 'phone' => '911111118', 'role' => 'tenant', 'emergencyContact' => '9111111119', 'leaseStart' => '2025-10-12', 'leaseEnd' => '2026-10-12', 'created_at' => '2026-01-22 08:10:11', 'updated_at' => '2026-01-22 08:35:00'],
            ['id' => 205, 'name' => 'Jasper Jeans', 'email' => 'jasjas@gmail.com', 'password' => Hash::make('jjs'), 'phone' => '9222222221', 'role' => 'tenant', 'emergencyContact' => '9222222223', 'leaseStart' => '2025-03-23', 'leaseEnd' => '2026-03-23', 'created_at' => '2026-01-22 09:12:44', 'updated_at' => '2026-01-22 09:12:44'],
            ['id' => 206, 'name' => 'Ahra Gacutina', 'email' => 'ahrag@gmail.com', 'password' => Hash::make('ahr'), 'phone' => '9222222224', 'role' => 'tenant', 'emergencyContact' => '9222222225', 'leaseStart' => '2025-01-22', 'leaseEnd' => '2026-01-22', 'created_at' => '2026-01-22 11:30:21', 'updated_at' => '2026-01-22 15:45:09'],
            ['id' => 207, 'name' => 'Princess Del Rosario', 'email' => 'psdl@gmail.com', 'password' => Hash::make('psd1'), 'phone' => '9222222226', 'role' => 'tenant', 'emergencyContact' => '9222222227', 'leaseStart' => '2025-06-12', 'leaseEnd' => '2026-06-12', 'created_at' => '2026-01-22 13:22:59', 'updated_at' => '2026-01-23 10:14:33'],
            ['id' => 208, 'name' => 'Edmond Yabu', 'email' => 'edya@gmail.com', 'password' => Hash::make('yaby'), 'phone' => '9222222228', 'role' => 'tenant', 'emergencyContact' => '9222222229', 'leaseStart' => '2025-02-14', 'leaseEnd' => '2026-02-14', 'created_at' => '2026-01-23 07:48:02', 'updated_at' => '2026-01-23 07:48:02'],
            ['id' => 209, 'name' => 'Joash Uwa', 'email' => 'joash@gmail.com', 'password' => Hash::make('jjuw'), 'phone' => '9333333331', 'role' => 'tenant', 'emergencyContact' => '9333333332', 'leaseStart' => '2025-08-13', 'leaseEnd' => '2026-08-13', 'created_at' => '2026-01-23 09:25:40', 'updated_at' => '2026-01-23 11:55:11'],
            ['id' => 210, 'name' => 'Jonathan Bai', 'email' => 'bai@gmail.com', 'password' => Hash::make('baib'), 'phone' => '9333333334', 'role' => 'tenant', 'emergencyContact' => '9333333335', 'leaseStart' => '2025-11-12', 'leaseEnd' => '2026-11-12', 'created_at' => '2026-01-23 14:39:55', 'updated_at' => '2026-01-23 18:20:44'],
        ]);

        // ============================================
        // BEDSPACES
        // ============================================
        DB::table('bedspaces')->insert([
            // House 1, Floor 1, Room A (Boys)
            ['unitID' => 1, 'unitCode' => 'H1F1RA-1', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => 201, 'bedspaceNo' => 1, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 08:15:32'],
            ['unitID' => 2, 'unitCode' => 'H1F1RA-2', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 2, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 12:05:47'],
            ['unitID' => 3, 'unitCode' => 'H1F1RA-3', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => 208, 'bedspaceNo' => 3, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 10:03:55'],
            ['unitID' => 4, 'unitCode' => 'H1F1RA-4', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 14:30:01'],
            ['unitID' => 5, 'unitCode' => 'H1F1RA-5', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => 210, 'bedspaceNo' => 5, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 13:12:09'],
            ['unitID' => 6, 'unitCode' => 'H1F1RA-6', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 14:45:27'],
            ['unitID' => 7, 'unitCode' => 'H1F1RA-7', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => 209, 'bedspaceNo' => 7, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 15:35:00'],
            ['unitID' => 8, 'unitCode' => 'H1F1RA-8', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 8, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 08:12:44'],
            ['unitID' => 9, 'unitCode' => 'H1F1RA-9', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 9, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 09:30:21'],
            ['unitID' => 10, 'unitCode' => 'H1F1RA-10', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 10, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 13:14:33'],

            // House 1, Floor 1, Room B (Boys)
            ['unitID' => 11, 'unitCode' => 'H1F1RB-1', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'male', 'tenantID' => 203, 'bedspaceNo' => 1, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 11:48:02'],
            ['unitID' => 12, 'unitCode' => 'H1F1RB-2', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'male', 'tenantID' => 205, 'bedspaceNo' => 2, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 13:25:40'],
            ['unitID' => 13, 'unitCode' => 'H1F1RB-3', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 3, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 14:14:28'],
            ['unitID' => 14, 'unitCode' => 'H1F1RB-4', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 08:39:55'],
            ['unitID' => 15, 'unitCode' => 'H1F1RB-5', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 5, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 09:15:32'],
            ['unitID' => 16, 'unitCode' => 'H1F1RB-6', 'houseNo' => 1, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'male', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 10:42:10'],

            // House 1, Floor 2, Room A (Girls)
            ['unitID' => 17, 'unitCode' => 'H1F2RA-1', 'houseNo' => 1, 'floor' => 2, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => 202, 'bedspaceNo' => 1, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 11:03:55'],
            ['unitID' => 18, 'unitCode' => 'H1F2RA-2', 'houseNo' => 1, 'floor' => 2, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 2, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 13:25:44'],
            ['unitID' => 19, 'unitCode' => 'H1F2RA-3', 'houseNo' => 1, 'floor' => 2, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => 206, 'bedspaceNo' => 3, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-23 07:12:09'],
            ['unitID' => 20, 'unitCode' => 'H1F2RA-4', 'houseNo' => 1, 'floor' => 2, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-23 08:45:27'],
            ['unitID' => 21, 'unitCode' => 'H1F2RA-5', 'houseNo' => 1, 'floor' => 2, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 5, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 08:15:32'],
            ['unitID' => 22, 'unitCode' => 'H1F2RA-6', 'houseNo' => 1, 'floor' => 2, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 12:05:47'],

            // House 2, Floor 1, Room A (Girls)
            ['unitID' => 23, 'unitCode' => 'H2F1RA-1', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 1, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 10:03:55'],
            ['unitID' => 24, 'unitCode' => 'H2F1RA-2', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 2, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 14:30:01'],
            ['unitID' => 25, 'unitCode' => 'H2F1RA-3', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 3, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 13:12:09'],
            ['unitID' => 26, 'unitCode' => 'H2F1RA-4', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 14:45:27'],
            ['unitID' => 27, 'unitCode' => 'H2F1RA-5', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 5, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-20 15:35:00'],
            ['unitID' => 28, 'unitCode' => 'H2F1RA-6', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'A', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 08:12:44'],

            // House 2, Floor 1, Room B (Girls)
            ['unitID' => 29, 'unitCode' => 'H2F1RB-1', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 1, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 09:30:21'],
            ['unitID' => 30, 'unitCode' => 'H2F1RB-2', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 2, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 13:14:33'],
            ['unitID' => 31, 'unitCode' => 'H2F1RB-3', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 3, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 11:48:02'],
            ['unitID' => 32, 'unitCode' => 'H2F1RB-4', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 13:25:40'],
            ['unitID' => 33, 'unitCode' => 'H2F1RB-5', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 5, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-21 14:14:28'],
            ['unitID' => 34, 'unitCode' => 'H2F1RB-6', 'houseNo' => 2, 'floor' => 1, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 08:39:55'],

            // House 2, Floor 2, Room A (Girls)
            ['unitID' => 35, 'unitCode' => 'H2F2RA-1', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => 204, 'bedspaceNo' => 1, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 09:15:32'],
            ['unitID' => 36, 'unitCode' => 'H2F2RA-2', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 2, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 10:42:10'],
            ['unitID' => 37, 'unitCode' => 'H2F2RA-3', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 3, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 11:03:55'],
            ['unitID' => 38, 'unitCode' => 'H2F2RA-4', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 13:25:44'],
            ['unitID' => 39, 'unitCode' => 'H2F2RA-5', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 5, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-23 07:12:09'],
            ['unitID' => 40, 'unitCode' => 'H2F2RA-6', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-23 08:45:27'],
            ['unitID' => 41, 'unitCode' => 'H2F2RA-7', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => 207, 'bedspaceNo' => 7, 'status' => 'occupied', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 08:39:55'],
            ['unitID' => 42, 'unitCode' => 'H2F2RA-8', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 8, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 09:15:32'],
            ['unitID' => 43, 'unitCode' => 'H2F2RA-9', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 9, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 10:42:10'],
            ['unitID' => 44, 'unitCode' => 'H2F2RA-10', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'A', 'price' => 2900, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 10, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 11:03:55'],

            // House 2, Floor 2, Room B (Girls)
            ['unitID' => 45, 'unitCode' => 'H2F2RB-1', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 1, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 13:25:44'],
            ['unitID' => 46, 'unitCode' => 'H2F2RB-2', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 2, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-23 07:12:09'],
            ['unitID' => 47, 'unitCode' => 'H2F2RB-3', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 3, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-23 08:45:27'],
            ['unitID' => 48, 'unitCode' => 'H2F2RB-4', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 4, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 08:39:55'],
            ['unitID' => 49, 'unitCode' => 'H2F2RB-5', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 5, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 09:15:32'],
            ['unitID' => 50, 'unitCode' => 'H2F2RB-6', 'houseNo' => 2, 'floor' => 2, 'roomNo' => 'B', 'price' => 3300, 'restriction' => 'female', 'tenantID' => null, 'bedspaceNo' => 6, 'status' => 'available', 'created_at' => '2026-01-20 08:15:32', 'updated_at' => '2026-01-22 10:42:10'],
        ]);

        // ============================================
        // BILLS
        // ============================================
        DB::table('bills')->insert([
            ['billID' => 1001, 'tenantID' => 207, 'amount' => 2900, 'dueDate' => '2025-12-17', 'status' => 'verified', 'created_at' => '2025-12-17 09:15:32', 'updated_at' => '2025-12-17 09:15:32'],
            ['billID' => 1002, 'tenantID' => 203, 'amount' => 3300, 'dueDate' => '2025-12-18', 'status' => 'verified', 'created_at' => '2025-12-18 08:39:55', 'updated_at' => '2025-12-18 08:39:55'],
            ['billID' => 1003, 'tenantID' => 204, 'amount' => 2900, 'dueDate' => '2025-12-20', 'status' => 'verified', 'created_at' => '2025-12-20 14:14:28', 'updated_at' => '2025-12-20 14:14:28'],
            ['billID' => 1004, 'tenantID' => 201, 'amount' => 3300, 'dueDate' => '2025-12-22', 'status' => 'verified', 'created_at' => '2025-12-22 13:25:40', 'updated_at' => '2025-12-22 13:25:40'],
            ['billID' => 1005, 'tenantID' => 202, 'amount' => 2900, 'dueDate' => '2025-12-25', 'status' => 'verified', 'created_at' => '2025-12-25 11:48:02', 'updated_at' => '2025-12-25 11:48:02'],
            ['billID' => 1006, 'tenantID' => 210, 'amount' => 2900, 'dueDate' => '2026-01-27', 'status' => 'pending', 'created_at' => '2026-01-23 10:22:59', 'updated_at' => '2026-01-23 13:14:33'],
            ['billID' => 1007, 'tenantID' => 209, 'amount' => 2900, 'dueDate' => '2026-01-16', 'status' => 'paid', 'created_at' => '2026-01-16 09:30:21', 'updated_at' => '2026-01-16 09:30:21'],
            ['billID' => 1008, 'tenantID' => 206, 'amount' => 3300, 'dueDate' => '2026-01-12', 'status' => 'verified', 'created_at' => '2026-01-12 08:12:44', 'updated_at' => '2026-01-12 08:12:44'],
            ['billID' => 1009, 'tenantID' => 208, 'amount' => 2900, 'dueDate' => '2026-01-10', 'status' => 'verified', 'created_at' => '2026-01-17 15:10:11', 'updated_at' => '2026-01-18 08:35:00'],
            ['billID' => 1010, 'tenantID' => 207, 'amount' => 2900, 'dueDate' => '2026-01-17', 'status' => 'paid', 'created_at' => '2026-01-17 14:45:27', 'updated_at' => '2026-01-17 14:45:27'],
            ['billID' => 1011, 'tenantID' => 204, 'amount' => 2900, 'dueDate' => '2026-01-20', 'status' => 'verified', 'created_at' => '2026-01-20 13:12:09', 'updated_at' => '2026-01-21 09:30:01'],
            ['billID' => 1012, 'tenantID' => 205, 'amount' => 3300, 'dueDate' => '2026-01-20', 'status' => 'pending', 'created_at' => '2026-01-20 11:25:44', 'updated_at' => '2026-01-20 11:25:44'],
            ['billID' => 1013, 'tenantID' => 203, 'amount' => 3300, 'dueDate' => '2026-01-18', 'status' => 'verified', 'created_at' => '2026-01-18 10:03:55', 'updated_at' => '2026-01-19 08:20:18'],
            ['billID' => 1014, 'tenantID' => 202, 'amount' => 2900, 'dueDate' => '2026-01-25', 'status' => 'pending', 'created_at' => '2026-01-21 09:42:10', 'updated_at' => '2026-01-21 12:05:47'],
            ['billID' => 1015, 'tenantID' => 201, 'amount' => 3300, 'dueDate' => '2026-01-22', 'status' => 'rejected', 'created_at' => '2026-01-22 08:15:32', 'updated_at' => '2026-01-22 08:15:32'],
        ]);

        // ============================================
        // PAYMENTS
        // ============================================
        DB::table('payments')->insert([
            ['paymentID' => 8001, 'billID' => 1010, 'tenantID' => 207, 'receiptImage' => null, 'paymentMethod' => 'cash', 'paidAt' => '2026-01-18 09:12:00', 'verifiedBy' => null, 'verifiedAt' => null, 'created_at' => '2026-01-22 09:15:32', 'updated_at' => '2026-01-22 09:15:32', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8002, 'billID' => 1007, 'tenantID' => 209, 'receiptImage' => null, 'paymentMethod' => 'cash', 'paidAt' => '2026-01-20 13:00:00', 'verifiedBy' => null, 'verifiedAt' => null, 'created_at' => '2026-01-21 10:42:10', 'updated_at' => '2026-01-21 13:05:47', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8003, 'billID' => 1015, 'tenantID' => 201, 'receiptImage' => '1015paid.jpg', 'paymentMethod' => 'gcash', 'paidAt' => '2026-01-20 10:00:00', 'verifiedBy' => null, 'verifiedAt' => null, 'created_at' => '2026-01-18 11:03:55', 'updated_at' => '2026-01-19 08:20:18', 'rejectionReason' => 'invalid reference number.', 'rejectedBy' => 101, 'rejectedAt' => '2026-01-19 08:20:18'],
            ['paymentID' => 8004, 'billID' => 1013, 'tenantID' => 203, 'receiptImage' => '1013paid.jpg', 'paymentMethod' => 'gcash', 'paidAt' => '2026-01-15 15:00:00', 'verifiedBy' => 105, 'verifiedAt' => '2026-01-15 20:00:00', 'created_at' => '2026-01-20 12:25:44', 'updated_at' => '2026-01-20 12:25:44', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8005, 'billID' => 1011, 'tenantID' => 204, 'receiptImage' => null, 'paymentMethod' => 'cash', 'paidAt' => '2026-01-12 14:30:00', 'verifiedBy' => 101, 'verifiedAt' => '2026-01-15 19:57:00', 'created_at' => '2026-01-20 14:12:09', 'updated_at' => '2026-01-21 09:30:01', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8006, 'billID' => 1009, 'tenantID' => 208, 'receiptImage' => null, 'paymentMethod' => 'cash', 'paidAt' => '2026-01-07 11:00:00', 'verifiedBy' => null, 'verifiedAt' => '2026-01-15 19:45:00', 'created_at' => '2026-01-17 15:45:27', 'updated_at' => '2026-01-17 15:45:27', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8007, 'billID' => 1008, 'tenantID' => 206, 'receiptImage' => null, 'paymentMethod' => 'cash', 'paidAt' => '2026-01-07 11:02:00', 'verifiedBy' => 104, 'verifiedAt' => '2026-01-08 18:43:00', 'created_at' => '2026-01-17 16:10:11', 'updated_at' => '2026-01-18 08:35:00', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8008, 'billID' => 1005, 'tenantID' => 202, 'receiptImage' => '1005paid.jpg', 'paymentMethod' => 'gcash', 'paidAt' => '2025-12-20 15:15:00', 'verifiedBy' => 104, 'verifiedAt' => '2025-12-23 19:09:00', 'created_at' => '2026-01-12 09:12:44', 'updated_at' => '2026-01-12 09:12:44', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8009, 'billID' => 1004, 'tenantID' => 201, 'receiptImage' => '1004paid.jpg', 'paymentMethod' => 'gcash', 'paidAt' => '2025-12-19 12:02:00', 'verifiedBy' => 104, 'verifiedAt' => '2025-12-23 20:45:00', 'created_at' => '2026-01-16 10:30:21', 'updated_at' => '2026-01-16 10:30:21', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8010, 'billID' => 1003, 'tenantID' => 204, 'receiptImage' => '1003paid.jpg', 'paymentMethod' => 'gcash', 'paidAt' => '2025-12-19 15:03:00', 'verifiedBy' => 101, 'verifiedAt' => '2025-12-23 20:36:00', 'created_at' => '2026-01-23 11:22:59', 'updated_at' => '2026-01-23 14:14:33', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8011, 'billID' => 1002, 'tenantID' => 203, 'receiptImage' => '1002paid.jpg', 'paymentMethod' => 'gcash', 'paidAt' => '2025-12-16 14:00:00', 'verifiedBy' => 105, 'verifiedAt' => '2025-12-23 20:32:00', 'created_at' => '2025-12-25 12:48:02', 'updated_at' => '2025-12-25 12:48:02', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
            ['paymentID' => 8012, 'billID' => 1001, 'tenantID' => 207, 'receiptImage' => null, 'paymentMethod' => 'cash', 'paidAt' => '2025-12-15 15:15:00', 'verifiedBy' => 105, 'verifiedAt' => '2025-12-23 20:26:00', 'created_at' => '2025-12-22 14:25:40', 'updated_at' => '2025-12-22 14:25:40', 'rejectionReason' => null, 'rejectedBy' => null, 'rejectedAt' => null],
        ]);

        // ============================================
        // MAINTENANCE REQUESTS
        // ============================================
        DB::table('maintenance_requests')->insert([
            ['requestID' => 4006, 'tenantID' => 202, 'description' => 'Busted Light Bulb', 'photo' => 'boombilya.jpg', 'status' => 'pending', 'created_at' => '2026-01-22 09:12:44', 'updated_at' => '2026-01-22 09:12:44'],
            ['requestID' => 4005, 'tenantID' => 204, 'description' => 'Leaking Faucet', 'photo' => 'fausetfauset.jpg', 'status' => 'scheduled', 'created_at' => '2026-01-21 10:30:21', 'updated_at' => '2026-01-21 13:45:09'],
            ['requestID' => 4004, 'tenantID' => 201, 'description' => 'Clogged Toilet', 'photo' => '2bs.jpg', 'status' => 'scheduled', 'created_at' => '2026-01-20 11:22:59', 'updated_at' => '2026-01-20 11:22:59'],
            ['requestID' => 4003, 'tenantID' => 203, 'description' => 'Broken Door knob', 'photo' => 'dknob.jpg', 'status' => 'completed', 'created_at' => '2026-01-19 08:48:02', 'updated_at' => '2026-01-20 10:14:33'],
            ['requestID' => 4002, 'tenantID' => 205, 'description' => 'Squeaky bed frame', 'photo' => 'bembeng.jpg', 'status' => 'completed', 'created_at' => '2026-01-18 13:25:40', 'updated_at' => '2026-01-18 13:25:40'],
            ['requestID' => 4001, 'tenantID' => 206, 'description' => 'Slow Wi-FI', 'photo' => 'wifiprob.jpg', 'status' => 'completed', 'created_at' => '2026-01-17 14:14:28', 'updated_at' => '2026-01-17 14:14:28'],
        ]);

        // ============================================
        // VIEWING BOOKINGS
        // ============================================
        DB::table('viewing_bookings')->insert([
            ['id' => 1, 'name' => 'James', 'email' => 'james@gmail.com', 'phone' => '09839398398', 'gender' => 'male', 'bedspace_id' => 1, 'preferred_date' => '2026-02-10', 'preferred_time' => 'Morning', 'message' => 'im with mom', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Nadine', 'email' => 'nadine@gmail.com', 'phone' => '09456673573', 'gender' => 'female', 'bedspace_id' => 2, 'preferred_date' => '2026-02-15', 'preferred_time' => 'Afternoon', 'message' => 'n/a', 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}