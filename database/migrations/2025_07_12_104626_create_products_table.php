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
            $table->id()->unique();
            $table->string('product_title')->nullable(false);
            $table->text('product_description')->nullable(false);
            $table->integer('product_quantity')->nullable(false);
            $table->decimal('product_price', 10, 2)->nullable(false);
            $table->unsignedBigInteger('product_category')->nullable(false);
            /* birden çok resim */
            // Birden çok resim için JSON sütunu
            $table->json('product_images')->nullable(false);
            $table->foreign('product_category')->references('id')->on('categories');
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
