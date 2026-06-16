<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'customer_id',
        'table_id',
        'reservation_code',
        'customer_name',
        'customer_phone',
        'reservation_date',
        'start_time',
        'end_time',
        'total_guest',
        'reservation_type',
        'table_selection_type',
        'status',
        'note',
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}