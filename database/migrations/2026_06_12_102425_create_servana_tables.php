<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('password');
            $table->enum('role', [
                'admin',
                'member',
                'resepsionis',
                'kasir',
                'keuangan',
                'dapur',
                'sdm'
            ])->default('member')->after('phone');
            $table->boolean('is_active')->default(true)->after('role');
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('is_member')->default(false);
            $table->string('member_code', 50)->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number', 20)->unique();
            $table->enum('area', ['indoor', 'outdoor']);
            $table->integer('capacity');
            $table->enum('status', [
                'available',
                'reserved',
                'occupied',
                'maintenance'
            ])->default('available');
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('table_id')->nullable()->constrained('tables')->nullOnDelete();
            $table->string('reservation_code', 50)->unique();
            $table->string('customer_name', 100);
            $table->string('customer_phone', 20);
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('total_guest');
            $table->enum('reservation_type', ['member', 'non_member']);
            $table->enum('table_selection_type', ['manual', 'automatic']);
            $table->enum('status', [
                'pending',
                'confirmed',
                'seated',
                'completed',
                'cancelled',
                'no_show'
            ])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('category', 50)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();
            $table->string('order_code', 50)->unique();
            $table->string('customer_name', 100)->nullable();
            $table->string('customer_phone', 20)->nullable();
            $table->boolean('is_member')->default(false);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('payment_method', [
                'cash',
                'debit',
                'qris',
                'transfer'
            ])->nullable();
            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'cancelled'
            ])->default('unpaid');
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->enum('promo_type', [
                'general',
                'member_only',
                'special_day'
            ]);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('ingredient_name', 100);
            $table->string('supplier_name', 100)->nullable();
            $table->enum('type', ['in', 'out']);
            $table->decimal('quantity', 12, 2);
            $table->string('unit', 30);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->enum('type', ['income', 'expense']);
            $table->enum('category', [
                'sales',
                'operational',
                'salary',
                'stock_purchase',
                'maintenance',
                'other'
            ]);
            $table->string('title', 100);
            $table->decimal('amount', 12, 2);
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 100);
            $table->string('position', 100);
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('hire_date')->nullable();
            $table->enum('employment_status', [
                'active',
                'inactive',
                'resigned'
            ])->default('active');
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('deduction', 12, 2)->default(0);
            $table->decimal('total_salary', 12, 2)->default(0);
            $table->enum('salary_status', [
                'unpaid',
                'paid'
            ])->default('unpaid');
            $table->date('salary_payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('financial_transactions');
        Schema::dropIfExists('stock_transactions');
        Schema::dropIfExists('promos');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('tables');
        Schema::dropIfExists('customers');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'is_active']);
        });
    }
};