<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'category',
        'unit',
        'current_stock',
        'minimum_stock',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'minimum_stock' => 'decimal:2',
    ];

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function getStockStatusAttribute()
    {
        if ($this->current_stock <= 0) {
            return 'Habis';
        }

        if ($this->current_stock <= $this->minimum_stock) {
            return 'Stok Menipis';
        }

        return 'Aman';
    }
}