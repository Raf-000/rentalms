<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ViewingBookingsTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/6viewing_bookings.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 11 columns
            $row = array_pad($row, 11, null);

            $dueDate = date('Y-m-d', strtotime($row[3]));
            $createdAt = date('Y-m-d H:i:s', strtotime($row[5]));
            $updatedAt = date('Y-m-d H:i:s', strtotime($row[6]));

            DB::table('viewing_bookings')->insert([
                'id'               => $row[0],
                'name'             => $row[1],
                'email'            => $row[2],
                'password'         => $row[3],
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
