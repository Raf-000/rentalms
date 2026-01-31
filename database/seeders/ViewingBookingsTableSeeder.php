<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewingBookingsTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/6viewing_bookings.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 12 columns
            $row = array_pad($row, 12, null);

            DB::table('viewing_bookings')->insert([
                'id'             => (int) $row[0],
                'name'           => $row[1],
                'email'          => $row[2],
                'phone'          => $row[3],
                'gender'         => $row[4],
                'bedspace_id'    => $this->nullIfBlank($row[5]),
                'preferred_date' => $this->nullIfBlank($row[6]),
                'preferred_time' => $this->nullIfBlank($row[7]),
                'message'        => $this->nullIfBlank($row[8]),
                'status'         => $row[9],
                'created_at'     => $row[10],
                'updated_at'     => $row[11],
            ]);
        }

        fclose($file);
    }

    private function nullIfBlank($value)
    {
        return ($value === '' || $value === null) ? null : $value;
    }
}
