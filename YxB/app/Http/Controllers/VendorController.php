<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function requestVendor(Request $request){
        $user = auth()->user();

        VendorProfile::create([
            'vendor_id' => $user
            'store_name' =>
            'business_address' =>
            'approval_status' => 
        ])
    }
    public function requestVendor()
    {
        $user = auth()->user();

        if ($user->vendorProfile) {
            return back()->with('error', 'You already requested');
        }

        VendorProfile::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Request sent');
    }
}
