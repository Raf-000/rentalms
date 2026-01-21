<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Update bills status enum
        DB::statement("ALTER TABLE bills MODIFY COLUMN status ENUM('pending', 'paid', 'verified', 'rejected') DEFAULT 'pending'");
        
        // Add rejection reason and rejected info to payments
        Schema::table('payments', function (Blueprint $table) {
            $table->string('rejectionReason')->nullable()->after('verifiedAt');
            $table->foreignId('rejectedBy')->nullable()->after('rejectionReason')->constrained('users', 'id')->onDelete('set null');
            $table->timestamp('rejectedAt')->nullable()->after('rejectedBy');
        });
    }

    public function down()
    {
        DB::statement("ALTER TABLE bills MODIFY COLUMN status ENUM('pending', 'paid', 'verified') DEFAULT 'pending'");
        
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['rejectionReason', 'rejectedBy', 'rejectedAt']);
        });
    }
};
