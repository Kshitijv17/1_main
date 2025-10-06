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
        Schema::table('shops', function (Blueprint $table) {
            // Add vendor_id column
            $table->unsignedBigInteger('vendor_id')->nullable()->after('is_active');
            
            // Add foreign key constraint
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add index for better performance
            $table->index('vendor_id');
        });

        // Copy data from admin_id to vendor_id
        DB::statement('UPDATE shops SET vendor_id = admin_id WHERE admin_id IS NOT NULL');

        // Drop the old admin_id column
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            // Add back admin_id column
            $table->unsignedBigInteger('admin_id')->nullable()->after('is_active');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('admin_id');
        });

        // Copy data from vendor_id to admin_id
        DB::statement('UPDATE shops SET admin_id = vendor_id WHERE vendor_id IS NOT NULL');

        // Drop vendor_id column
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id');
        });
    }
};
