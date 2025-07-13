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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable(); // Customer login olduysa
            $table->string('session_id')->nullable(); // Guest users için
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Ürün fiyatı (freeze price)
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index(['customer_id', 'session_id']); // Performance için
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
