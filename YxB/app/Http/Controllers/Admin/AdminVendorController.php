<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorProfile;

class AdminVendorController extends Controller
{
    /**
     * Show all vendor applications for review.
     */
    public function index()
    {
        $vendors = VendorProfile::with('user')->latest('vendor_id')->get();

        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Approve one vendor request and promote the user role.
     */
    public function approve($id)
    {
        $vendor = VendorProfile::findOrFail($id);

        $vendor->update(['status' => 'approved']);

        $vendor->user->update(['role' => 'vendor']);

        return back()->with('success', 'Vendor approved successfully.');
    }

    /**
     * Reject one vendor request.
     */
    public function reject($id)
    {
        $vendor = VendorProfile::findOrFail($id);

        $vendor->update(['status' => 'rejected']);

        return back()->with('success', 'Vendor rejected successfully.');
    }
}
