<?php

namespace App\Http\Controllers;

use App\Enums\VendorApprovalStatus;
use App\Models\VendorProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->vendorProfile) {
            return redirect()->route('dashboard')->with('error', 'You already requested vendor access.');
        }

        return view('vendor.request');
    }

    public function requestVendor(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->vendorProfile) {
            return back()->with('error', 'You already requested');
        }

        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'store_description' => ['nullable', 'string'],
            'business_address' => ['required', 'string', 'max:255'],
        ]);

        VendorProfile::create([
            'vendor_id' => $user->id,
            'store_name' => $data['store_name'],
            'store_description' => $data['store_description'] ?: null,
            'business_address' => $data['business_address'],
            'status' => VendorApprovalStatus::PENDING->value,
        ]);

        return redirect()->route('dashboard')->with('success', 'Vendor request sent successfully.');
    }
}
