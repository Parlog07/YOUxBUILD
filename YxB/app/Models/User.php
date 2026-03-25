<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public function vendorProfile()
    {
        return $this->hasOne(VendorProfile::class, 'vendor_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'client_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'client_id');
    }
}
