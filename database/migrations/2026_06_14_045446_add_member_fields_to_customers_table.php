<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (! Schema::hasColumn('customers', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('customers', 'email')) {
                $table->string('email')->nullable()->after('name');
            }

            if (! Schema::hasColumn('customers', 'is_member')) {
                $table->boolean('is_member')->default(false)->after('phone');
            }

            if (! Schema::hasColumn('customers', 'member_code')) {
                $table->string('member_code')->nullable()->unique()->after('is_member');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'member_code')) {
                $table->dropColumn('member_code');
            }

            if (Schema::hasColumn('customers', 'is_member')) {
                $table->dropColumn('is_member');
            }

            if (Schema::hasColumn('customers', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('customers', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};