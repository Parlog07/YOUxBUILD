<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_status',
        'delivery_type',
        'estimated_date',
        'delivered_at',
    ];

    public $timestamps = false;

    // Reserved for the future shipping/delivery workflow.

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
