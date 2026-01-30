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

        while (($row = fgetcsv($file)) !== false) {

        $dueDate = date('Y-m-d', strtotime($row[4]));

        DB::table('bills')->insert([
            'billID'     => (int) $row[0],
            'tenantID'   => (int) $row[1],
            'amount'     => (float) $row[2],
            'description'=> $row[3] ?: null, // empty → NULL, default still works
            'dueDate'    => $dueDate,         // ✅ FIX
            'status'     => $row[5],
            'created_at'=> $row[6],
            'updated_at'=> $row[7],
        ]);
    }

        fclose($file);
    }
}

