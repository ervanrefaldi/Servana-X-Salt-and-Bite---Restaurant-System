<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    protected $fillable = [
        'employee_id',
        'salary_month',
        'salary_year',
        'period_start',
        'period_end',
        'basic_salary',
        'daily_salary',
        'payable_days',
        'base_salary_for_period',
        'absent_days',
        'bonus',
        'deduction',
        'bonus_status',
        'bonus_note',
        'amount',
        'status',
        'payment_date',
        'note',
        'created_by',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'basic_salary' => 'decimal:2',
        'daily_salary' => 'decimal:2',
        'base_salary_for_period' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deduction' => 'decimal:2',
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}