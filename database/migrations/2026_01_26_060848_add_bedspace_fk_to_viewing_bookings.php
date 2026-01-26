<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('viewing_bookings', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['house_no', 'floor', 'room_no']);
            
            // Add bedspace FK
            $table->foreignId('bedspace_id')->nullable()->after('gender')->constrained('bedspaces', 'unitID')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('viewing_bookings', function (Blueprint $table) {
            // Remove FK
            $table->dropForeign(['bedspace_id']);
            $table->dropColumn('bedspace_id');
            
            // Restore old columns
            $table->integer('house_no');
            $table->integer('floor')->nullable();
            $table->string('room_no', 10)->nullable();
        });
    }
};