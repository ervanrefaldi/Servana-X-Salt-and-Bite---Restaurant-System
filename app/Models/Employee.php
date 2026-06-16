<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'hire_date',
        'position',
        'salary',
        'basic_salary',
        'bonus',
        'deduction',
        'total_salary',
        'employment_status',
        'salary_status',
        'salary_payment_date',
    ];

    protected $casts = [
        'salary' => 'decimal:2',
        'basic_salary' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deduction' => 'decimal:2',
        'total_salary' => 'decimal:2',
        'hire_date' => 'date',
        'salary_payment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }
}