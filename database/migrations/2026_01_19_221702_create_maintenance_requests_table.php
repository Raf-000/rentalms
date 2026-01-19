<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id('requestID');
            $table->foreignId('tenantID')->constrained('users', 'id')->onDelete('cascade');
            $table->text('description');
            $table->string('photo')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
