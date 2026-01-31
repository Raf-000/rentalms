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

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 12 columns
            $row = array_pad($row, 12, null);

            DB::table('bedspaces')->insert([
                'unitID'     => (int) $row[0],
                'unitCode'   => $row[1],
                'houseNo'    => (int) $row[2],
                'floor'      => (int) $row[3],
                'roomNo'     => $row[4],
                'price'      => (float) $row[5],
                'restriction'=> $row[6],
                'tenantID'   => $this->nullIfBlank($row[7]) ? (int) $row[7] : null,
                'bedspaceNo' => (int) $row[8],
                'status'     => $row[9],
                'created_at' => $this->nullIfBlank($row[10]),
                'updated_at' => $this->nullIfBlank($row[11]),
            ]);
        }

        fclose($file);
    }

    private function nullIfBlank($value)
    {
        return ($value === '' || $value === null) ? null : $value;
    }
}
