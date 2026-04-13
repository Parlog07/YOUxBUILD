<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorProfile;
use Illuminate\Http\Request;

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

        $vendor->update(['status' => 'approved']);

        $vendor->user->update(['role' => 'vendor']);

        return back();
    }

    public function reject($id)
    {
        $vendor = VendorProfile::findOrFail($id);

        $vendor->update(['status' => 'rejected']);

        return back();
    }
}
