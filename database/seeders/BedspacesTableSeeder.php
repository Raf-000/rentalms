<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedspacesTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/2bedspaces.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {

            $tenantID = trim($row[7]) === '' ? null : (int) $row[7];

            $createdAt = date('Y-m-d H:i:s', strtotime($row[10]));
            $updatedAt = date('Y-m-d H:i:s', strtotime($row[11]));

            DB::table('bedspaces')->insert([
                'unitID' => (int) $row[0],
                'unitCode' => $row[1],
                'houseNo' => (int) $row[2],
                'floor' => (int) $row[3],
                'roomNo' => $row[4],
                'price' => (float) $row[5],
                'restriction' => $row[6],  
                'tenantID' => $tenantID,   
                'bedspaceNo' => (int) $row[8],
                'status' => $row[9],
                'created_at' => $createdAt, 
                'updated_at' => $updatedAt, 
            ]);
        }

        fclose($file);
    }
}

