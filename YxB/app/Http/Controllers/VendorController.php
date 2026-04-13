<?php

namespace App\Http\Controllers;
use App\Models\VendorProfile;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function requestVendor()
    {
        $user = auth()->user();

        if ($user->vendorProfile) {
            return back()->with('error', 'You already requested');
        }

        VendorProfile::create([
            'vendor_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Request sent');
    }
}
