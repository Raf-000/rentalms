<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Adjust the enum to include 'void'
        DB::statement("ALTER TABLE bills MODIFY status ENUM('pending','paid','verified','rejected','void') NOT NULL");
    }

    public function down(): void
    {
        // Rollback to original enum values
        DB::statement("ALTER TABLE bills MODIFY status ENUM('pending','paid','verified','rejected') NOT NULL");
    }
};
