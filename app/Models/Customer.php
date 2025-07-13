<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'phone',
        'total_spent',
        'total_orders',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'total_spent' => 'decimal:2',
        ];
    }

    /**
     * Get the orders for the customer.
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    /**
     * Get the customer's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the customer's name (alias for full_name).
     */
    public function getNameAttribute()
    {
        return $this->getFullNameAttribute();
    }
}
