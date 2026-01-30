<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/1users.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 11 columns
            $row = array_pad($row, 11, null);

            DB::table('users')->insert([
                'id'               => $row[0],
                'name'             => $row[1],
                'email'            => $row[2],
                'password'         => Hash::make($row[3]),
                'phone'            => $row[4],
                'role'             => $row[5],
                'emergencyContact' => $row[6] !== '' ? $row[6] : null,
                'leaseStart'       => $row[7] !== '' ? $row[7] : null,
                'leaseEnd'         => $row[8] !== '' ? $row[8] : null,
                'created_at'       => $row[9],
                'updated_at'       => $row[10],
            ]);
        }

        fclose($file);
    }
}
