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
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        $constraints = DB::select("
            SELECT conname, pg_get_constraintdef(oid) AS definition
            FROM pg_constraint
            WHERE conrelid = 'orders'::regclass
              AND contype = 'c'
        ");

        foreach ($constraints as $constraint) {
            if (str_contains($constraint->definition, 'status')) {
                DB::statement("ALTER TABLE orders DROP CONSTRAINT {$constraint->conname}");
            }
        }

        DB::statement("
            ALTER TABLE orders
            ADD CONSTRAINT orders_status_check
            CHECK (status IN ('pending', 'confirmed', 'shipped', 'delivered', 'cancelled'))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_status_check');

        DB::statement("
            ALTER TABLE orders
            ADD CONSTRAINT orders_status_check
            CHECK (status IN ('pending', 'confirmed', 'shipped', 'delivered'))
        ");
    }
};
