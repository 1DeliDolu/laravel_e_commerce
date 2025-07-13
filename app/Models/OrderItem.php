<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'product_price',
        'quantity',
        'total'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that belongs to the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
