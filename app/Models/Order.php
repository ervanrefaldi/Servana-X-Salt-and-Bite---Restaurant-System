<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cashier_id',
        'customer_id',
        'reservation_id',
        'order_code',
        'customer_name',
        'customer_phone',
        'is_member',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'is_member' => 'boolean',
        'subtotal' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function financialTransaction()
    {
        return $this->hasOne(FinancialTransaction::class);
    }
}