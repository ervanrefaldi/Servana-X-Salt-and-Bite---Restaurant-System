<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (! Schema::hasColumn('employees', 'email')) {
                $table->string('email')->nullable()->after('name');
            }

            if (! Schema::hasColumn('employees', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (! Schema::hasColumn('employees', 'position')) {
                $table->string('position')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('employees', 'basic_salary')) {
                $table->decimal('basic_salary', 12, 2)->default(0)->after('position');
            }

            if (! Schema::hasColumn('employees', 'employment_status')) {
                $table->enum('employment_status', ['active', 'inactive', 'resigned'])
                    ->default('active')
                    ->after('basic_salary');
            }
        });

        Schema::table('salary_payments', function (Blueprint $table) {
            if (! Schema::hasColumn('salary_payments', 'basic_salary')) {
                $table->decimal('basic_salary', 12, 2)->default(0)->after('salary_year');
            }

            if (! Schema::hasColumn('salary_payments', 'absent_days')) {
                $table->unsignedInteger('absent_days')->default(0)->after('basic_salary');
            }

            if (! Schema::hasColumn('salary_payments', 'bonus')) {
                $table->decimal('bonus', 12, 2)->default(0)->after('absent_days');
            }

            if (! Schema::hasColumn('salary_payments', 'deduction')) {
                $table->decimal('deduction', 12, 2)->default(0)->after('bonus');
            }
        });
    }

    public function down(): void
    {
        Schema::table('salary_payments', function (Blueprint $table) {
            if (Schema::hasColumn('salary_payments', 'deduction')) {
                $table->dropColumn('deduction');
            }

            if (Schema::hasColumn('salary_payments', 'bonus')) {
                $table->dropColumn('bonus');
            }

            if (Schema::hasColumn('salary_payments', 'absent_days')) {
                $table->dropColumn('absent_days');
            }

            if (Schema::hasColumn('salary_payments', 'basic_salary')) {
                $table->dropColumn('basic_salary');
            }
        });

        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};