<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_status',
        'stripe_payment_intent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
