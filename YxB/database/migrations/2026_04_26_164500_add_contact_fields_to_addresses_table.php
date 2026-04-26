<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('country');
            $table->string('email')->nullable()->after('phone_number');
        });

        DB::table('addresses')
            ->join('users', 'users.id', '=', 'addresses.client_id')
            ->select([
                'addresses.id as address_id',
                'users.email as user_email',
                'users.phone as user_phone',
            ])
            ->orderBy('addresses.id')
            ->each(function (object $address): void {
                DB::table('addresses')
                    ->where('id', $address->address_id)
                    ->update([
                        'phone_number' => $address->user_phone ?: 'Not provided',
                        'email' => $address->user_email ?: 'unknown+' . $address->address_id . '@example.invalid',
                    ]);
            });

        Schema::table('addresses', function (Blueprint $table) {
            $table->string('phone_number')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'email']);
        });
    }
};
