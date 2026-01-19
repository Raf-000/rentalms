<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bedspaces', function (Blueprint $table) {
            $table->id('unitID');
            $table->string('unitCode')->unique();
            $table->integer('houseNo');
            $table->integer('floor');
            $table->string('roomNo');
            $table->integer('bedspaceNo');
            $table->decimal('price', 8, 2);
            $table->enum('restriction', ['boys', 'girls']);
            $table->foreignId('tenantID')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->enum('status', ['occupied', 'available'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedspaces');
    }
};
