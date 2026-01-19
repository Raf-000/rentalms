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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('paymentID');
            $table->foreignId('billID')->constrained('bills', 'billID')->onDelete('cascade');
            $table->foreignId('tenantID')->constrained('users', 'id')->onDelete('cascade');
            $table->string('receiptImage')->nullable();
            $table->enum('paymentMethod', ['cash', 'gcash']);
            $table->timestamp('paidAt');
            $table->foreignId('verifiedBy')->nullable()->constrained('users', 'id')->onDelete('set null');
            $table->timestamp('verifiedAt')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
