<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Change restriction enum from 'boys/girls' to 'male/female'
        DB::statement("ALTER TABLE bedspaces MODIFY COLUMN restriction ENUM('male', 'female')");
        
        // Update existing data (if any)
        DB::statement("UPDATE bedspaces SET restriction = 'male' WHERE restriction = 'boys'");
        DB::statement("UPDATE bedspaces SET restriction = 'female' WHERE restriction = 'girls'");
    }

    public function down()
    {
        // Revert back to boys/girls
        DB::statement("UPDATE bedspaces SET restriction = 'boys' WHERE restriction = 'male'");
        DB::statement("UPDATE bedspaces SET restriction = 'girls' WHERE restriction = 'female'");
        DB::statement("ALTER TABLE bedspaces MODIFY COLUMN restriction ENUM('boys', 'girls')");
    }
};