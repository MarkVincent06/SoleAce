<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no', 200);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name', 200);
            $table->string('email', 200);
            $table->string('phone', 200);
            $table->string('address', 200);
            $table->unsignedBigInteger('zip_code');
            $table->unsignedBigInteger('total_price');
            $table->string('payment_method', 200);
            $table->string('payment_id', 200)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('comments', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
