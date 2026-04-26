<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_reference',
        'paid_at',
    ];

    public $timestamps = false;

    // Reserved for the future checkout/payment integration.

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
