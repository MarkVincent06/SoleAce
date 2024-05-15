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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->onDelete('cascade');
            $table->string('category', 200);
            $table->string('name', 200);
            $table->string('slug', 200);
            $table->mediumText('small_description');
            $table->mediumText('description');
            $table->decimal('original_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->string('image', 200);
            $table->integer('quantity');
            $table->tinyInteger('status');
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('trending');
            $table->string('meta_title', 200);
            $table->mediumText('meta_keywords');
            $table->mediumText('meta_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
