<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::latest()->get();

        $deletableTableIds = [];
        $groupedTables = $tables->groupBy(function ($table) {
            $parts = explode('-', $table->table_number);
            return strtoupper($parts[0] ?? '');
        });

        foreach ($groupedTables as $letter => $group) {
            $latestTable = $group->sortByDesc(function ($table) {
                $parts = explode('-', $table->table_number);
                return isset($parts[1]) ? (int)$parts[1] : 0;
            })->first();

            if ($latestTable) {
                $deletableTableIds[] = $latestTable->id;
            }
        }

        return view('tables.index', compact('tables', 'deletableTableIds'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_group' => ['required', 'string', 'size:1', 'regex:/^[A-Ja-j]$/'],
            'area' => 'required|in:indoor,outdoor',
            'status' => 'required|in:available,reserved,occupied,maintenance',
        ]);

        $letter = strtoupper($request->table_group);
        $capacity = (ord($letter) - 64) * 2;

        $latestTable = Table::where('table_number', 'LIKE', $letter . '-%')
            ->get()
            ->sortByDesc(function ($table) {
                $parts = explode('-', $table->table_number);
                return isset($parts[1]) ? (int)$parts[1] : 0;
            })
            ->first();

        $nextNumber = 1;
        if ($latestTable) {
            $parts = explode('-', $latestTable->table_number);
            $nextNumber = isset($parts[1]) ? (int)$parts[1] + 1 : 1;
        }

        $tableNumber = $letter . '-' . $nextNumber;

        Table::create([
            'table_number' => $tableNumber,
            'area' => $request->area,
            'capacity' => $capacity,
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
            'area' => 'required|in:indoor,outdoor',
            'status' => 'required|in:available,reserved,occupied,maintenance',
        ]);

        $table->update([
            'area' => $request->area,
            'status' => $request->status,
        ]);

        return redirect()->route('tables.index')
            ->with('success', 'Data meja berhasil diperbarui.');
    }
    public function destroy(Table $table)
    {
        $parts = explode('-', $table->table_number);
        $letter = strtoupper($parts[0] ?? '');
        
        $latestTable = Table::where('table_number', 'LIKE', $letter . '-%')
            ->get()
            ->sortByDesc(function ($t) {
                $p = explode('-', $t->table_number);
                return isset($p[1]) ? (int)$p[1] : 0;
            })
            ->first();

        if ($latestTable && $latestTable->id !== $table->id) {
            return redirect()->route('tables.index')
                ->with('error', 'Hanya meja terakhir pada grup abjad ini yang dapat dihapus.');
        }

        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Data meja berhasil dihapus.');
    }
}