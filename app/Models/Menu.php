<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'stock',
        'image',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_available' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return $this->imageIsPublicAsset()
            ? asset($this->image)
            : Storage::disk('public')->url($this->image);
    }

    public function getHasImageAttribute(): bool
    {
        if (!$this->image) {
            return false;
        }

        return $this->imageIsPublicAsset()
            ? file_exists(public_path($this->image))
            : Storage::disk('public')->exists($this->image);
    }

    public function imageIsPublicAsset(): bool
    {
        return Str::startsWith($this->image ?? '', 'images/');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function menuIngredients()
    {
        return $this->hasMany(MenuIngredient::class);
    }

    public function getStockAttribute($value)
    {
        // If there are no ingredients specified, return the manual stock value or 0
        if ($this->menuIngredients()->count() === 0) {
            return $value;
        }

        $minStock = null;
        foreach ($this->menuIngredients as $menuIngredient) {
            $ingredient = $menuIngredient->ingredient;
            if (!$ingredient || $menuIngredient->quantity <= 0) {
                continue;
            }

            // Calculate how many portions can be made with the current ingredient stock
            $possiblePortions = floor($ingredient->current_stock / $menuIngredient->quantity);

            if ($minStock === null || $possiblePortions < $minStock) {
                $minStock = $possiblePortions;
            }
        }

        return $minStock !== null ? $minStock : 0;
    }
}
