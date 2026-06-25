<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('menuIngredients.ingredient')->latest()->get();

        return view('menus.index', compact('menus'));
    }

    public function publicMenu()
    {
        $menus = Menu::with('menuIngredients.ingredient')
            ->where('is_available', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('menus.public', compact('menus'));
    }

    public function create()
    {
        $ingredients = Ingredient::all();
        return view('menus.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        if ($request->has('ingredients')) {
            $filtered = array_filter($request->ingredients, function($val) {
                return !empty($val['id']);
            });
            $request->merge(['ingredients' => $filtered]);
        }
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'ingredients' => 'nullable|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $menu = Menu::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => 0,
            'image' => null,
            'is_available' => $request->is_available,
        ]);

        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredientData) {
                $menu->menuIngredients()->create([
                    'ingredient_id' => $ingredientData['id'],
                    'quantity' => $ingredientData['quantity'],
                ]);
            }
        }

        return redirect()->route('menus.index')
            ->with('success', 'Data menu berhasil ditambahkan.');
    }

    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $ingredients = Ingredient::all();
        $menu->load('menuIngredients.ingredient');
        return view('menus.edit', compact('menu', 'ingredients'));
    }

    public function update(Request $request, Menu $menu)
    {
        if ($request->has('ingredients')) {
            $filtered = array_filter($request->ingredients, function($val) {
                return !empty($val['id']);
            });
            $request->merge(['ingredients' => $filtered]);
        }
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'ingredients' => 'nullable|array',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $menu->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'is_available' => $request->is_available,
        ]);

        $menu->menuIngredients()->delete();

        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredientData) {
                $menu->menuIngredients()->create([
                    'ingredient_id' => $ingredientData['id'],
                    'quantity' => $ingredientData['quantity'],
                ]);
            }
        }

        return redirect()->route('menus.index')
            ->with('success', 'Data menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Data menu berhasil dihapus.');
    }
}