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
        Schema::table('order_items', function (Blueprint $table) {
            // Add the timestamps if they do not exist
            if (!Schema::hasColumn('order_items', 'created_at')) {
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->after('product_price');
            }
            if (!Schema::hasColumn('order_items', 'updated_at')) {
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->after('created_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the columns if they exist
            if (Schema::hasColumn('order_items', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('order_items', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};
