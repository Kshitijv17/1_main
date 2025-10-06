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
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['guest', 'user', 'admin', 'superadmin'])->default('user')->after('email');
            });
        } else {
            // Ensure enum includes all required values
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('guest','user','admin','superadmin') NOT NULL DEFAULT 'user'");
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            // Revert enum to original state used in base migration
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('user','admin') NOT NULL DEFAULT 'user'");
        }
    }
};
