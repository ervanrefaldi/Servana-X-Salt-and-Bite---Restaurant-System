<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    public function index()
    {
        return view('admin_reports.index');
    }

    public function financial(Request $request)
    {
        $transactions = $this->financialQuery($request)->get();

        $totalIncome = $transactions
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = $transactions
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        return view('admin_reports.financial', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance'
        ));
    }

    public function financialExcel(Request $request): StreamedResponse
    {
        $transactions = $this->financialQuery($request)->get();

        $fileName = 'laporan-keuangan-servana-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        return response()->stream(function () use ($transactions) {
            $handle = fopen('php://output', 'w');

            // BOM agar Excel membaca UTF-8 dengan baik
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Tanggal',
                'Judul Transaksi',
                'Tipe',
                'Kategori',
                'Nominal',
                'Dibuat Oleh',
                'Keterangan',
            ], ';');

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    optional($transaction->transaction_date)->format('d-m-Y'),
                    $transaction->title,
                    $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    ucfirst(str_replace('_', ' ', $transaction->category)),
                    $transaction->amount,
                    $transaction->creator->name ?? '-',
                    $transaction->description ?? '-',
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function financialPdf(Request $request)
    {
        $transactions = $this->financialQuery($request)->get();

        $totalIncome = $transactions
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = $transactions
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        return view('admin_reports.print_financial', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance'
        ));
    }

    private function financialQuery(Request $request)
    {
        $query = FinancialTransaction::with(['creator', 'order']);

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

        return $query->latest('transaction_date')->latest();
    }
}