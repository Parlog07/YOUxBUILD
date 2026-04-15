<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'client_id',
        'street',
        'city',
        'postal_code',
        'country',
        'is_default',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
