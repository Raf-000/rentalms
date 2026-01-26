<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('viewing_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->enum('gender', ['male', 'female']);
            
            // What they want to view
            $table->integer('house_no');
            $table->integer('floor')->nullable();
            $table->string('room_no', 10)->nullable();
            
            $table->date('preferred_date');
            $table->string('preferred_time', 50)->nullable();
            $table->text('message')->nullable();
            
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viewing_bookings');
    }
};