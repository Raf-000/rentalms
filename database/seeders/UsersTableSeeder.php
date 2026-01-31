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
                'id'               => (int) $row[0],
                'name'             => $row[1],
                'email'            => $row[2],
                'password'         => Hash::make($row[3]),
                'phone'            => $row[4],
                'role'             => $row[5],
                'emergencyContact' => $this->nullIfBlank($row[6]),
                'leaseStart'       => $this->nullIfBlank($row[7]),
                'leaseEnd'         => $this->nullIfBlank($row[8]),
                'created_at'       => $this->nullIfBlank($row[9]),
                'updated_at'       => $this->nullIfBlank($row[10]),
            ]);
        }

        fclose($file);
    }

    private function nullIfBlank($value)
    {
        return ($value === '' || $value === null || strtoupper($value) === 'NULL') ? null : $value;
    }
}
