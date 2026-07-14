<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Ingredient;
use App\Models\MenuIngredient;
use Illuminate\Database\Seeder;

class AdditionalMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Nasi Goreng Spesial
        $nasi = Ingredient::firstOrCreate(['name' => 'Nasi Putih'], ['category' => 'Bahan Pokok', 'unit' => 'kg', 'current_stock' => 50, 'minimum_stock' => 10]);
        $telur = Ingredient::firstOrCreate(['name' => 'Telur Ayam'], ['category' => 'Bahan Pokok', 'unit' => 'butir', 'current_stock' => 100, 'minimum_stock' => 20]);
        $ayam = Ingredient::firstOrCreate(['name' => 'Daging Ayam'], ['category' => 'Daging', 'unit' => 'kg', 'current_stock' => 30, 'minimum_stock' => 5]);
        $bumbuNasgor = Ingredient::firstOrCreate(['name' => 'Bumbu Nasi Goreng'], ['category' => 'Bumbu', 'unit' => 'porsi', 'current_stock' => 100, 'minimum_stock' => 20]);

        $nasiGoreng = Menu::create([
            'name' => 'Nasi Goreng Spesial',
            'category' => 'Makanan',
            'description' => 'Nasi goreng lezat dengan telur dan suwiran ayam.',
            'price' => 25000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $nasiGoreng->id, 'ingredient_id' => $nasi->id, 'quantity' => 0.2]); // 200 gram
        MenuIngredient::create(['menu_id' => $nasiGoreng->id, 'ingredient_id' => $telur->id, 'quantity' => 1]); // 1 butir
        MenuIngredient::create(['menu_id' => $nasiGoreng->id, 'ingredient_id' => $ayam->id, 'quantity' => 0.1]); // 100 gram
        MenuIngredient::create(['menu_id' => $nasiGoreng->id, 'ingredient_id' => $bumbuNasgor->id, 'quantity' => 1]);

        // 2. Spaghetti Bolognese
        $spaghetti = Ingredient::firstOrCreate(['name' => 'Pasta Spaghetti'], ['category' => 'Bahan Pokok', 'unit' => 'kg', 'current_stock' => 20, 'minimum_stock' => 5]);
        $dagingSapi = Ingredient::firstOrCreate(['name' => 'Daging Sapi Giling'], ['category' => 'Daging', 'unit' => 'kg', 'current_stock' => 15, 'minimum_stock' => 5]);
        $sausBolognese = Ingredient::firstOrCreate(['name' => 'Saus Bolognese'], ['category' => 'Bumbu', 'unit' => 'liter', 'current_stock' => 10, 'minimum_stock' => 2]);

        $spaghettiBolognese = Menu::create([
            'name' => 'Spaghetti Bolognese',
            'category' => 'Makanan',
            'description' => 'Pasta spaghetti dengan saus daging bolognese yang kaya rasa.',
            'price' => 32000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $spaghettiBolognese->id, 'ingredient_id' => $spaghetti->id, 'quantity' => 0.15]);
        MenuIngredient::create(['menu_id' => $spaghettiBolognese->id, 'ingredient_id' => $dagingSapi->id, 'quantity' => 0.1]);
        MenuIngredient::create(['menu_id' => $spaghettiBolognese->id, 'ingredient_id' => $sausBolognese->id, 'quantity' => 0.05]);

        // 3. Iced Matcha Latte
        $bubukMatcha = Ingredient::firstOrCreate(['name' => 'Bubuk Matcha'], ['category' => 'Bahan Minuman', 'unit' => 'kg', 'current_stock' => 5, 'minimum_stock' => 1]);
        $susu = Ingredient::firstOrCreate(['name' => 'Susu Cair'], ['category' => 'Bahan Minuman', 'unit' => 'liter', 'current_stock' => 30, 'minimum_stock' => 5]);
        $esBatu = Ingredient::firstOrCreate(['name' => 'Es Batu'], ['category' => 'Bahan Minuman', 'unit' => 'kg', 'current_stock' => 50, 'minimum_stock' => 10]);

        $matchaLatte = Menu::create([
            'name' => 'Iced Matcha Latte',
            'category' => 'Minuman',
            'description' => 'Matcha latte dingin dengan perpaduan susu segar.',
            'price' => 24000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $matchaLatte->id, 'ingredient_id' => $bubukMatcha->id, 'quantity' => 0.02]);
        MenuIngredient::create(['menu_id' => $matchaLatte->id, 'ingredient_id' => $susu->id, 'quantity' => 0.2]);
        MenuIngredient::create(['menu_id' => $matchaLatte->id, 'ingredient_id' => $esBatu->id, 'quantity' => 0.2]);

        // 4. Pisang Goreng Keju
        $pisang = Ingredient::firstOrCreate(['name' => 'Pisang'], ['category' => 'Buah', 'unit' => 'sisir', 'current_stock' => 10, 'minimum_stock' => 2]);
        $tepung = Ingredient::firstOrCreate(['name' => 'Tepung Terigu'], ['category' => 'Bahan Pokok', 'unit' => 'kg', 'current_stock' => 20, 'minimum_stock' => 5]);
        $keju = Ingredient::firstOrCreate(['name' => 'Keju Cheddar'], ['category' => 'Bahan Pokok', 'unit' => 'block', 'current_stock' => 15, 'minimum_stock' => 3]);

        $pisangGoreng = Menu::create([
            'name' => 'Pisang Goreng Keju',
            'category' => 'Snack',
            'description' => 'Pisang goreng renyah dengan taburan keju melimpah.',
            'price' => 15000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $pisangGoreng->id, 'ingredient_id' => $pisang->id, 'quantity' => 0.1]); // 0.1 sisir
        MenuIngredient::create(['menu_id' => $pisangGoreng->id, 'ingredient_id' => $tepung->id, 'quantity' => 0.05]);
        MenuIngredient::create(['menu_id' => $pisangGoreng->id, 'ingredient_id' => $keju->id, 'quantity' => 0.1]);

        // 5. Steak Sapi
        $bumbuSteak = Ingredient::firstOrCreate(['name' => 'Bumbu Marinasi Steak'], ['category' => 'Bumbu', 'unit' => 'liter', 'current_stock' => 5, 'minimum_stock' => 1]);
        $kentang = Ingredient::firstOrCreate(['name' => 'Kentang'], ['category' => 'Sayur', 'unit' => 'kg', 'current_stock' => 25, 'minimum_stock' => 5]);

        $steak = Menu::create([
            'name' => 'Tenderloin Steak',
            'category' => 'Makanan',
            'description' => 'Steak daging sapi tenderloin disajikan dengan kentang goreng.',
            'price' => 85000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $steak->id, 'ingredient_id' => $dagingSapi->id, 'quantity' => 0.2]); // 200g
        MenuIngredient::create(['menu_id' => $steak->id, 'ingredient_id' => $bumbuSteak->id, 'quantity' => 0.05]);
        MenuIngredient::create(['menu_id' => $steak->id, 'ingredient_id' => $kentang->id, 'quantity' => 0.15]);

        // 6. Chocolate Lava Cake
        $tepungCokelat = Ingredient::firstOrCreate(['name' => 'Tepung Cokelat'], ['category' => 'Bahan Dessert', 'unit' => 'kg', 'current_stock' => 10, 'minimum_stock' => 2]);
        $darkChocolate = Ingredient::firstOrCreate(['name' => 'Dark Chocolate'], ['category' => 'Bahan Dessert', 'unit' => 'kg', 'current_stock' => 8, 'minimum_stock' => 2]);
        $butter = Ingredient::firstOrCreate(['name' => 'Butter'], ['category' => 'Bahan Dessert', 'unit' => 'kg', 'current_stock' => 6, 'minimum_stock' => 1]);

        $lavaCake = Menu::create([
            'name' => 'Chocolate Lava Cake',
            'category' => 'Dessert',
            'description' => 'Kue cokelat hangat dengan lelehan cokelat di bagian tengah.',
            'price' => 28000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $lavaCake->id, 'ingredient_id' => $tepungCokelat->id, 'quantity' => 0.08]);
        MenuIngredient::create(['menu_id' => $lavaCake->id, 'ingredient_id' => $darkChocolate->id, 'quantity' => 0.05]);
        MenuIngredient::create(['menu_id' => $lavaCake->id, 'ingredient_id' => $butter->id, 'quantity' => 0.03]);

        // 7. Panna Cotta Berry
        $gelatin = Ingredient::firstOrCreate(['name' => 'Gelatin'], ['category' => 'Bahan Dessert', 'unit' => 'kg', 'current_stock' => 3, 'minimum_stock' => 0.5]);
        $krim = Ingredient::firstOrCreate(['name' => 'Krim Cair'], ['category' => 'Bahan Dessert', 'unit' => 'liter', 'current_stock' => 12, 'minimum_stock' => 2]);
        $sausBerry = Ingredient::firstOrCreate(['name' => 'Saus Berry'], ['category' => 'Bahan Dessert', 'unit' => 'liter', 'current_stock' => 6, 'minimum_stock' => 1]);

        $pannaCotta = Menu::create([
            'name' => 'Panna Cotta Berry',
            'category' => 'Dessert',
            'description' => 'Panna cotta lembut dengan saus berry segar.',
            'price' => 26000,
            'is_available' => true,
        ]);

        MenuIngredient::create(['menu_id' => $pannaCotta->id, 'ingredient_id' => $gelatin->id, 'quantity' => 0.01]);
        MenuIngredient::create(['menu_id' => $pannaCotta->id, 'ingredient_id' => $krim->id, 'quantity' => 0.15]);
        MenuIngredient::create(['menu_id' => $pannaCotta->id, 'ingredient_id' => $sausBerry->id, 'quantity' => 0.04]);
    }
}
