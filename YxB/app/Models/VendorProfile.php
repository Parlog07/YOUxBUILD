<?php

namespace App\Models;

use App\Enums\VendorApprovalStatus;
use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    protected $primaryKey = 'vendor_id';
    protected $fillable = [
        'vendor_id',
        'store_name',
        'store_description',
        'business_address',
        'status',
    ];
    public $incrementing = false;
    public $timestamps = false;

    protected $attributes = [
        'status' => VendorApprovalStatus::PENDING->value,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id', 'vendor_id');
    }
}
