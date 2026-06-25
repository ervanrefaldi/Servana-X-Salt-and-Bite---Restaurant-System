<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use App\Models\Ingredient;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['creator', 'ingredient'])
            ->latest()
            ->get();

        $totalStockIn = StockTransaction::where('type', 'in')->count();

        $totalStockOut = StockTransaction::where('type', 'out')->count();

        $totalPurchaseCost = StockTransaction::where('type', 'in')
            ->where('status', 'cair')
            ->sum('total_price');

        return view('stock_transactions.index', compact(
            'transactions',
            'totalStockIn',
            'totalStockOut',
            'totalPurchaseCost'
        ));
    }

    public function create()
    {
        $ingredients = Ingredient::orderBy('name')->get();

        return view('stock_transactions.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'supplier_name' => 'nullable|string|max:100',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $ingredient = Ingredient::findOrFail($request->ingredient_id);

        if ($request->type === 'out' && $ingredient->current_stock < $request->quantity) {
            return back()
                ->withErrors(['quantity' => 'Stok bahan tidak mencukupi. Stok saat ini: ' . $ingredient->current_stock . ' ' . $ingredient->unit])
                ->withInput();
        }


        DB::beginTransaction();

        try {
            $totalPrice = $request->type === 'in'
                ? $request->quantity * $request->unit_price
                : 0;

            $status = $request->type === 'in' ? 'pengajuan' : 'selesai';

            StockTransaction::create([
                'ingredient_id' => $ingredient->id,
                'ingredient_name' => $ingredient->name,
                'supplier_name' => $request->supplier_name,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'unit' => $ingredient->unit,
                'unit_price' => $request->unit_price,
                'total_price' => $totalPrice,
                'transaction_date' => $request->transaction_date,
                'description' => $request->description,
                'status' => $status,
                'created_by' => auth()->id(),
            ]);

            if ($request->type === 'out') {
                $ingredient->decrement('current_stock', $request->quantity);
            }

            DB::commit();

            if ($request->type === 'in') {
                return redirect()->route('stock-transactions.index')
                    ->with('success', 'Pengajuan transaksi stok bahan berhasil ditambahkan dan menunggu persetujuan keuangan.');
            }

            return redirect()->route('stock-transactions.index')
                ->with('success', 'Transaksi penggunaan stok bahan berhasil dicatat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(StockTransaction $stockTransaction)
    {
        $stockTransaction->load(['creator', 'ingredient']);

        return view('stock_transactions.show', compact('stockTransaction'));
    }

    public function updateStatus(Request $request, StockTransaction $stockTransaction)
    {
        $request->validate([
            'status' => 'required|in:cair,ditolak'
        ]);

        if ($stockTransaction->status !== 'pengajuan') {
            return back()->withErrors(['error' => 'Status transaksi tidak dapat diubah.']);
        }

        DB::beginTransaction();

        try {
            $stockTransaction->update(['status' => $request->status]);

            if ($request->status === 'cair') {

                $ingredient = Ingredient::find($stockTransaction->ingredient_id);
                if ($ingredient) {
                    $ingredient->increment('current_stock', $stockTransaction->quantity);
                }

                if ($stockTransaction->total_price > 0) {
                    FinancialTransaction::create([
                        'order_id' => null,
                        'type' => 'expense',
                        'category' => 'stock_purchase',
                        'title' => 'Pembelian stok ' . $stockTransaction->ingredient_name,
                        'amount' => $stockTransaction->total_price,
                        'transaction_date' => $stockTransaction->transaction_date,
                        'description' => 'Pembelian bahan. Supplier: ' . ($stockTransaction->supplier_name ?? '-'),
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'Status transaksi berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}