<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('salary_payments', function (Blueprint $table) {
            if (! Schema::hasColumn('salary_payments', 'daily_salary')) {
                $table->decimal('daily_salary', 12, 2)->default(0)->after('basic_salary');
            }

            if (! Schema::hasColumn('salary_payments', 'payable_days')) {
                $table->unsignedInteger('payable_days')->default(0)->after('daily_salary');
            }

            if (! Schema::hasColumn('salary_payments', 'base_salary_for_period')) {
                $table->decimal('base_salary_for_period', 12, 2)->default(0)->after('payable_days');
            }
        });
    }

    public function down(): void
    {
        Schema::table('salary_payments', function (Blueprint $table) {
            if (Schema::hasColumn('salary_payments', 'base_salary_for_period')) {
                $table->dropColumn('base_salary_for_period');
            }

            if (Schema::hasColumn('salary_payments', 'payable_days')) {
                $table->dropColumn('payable_days');
            }

            if (Schema::hasColumn('salary_payments', 'daily_salary')) {
                $table->dropColumn('daily_salary');
            }
        });
    }
};