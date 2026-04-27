<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE listings MODIFY status ENUM('pending', 'active', 'sold', 'archived') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE listings SET status = 'active' WHERE status = 'pending'");
        DB::statement("ALTER TABLE listings MODIFY status ENUM('active', 'sold', 'archived') NOT NULL DEFAULT 'active'");
    }
};
