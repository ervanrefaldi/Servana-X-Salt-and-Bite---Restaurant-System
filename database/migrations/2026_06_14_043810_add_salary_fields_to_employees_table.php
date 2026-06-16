<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (! Schema::hasColumn('employees', 'salary')) {
                $table->decimal('salary', 12, 2)->default(0)->after('position');
            }

            if (! Schema::hasColumn('employees', 'employment_status')) {
                $table->enum('employment_status', ['active', 'inactive'])
                    ->default('active')
                    ->after('salary');
            }

            if (! Schema::hasColumn('employees', 'salary_status')) {
                $table->enum('salary_status', ['paid', 'unpaid'])
                    ->default('unpaid')
                    ->after('employment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'salary_status')) {
                $table->dropColumn('salary_status');
            }

            if (Schema::hasColumn('employees', 'employment_status')) {
                $table->dropColumn('employment_status');
            }

            if (Schema::hasColumn('employees', 'salary')) {
                $table->dropColumn('salary');
            }
        });
    }
};