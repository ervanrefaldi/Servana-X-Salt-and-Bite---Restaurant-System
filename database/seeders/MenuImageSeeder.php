<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'Chicken Rice Bowl' => 'images/menus/chicken-rice-bowl.jpg',
            'Beef Burger' => 'images/menus/beef-burger.jpg',
            'French Fries' => 'images/menus/french-fries.jpg',
            'Iced Lemon Tea' => 'images/menus/iced-lemon-tea.jpg',
            'Cappuccino' => 'images/menus/cappuccino.jpg',
            'Nasi Goreng Spesial' => 'images/menus/nasi-goreng-spesial.jpg',
            'Spaghetti Bolognese' => 'images/menus/spaghetti-bolognese.jpg',
            'Iced Matcha Latte' => 'images/menus/iced-matcha-latte.jpg',
            'Pisang Goreng Keju' => 'images/menus/pisang-goreng-keju.jpg',
            'Tenderloin Steak' => 'images/menus/tenderloin-steak.jpg',
            'Chocolate Lava Cake' => 'images/menus/chocolate-lava-cake.jpg',
        ];

        foreach ($images as $menuName => $imagePath) {
            if (!file_exists(public_path($imagePath))) {
                $this->command?->warn("Gambar tidak ditemukan, dilewati: {$imagePath}");
                continue;
            }

            $updated = Menu::where('name', $menuName)->update(['image' => $imagePath]);

            if ($updated === 0) {
                $this->command?->warn("Menu tidak ditemukan, dilewati: {$menuName}");
            }
        }
    }
}
