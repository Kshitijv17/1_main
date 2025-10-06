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
        // Update existing roles to new system
        // customer -> user
        DB::table('users')->where('role', 'customer')->update(['role' => 'user']);
        
        // shopkeeper -> vendor  
        DB::table('users')->where('role', 'shopkeeper')->update(['role' => 'vendor']);
        
        // superadmin -> admin
        DB::table('users')->where('role', 'superadmin')->update(['role' => 'admin']);
        
        // Update role enum constraint if it exists
        Schema::table('users', function (Blueprint $table) {
            // Drop existing enum constraint if it exists
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('guest', 'user', 'vendor', 'admin') DEFAULT 'user'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert roles back to old system
        // user -> customer
        DB::table('users')->where('role', 'user')->update(['role' => 'customer']);
        
        // vendor -> shopkeeper
        DB::table('users')->where('role', 'vendor')->update(['role' => 'shopkeeper']);
        
        // admin -> superadmin
        DB::table('users')->where('role', 'admin')->update(['role' => 'superadmin']);
        
        // Revert role enum constraint
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('guest', 'customer', 'shopkeeper', 'superadmin') DEFAULT 'customer'");
        });
    }
};
