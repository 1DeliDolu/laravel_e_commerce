<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Get the product that belongs to the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the customer that owns the cart.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Calculate total price for this cart item
     */
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}
