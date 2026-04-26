<?php

namespace App\Http\Controllers;

use App\Enums\VendorApprovalStatus;
use App\Models\VendorProfile;

class VendorController extends Controller
{
    /**
     * Create a pending vendor request for the authenticated user.
     */
    public function requestVendor()
    {
        $user = auth()->user();

        if ($user->vendorProfile) {
            return back()->with('error', 'You already requested');
        }

        VendorProfile::create([
            'vendor_id' => $user->id,
            'status' => VendorApprovalStatus::PENDING->value,
        ]);

        return back()->with('success', 'Request sent');
    }
}
