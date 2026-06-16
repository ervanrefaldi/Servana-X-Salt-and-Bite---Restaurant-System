<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::latest()->get();

        return view('tables.index', compact('tables'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:20|unique:tables,table_number',
            'area' => 'required|in:indoor,outdoor',
            'capacity' => 'required|in:1,2,4,6,8,10',
            'status' => 'required|in:available,reserved,occupied,maintenance',
        ]);

        Table::create([
            'table_number' => $request->table_number,
            'area' => $request->area,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        return redirect()->route('tables.index')
            ->with('success', 'Data meja berhasil ditambahkan.');
    }

    public function show(Table $table)
    {
        return view('tables.show', compact('table'));
    }

    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_number' => 'required|string|max:20|unique:tables,table_number,' . $table->id,
            'area' => 'required|in:indoor,outdoor',
            'capacity' => 'required|in:1,2,4,6,8,10',
            'status' => 'required|in:available,reserved,occupied,maintenance',
        ]);

        $table->update([
            'table_number' => $request->table_number,
            'area' => $request->area,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        return redirect()->route('tables.index')
            ->with('success', 'Data meja berhasil diperbarui.');
    }
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Data meja berhasil dihapus.');
    }
}