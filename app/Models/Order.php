<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'status',
        'order_date'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        $prefix = 'GFT-';
        $date = Carbon::now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastOrder ? (int)substr($lastOrder->order_number, -4) + 1 : 1;

        return $prefix . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger'
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }
}
