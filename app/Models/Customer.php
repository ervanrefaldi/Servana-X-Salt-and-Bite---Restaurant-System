<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'is_member',
        'member_code',
    ];

    protected $casts = [
        'is_member' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}