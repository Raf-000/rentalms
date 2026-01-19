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
        Schema::create('bills', function (Blueprint $table) {
            $table->id('billID');
            $table->foreignId('tenantID')->constrained('users', 'id')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->date('dueDate');
            $table->enum('status', ['pending', 'paid', 'verified'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
