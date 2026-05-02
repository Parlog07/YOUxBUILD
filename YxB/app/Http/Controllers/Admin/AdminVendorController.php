<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VendorApprovalStatus;
use App\Http\Controllers\Controller;
use App\Models\VendorProfile;

class AdminVendorController extends Controller
{
    public function index()
    {
        $vendors = VendorProfile::with('user')->latest('vendor_id')->get();

        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve($id)
    {
        $vendor = VendorProfile::findOrFail($id);

        $vendor->update(['status' => VendorApprovalStatus::APPROVED->value]);

        $vendor->user->update(['role' => 'vendor']);

        return back()->with('success', 'Vendor approved successfully.');
    }

    public function reject($id)
    {
        $vendor = VendorProfile::findOrFail($id);

        $vendor->update(['status' => VendorApprovalStatus::REJECTED->value]);

        return back()->with('success', 'Vendor rejected successfully.');
    }
}
