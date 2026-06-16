<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('salary_month');
            $table->unsignedSmallInteger('salary_year');

            $table->decimal('amount', 12, 2)->default(0);

            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');

            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(['employee_id', 'salary_month', 'salary_year'], 'unique_employee_salary_period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_payments');
    }
};