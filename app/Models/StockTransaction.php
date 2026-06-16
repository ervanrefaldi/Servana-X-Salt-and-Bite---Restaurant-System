<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'ingredient_id',
        'ingredient_name',
        'supplier_name',
        'type',
        'quantity',
        'unit',
        'unit_price',
        'total_price',
        'transaction_date',
        'description',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}