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
        'phone_number',
        'email',
        'is_default',
    ];

    public $timestamps = false;

    /**
     * client_id keeps the legacy name, but the owning model is App\Models\User.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function user()
    {
        return $this->client();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
