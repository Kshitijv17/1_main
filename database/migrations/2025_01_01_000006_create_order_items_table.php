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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Product snapshot at time of order
            $table->string('product_title');
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            
            // Pricing at time of order
            $table->decimal('unit_price', 10, 2);
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            
            // Additional data
            $table->json('product_options')->nullable(); // size, color, etc.
            $table->json('meta_data')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->index(['order_id']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
