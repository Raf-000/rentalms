<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->enum('role', ['admin', 'tenant'])->default('tenant');
            $table->string('emergencyContact')->nullable();
            $table->date('leaseStart')->nullable();
            $table->date('leaseEnd')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'emergencyContact', 'leaseStart', 'leaseEnd']);
        });
    }
};
