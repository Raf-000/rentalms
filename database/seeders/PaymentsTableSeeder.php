<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/csv/4payments.csv');
        $file = fopen($path, 'r');

        // Skip header row
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            DB::table('payments')->insert([
                'paymentID' => $row[0],
                'billID' => $row[1],
                'tenantID' => $row[2],
                'receiptImage' => $row[3],
                'paymentMethod' => $row[4],
                'paidAt' => $row[5],
                'verifiedBy' => $row[6],
                'verifiedAt' => $row[7],
                'created_at' => $row[8],
                'updated_at' => $row[9],
                'rejectionreason' => $row[10], 
                'created_at' => $row[11],
                'updated_at' => $row[12],
            ]);
        }

        fclose($file);
    }
}

