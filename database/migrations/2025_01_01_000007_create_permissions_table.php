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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('module'); // products, orders, users, etc.
            $table->enum('type', ['create', 'read', 'update', 'delete', 'manage'])->default('read');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index(['module', 'type']);
            $table->index(['is_active']);
        });

        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->boolean('granted')->default(true);
            $table->timestamps();

            // Unique constraint to prevent duplicate permissions
            $table->unique(['user_id', 'permission_id']);
            
            // Indexes
            $table->index(['user_id', 'granted']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('permissions');
    }
};
