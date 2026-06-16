<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialTransaction::with(['order', 'creator']);

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('source') && $request->source !== 'all') {
            if ($request->source === 'pos') {
                $query->where('category', 'sales');
            } elseif ($request->source === 'dapur') {
                $query->where('category', 'stock_purchase');
            } elseif ($request->source === 'sdm') {
                $query->where('category', 'salary');
            } elseif ($request->source === 'manual') {
                $query->whereIn('category', [
                    'operational',
                    'maintenance',
                    'other',
                ]);
            }
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $transactions = $query->latest('transaction_date')
            ->latest()
            ->get();

        $summaryQuery = FinancialTransaction::query();

        if ($request->filled('start_date')) {
            $summaryQuery->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $summaryQuery->whereDate('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $summaryQuery->where('type', $request->type);
        }

        if ($request->filled('source') && $request->source !== 'all') {
            if ($request->source === 'pos') {
                $summaryQuery->where('category', 'sales');
            } elseif ($request->source === 'dapur') {
                $summaryQuery->where('category', 'stock_purchase');
            } elseif ($request->source === 'sdm') {
                $summaryQuery->where('category', 'salary');
            } elseif ($request->source === 'manual') {
                $summaryQuery->whereIn('category', [
                    'operational',
                    'maintenance',
                    'other',
                ]);
            }
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $summaryQuery->where('category', $request->category);
        }

        $totalIncome = (clone $summaryQuery)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = (clone $summaryQuery)
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $salesIncome = (clone $summaryQuery)
            ->where('category', 'sales')
            ->sum('amount');

        $stockExpense = (clone $summaryQuery)
            ->where('category', 'stock_purchase')
            ->sum('amount');

        $salaryExpense = (clone $summaryQuery)
            ->where('category', 'salary')
            ->sum('amount');

        $manualTransactionTotal = (clone $summaryQuery)
            ->whereIn('category', [
                'operational',
                'maintenance',
                'other',
            ])
            ->sum('amount');

        return view('financial_transactions.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'salesIncome',
            'stockExpense',
            'salaryExpense',
            'manualTransactionTotal'
        ));
    }

    public function create()
    {
        return view('financial_transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|in:operational,maintenance,other',
            'title' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        FinancialTransaction::create([
            'order_id' => null,
            'type' => $request->type,
            'category' => $request->category,
            'title' => $request->title,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('financial-transactions.index')
            ->with('success', 'Transaksi keuangan manual berhasil ditambahkan.');
    }

    public function show(FinancialTransaction $financialTransaction)
    {
        $financialTransaction->load(['order', 'creator']);

        return view('financial_transactions.show', compact('financialTransaction'));
    }
}