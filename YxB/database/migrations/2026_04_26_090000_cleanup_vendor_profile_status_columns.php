<?php

use App\Enums\VendorApprovalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (! Schema::hasColumn('vendor_profiles', 'status')) {
            Schema::table('vendor_profiles', function (Blueprint $table) {
                $table->string('status')->default(VendorApprovalStatus::PENDING->value);
            });
        }

        if (Schema::hasColumn('vendor_profiles', 'approval_status')) {
            DB::table('vendor_profiles')
                ->select(['vendor_id', 'status', 'approval_status'])
                ->orderBy('vendor_id')
                ->each(function (object $profile): void {
                    $status = $profile->status ?: $profile->approval_status ?: VendorApprovalStatus::PENDING->value;

                    DB::table('vendor_profiles')
                        ->where('vendor_id', $profile->vendor_id)
                        ->update(['status' => $status]);
                });

            Schema::table('vendor_profiles', function (Blueprint $table) {
                $table->dropColumn('approval_status');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('vendor_profiles', 'approval_status')) {
            Schema::table('vendor_profiles', function (Blueprint $table) {
                $table->string('approval_status')->nullable();
            });
        }

        if (Schema::hasColumn('vendor_profiles', 'approval_status')) {
            DB::table('vendor_profiles')
                ->select(['vendor_id', 'status'])
                ->orderBy('vendor_id')
                ->each(function (object $profile): void {
                    DB::table('vendor_profiles')
                        ->where('vendor_id', $profile->vendor_id)
                        ->update(['approval_status' => $profile->status ?: VendorApprovalStatus::PENDING->value]);
                });
        }
    }
};
