<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillsTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/3bills.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 8 columns
            $row = array_pad($row, 8, null);

            DB::table('bills')->insert([
                'billID'      => (int) $row[0],
                'tenantID'    => (int) $row[1],
                'amount'      => (float) $row[2],
                'description' => $this->nullIfBlank($row[3]),
                'dueDate'     => $this->nullIfBlank(date('Y-m-d', strtotime($row[4]))),
                'status'      => $row[5],
                'created_at'  => $this->nullIfBlank($row[6]),
                'updated_at'  => $this->nullIfBlank($row[7]),
            ]);
        }

        fclose($file);
    }

    private function nullIfBlank($value)
    {
        return ($value === '' || $value === null) ? null : $value;
    }
}
