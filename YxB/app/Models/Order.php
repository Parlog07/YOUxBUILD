<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'address_id',
        'order_reference',
        'status',
        'total_amount',
        'ordered_at'
    ];

    protected $attributes = [
        'status' => OrderStatus::PENDING->value,
        'total_amount' => 0,
    ];

    /**
     * client_id points to users.id even though the column keeps the legacy "client" name.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function user()
    {
        return $this->client();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function syncTotalAmount(): void
    {
        $total = round(
            $this->items()
                ->get()
                ->sum(fn (OrderItem $item): float => (float) $item->unit_price * (int) $item->quantity),
            2
        );

        if ((float) $this->total_amount === $total) {
            return;
        }

        $this->forceFill(['total_amount' => $total])->saveQuietly();
    }
}
