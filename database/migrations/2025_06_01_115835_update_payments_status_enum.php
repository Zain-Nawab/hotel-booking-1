<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, you need to use raw SQL to modify enum
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'paid', 'failed', 'cancelled', 'refund_pending', 'refunded')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'paid', 'failed', 'cancelled')");
    }
};
