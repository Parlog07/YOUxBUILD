<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    protected $primaryKey = 'vendor_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id', 'vendor_id');
    }
}
