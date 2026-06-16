<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();

        $totalIngredients = Ingredient::count();

        $lowStockIngredients = Ingredient::whereColumn('current_stock', '<=', 'minimum_stock')
            ->where('current_stock', '>', 0)
            ->count();

        $emptyStockIngredients = Ingredient::where('current_stock', '<=', 0)->count();

        return view('ingredients.index', compact(
            'ingredients',
            'totalIngredients',
            'lowStockIngredients',
            'emptyStockIngredients'
        ));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name',
            'category' => 'nullable|string|max:100',
            'unit' => 'required|string|max:30',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
        ]);

        Ingredient::create([
            'name' => $request->name,
            'category' => $request->category,
            'unit' => $request->unit,
            'current_stock' => $request->current_stock,
            'minimum_stock' => $request->minimum_stock,
        ]);

        return redirect()->route('ingredients.index')
            ->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function show(Ingredient $ingredient)
    {
        $ingredient->load(['stockTransactions.creator']);

        return view('ingredients.show', compact('ingredient'));
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:ingredients,name,' . $ingredient->id,
            'category' => 'nullable|string|max:100',
            'unit' => 'required|string|max:30',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
        ]);

        $ingredient->update([
            'name' => $request->name,
            'category' => $request->category,
            'unit' => $request->unit,
            'current_stock' => $request->current_stock,
            'minimum_stock' => $request->minimum_stock,
        ]);

        return redirect()->route('ingredients.index')
            ->with('success', 'Data bahan berhasil diperbarui.');
    }

    public function destroy(Ingredient $ingredient)
    {
        if ($ingredient->stockTransactions()->exists()) {
            return back()->withErrors([
                'delete' => 'Bahan tidak dapat dihapus karena sudah memiliki riwayat transaksi stok.',
            ]);
        }

        $ingredient->delete();

        return redirect()->route('ingredients.index')
            ->with('success', 'Bahan berhasil dihapus.');
    }
}