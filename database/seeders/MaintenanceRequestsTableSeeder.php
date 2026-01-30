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

        while (($row = fgetcsv($file)) !== false) {
            DB::table('maintenance_requests')->insert([
                'requestID' => $row[0],
                'tenantID' => $row[1],
                'description' => $row[2],
                'photo' => $row[3],
                'status' => $row[4],
                'created_at' => $row[5],
                'updated_at' => $row[6],
            ]);
        }

        fclose($file);
    }
}

