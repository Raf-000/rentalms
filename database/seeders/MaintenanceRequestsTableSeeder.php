<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestsTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/5maintenance_requests.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 7 columns
            $row = array_pad($row, 7, null);

            DB::table('maintenance_requests')->insert([
                'requestID'   => (int) $row[0],
                'tenantID'    => (int) $row[1],
                'description' => $this->nullIfBlank($row[2]),
                'photo'       => $this->nullIfBlank($row[3]),
                'status'      => $row[4],
                'created_at'  => $row[5],
                'updated_at'  => $row[6],
            ]);
        }

        fclose($file);
    }

    private function nullIfBlank($value)
    {
        return ($value === '' || $value === null) ? null : $value;
    }
}
