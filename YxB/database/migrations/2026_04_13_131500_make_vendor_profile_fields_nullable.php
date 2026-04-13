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
        DB::statement('ALTER TABLE vendor_profiles ALTER COLUMN store_name DROP NOT NULL');
        DB::statement('ALTER TABLE vendor_profiles ALTER COLUMN business_address DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE vendor_profiles ALTER COLUMN store_name SET NOT NULL');
        DB::statement('ALTER TABLE vendor_profiles ALTER COLUMN business_address SET NOT NULL');
    }
};
