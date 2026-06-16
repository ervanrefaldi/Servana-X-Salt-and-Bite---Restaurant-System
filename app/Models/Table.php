<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'table_number',
        'area',
        'capacity',
        'status',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}