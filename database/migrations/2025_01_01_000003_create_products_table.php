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
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('features')->nullable();
            $table->text('specifications')->nullable();
            $table->string('sku')->unique()->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->string('discount_tag')->nullable();
            $table->string('discount_color', 7)->default('#FF0000');
            
            // Inventory
            $table->integer('quantity')->default(0);
            $table->integer('min_quantity')->default(1);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'low_stock'])->default('in_stock');
            
            // Relationships
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            
            // Media
            $table->string('featured_image')->nullable();
            
            // Status & Features
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_digital')->default(false);
            
            // SEO & Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_data')->nullable();
            
            // Dimensions & Shipping
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['category_id', 'is_active']);
            $table->index(['shop_id', 'is_active']);
            $table->index(['is_active', 'is_featured']);
            $table->index(['stock_status', 'is_active']);
            $table->index(['slug']);
            $table->index(['sku']);
            $table->index(['price', 'is_active']);
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
