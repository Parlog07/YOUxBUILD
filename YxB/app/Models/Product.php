<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'description',
        'technical_specs',
        'price',
        'stock_quantity',
        'availability_status',
        'image_url',
        'product_type',
    ];

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class, 'vendor_id', 'vendor_id');
    }

    public function vendor()
    {
        return $this->vendorProfile();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
