<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Table;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ServanaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Servana',
            'email' => 'admin@servana.com',
            'password' => Hash::make('password'),
            'phone' => '081111111111',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $resepsionis = User::create([
            'name' => 'Resepsionis Servana',
            'email' => 'resepsionis@servana.com',
            'password' => Hash::make('password'),
            'phone' => '082222222222',
            'role' => 'resepsionis',
            'is_active' => true,
        ]);

        $kasir = User::create([
            'name' => 'Kasir Servana',
            'email' => 'kasir@servana.com',
            'password' => Hash::make('password'),
            'phone' => '083333333333',
            'role' => 'kasir',
            'is_active' => true,
        ]);

        $keuangan = User::create([
            'name' => 'Keuangan Servana',
            'email' => 'keuangan@servana.com',
            'password' => Hash::make('password'),
            'phone' => '084444444444',
            'role' => 'keuangan',
            'is_active' => true,
        ]);

        $dapur = User::create([
            'name' => 'Dapur Servana',
            'email' => 'dapur@servana.com',
            'password' => Hash::make('password'),
            'phone' => '085555555555',
            'role' => 'dapur',
            'is_active' => true,
        ]);

        $sdm = User::create([
            'name' => 'SDM Servana',
            'email' => 'sdm@servana.com',
            'password' => Hash::make('password'),
            'phone' => '086666666666',
            'role' => 'sdm',
            'is_active' => true,
        ]);

        $memberUser = User::create([
            'name' => 'Member Contoh',
            'email' => 'member@servana.com',
            'password' => Hash::make('password'),
            'phone' => '087777777777',
            'role' => 'member',
            'is_active' => true,
        ]);

        Customer::create([
            'user_id' => $memberUser->id,
            'name' => 'Member Contoh',
            'phone' => '087777777777',
            'email' => 'member@servana.com',
            'is_member' => true,
            'member_code' => 'MBR001',
        ]);

        Customer::create([
            'user_id' => null,
            'name' => 'Customer Biasa',
            'phone' => '088888888888',
            'email' => 'customer@example.com',
            'is_member' => false,
            'member_code' => null,
        ]);

        $tablesData = [];
        foreach (range('A', 'J') as $letter) {
            $capacity = (ord($letter) - 64) * 2;
            $area = $capacity <= 10 ? 'indoor' : 'outdoor';
            
            for ($i = 1; $i <= 7; $i++) {
                $tablesData[] = [
                    'table_number' => "{$letter}-{$i}",
                    'area' => $area,
                    'capacity' => $capacity,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        Table::insert($tablesData);

        Menu::insert([
            [
                'name' => 'Chicken Rice Bowl',
                'category' => 'Makanan',
                'description' => 'Nasi dengan ayam berbumbu khas.',
                'price' => 28000,
                'image' => null,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beef Burger',
                'category' => 'Makanan',
                'description' => 'Burger daging sapi dengan saus spesial.',
                'price' => 35000,
                'image' => null,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'French Fries',
                'category' => 'Snack',
                'description' => 'Kentang goreng renyah.',
                'price' => 18000,
                'image' => null,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iced Lemon Tea',
                'category' => 'Minuman',
                'description' => 'Teh lemon dingin segar.',
                'price' => 15000,
                'image' => null,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cappuccino',
                'category' => 'Minuman',
                'description' => 'Kopi cappuccino hangat.',
                'price' => 22000,
                'image' => null,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Promo::create([
            'title' => 'Promo Hari Besar',
            'description' => 'Promo khusus pada hari besar atau event tertentu.',
            'promo_type' => 'special_day',
            'discount_percent' => 10,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(30)->toDateString(),
            'is_active' => true,
        ]);

        Employee::insert([
            [
                'user_id' => $resepsionis->id,
                'name' => 'Resepsionis Servana',
                'position' => 'Resepsionis',
                'phone' => '082222222222',
                'address' => 'Tasikmalaya',
                'hire_date' => now()->toDateString(),
                'employment_status' => 'active',
                'basic_salary' => 2500000,
                'bonus' => 0,
                'deduction' => 0,
                'total_salary' => 2500000,
                'salary_status' => 'unpaid',
                'salary_payment_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $kasir->id,
                'name' => 'Kasir Servana',
                'position' => 'Kasir',
                'phone' => '083333333333',
                'address' => 'Tasikmalaya',
                'hire_date' => now()->toDateString(),
                'employment_status' => 'active',
                'basic_salary' => 2500000,
                'bonus' => 0,
                'deduction' => 0,
                'total_salary' => 2500000,
                'salary_status' => 'unpaid',
                'salary_payment_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}