<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure the role column accepts all required values
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('guest','user','admin','superadmin') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        // Revert to original enum if needed
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('user','admin') NOT NULL DEFAULT 'user'");
    }
};
