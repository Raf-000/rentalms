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

        while (($row = fgetcsv($file, 0, ',', '"')) !== false) {
            // Ensure the row always has 11 columns
            $row = array_pad($row, 11, null);

            DB::table('payments')->insert([
                'paymentID'       => (int) $row[0],
                'billID'          => (int) $row[1],
                'tenantID'        => (int) $row[2],
                'receiptImage'    => $this->nullIfBlank($row[3]),
                'paymentMethod'   => $row[4],
                'paidAt'          => $this->nullIfBlank($row[5]),
                'verifiedBy'      => $this->nullIfBlank($row[6]),
                'verifiedAt'      => $this->nullIfBlank($row[7]),
                'rejectionReason' => $this->nullIfBlank($row[8]),
                'created_at'      => $row[9],
                'updated_at'      => $row[10],
            ]);
        }

        fclose($file);
    }

    private function nullIfBlank($value)
    {
        return ($value === '' || $value === null) ? null : $value;
    }
}
