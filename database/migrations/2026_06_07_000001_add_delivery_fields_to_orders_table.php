<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_method')) {
                $table->enum('order_method', ['delivery', 'pickup'])->default('pickup')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'city')) {
                $table->string('city')->nullable()->after('order_method');
            }
            if (!Schema::hasColumn('orders', 'district')) {
                $table->string('district')->nullable()->after('city');
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->nullable()->after('district');
            }
            if (!Schema::hasColumn('orders', 'delivery_time')) {
                $table->string('delivery_time')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'delivery_time')) {
                $table->dropColumn('delivery_time');
            }
            if (Schema::hasColumn('orders', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('orders', 'district')) {
                $table->dropColumn('district');
            }
            if (Schema::hasColumn('orders', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('orders', 'order_method')) {
                $table->dropColumn('order_method');
            }
        });
    }
};
