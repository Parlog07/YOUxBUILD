<?php

use App\Enums\OrderStatus;
use App\Enums\ProductAvailabilityStatus;
use App\Enums\ProductType;
use App\Enums\VendorApprovalStatus;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorProfile;

it('allows vendor profiles to store the active business fields', function () {
    $vendor = User::factory()->create(['role' => 'vendor']);

    $profile = VendorProfile::create([
        'vendor_id' => $vendor->id,
        'store_name' => 'Atlas Components',
        'store_description' => 'Custom workstation parts',
        'business_address' => '42 Market Street',
        'status' => VendorApprovalStatus::PENDING->value,
    ]);

    expect($profile->store_name)->toBe('Atlas Components')
        ->and($profile->store_description)->toBe('Custom workstation parts')
        ->and($profile->business_address)->toBe('42 Market Street')
        ->and($profile->status)->toBe(VendorApprovalStatus::PENDING->value);
});

it('recalculates subtotals and order totals whenever order items change', function () {
    $client = User::factory()->create();
    $vendor = User::factory()->create(['role' => 'vendor']);

    VendorProfile::create([
        'vendor_id' => $vendor->id,
        'store_name' => 'Northwind Builds',
        'business_address' => '9 Silicon Avenue',
        'status' => VendorApprovalStatus::APPROVED->value,
    ]);

    $category = Category::create(['name' => 'GPUs']);

    $product = Product::create([
        'vendor_id' => $vendor->id,
        'category_id' => $category->id,
        'name' => 'RTX Test Card',
        'description' => 'Test product',
        'price' => 499.99,
        'stock_quantity' => 4,
        'availability_status' => ProductAvailabilityStatus::IN_STOCK->value,
        'product_type' => ProductType::PHYSICAL->value,
    ]);

    $order = Order::create([
        'client_id' => $client->id,
        'order_reference' => 'ORD-TEST-001',
        'status' => OrderStatus::PENDING->value,
    ]);

    $item = OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'unit_price' => 499.99,
        'subtotal' => 1,
    ]);

    expect((float) $item->fresh()->subtotal)->toBe(999.98)
        ->and((float) $order->fresh()->total_amount)->toBe(999.98);

    $item->update([
        'quantity' => 3,
        'subtotal' => 1,
    ]);

    expect((float) $item->fresh()->subtotal)->toBe(1499.97)
        ->and((float) $order->fresh()->total_amount)->toBe(1499.97);

    $item->delete();

    expect((float) $order->fresh()->total_amount)->toBe(0.0);
});
