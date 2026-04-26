<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    public $timestamps = false;

    protected static function booted(): void
    {
        static::saving(function (OrderItem $item): void {
            $item->subtotal = $item->calculateSubtotal();
        });

        static::saved(function (OrderItem $item): void {
            $item->syncParentOrderTotal();
        });

        static::deleted(function (OrderItem $item): void {
            $item->syncParentOrderTotal();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateSubtotal(): float
    {
        return round((float) $this->unit_price * (int) $this->quantity, 2);
    }

    private function syncParentOrderTotal(): void
    {
        $order = Order::find($this->order_id);

        if ($order) {
            $order->syncTotalAmount();
        }
    }
}
