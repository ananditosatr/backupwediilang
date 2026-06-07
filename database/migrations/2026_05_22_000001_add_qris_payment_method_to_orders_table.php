<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('orders', 'payment_method')) {
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('transfer','qris','walkin','tunai') NOT NULL DEFAULT 'transfer'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orders', 'payment_method')) {
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('transfer','walkin','tunai') NOT NULL DEFAULT 'transfer'");
        }
    }
};
