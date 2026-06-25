<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\FinancialTransaction;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\StockTransaction;
use App\Models\Table;
use App\Models\Ingredient;
use App\Models\User;
use App\Models\SalaryPayment;

class DashboardController extends Controller
{
    public function redirect()
    {
        $role = auth()->user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'member' => redirect()->route('member.dashboard'),
            'resepsionis' => redirect()->route('resepsionis.dashboard'),
            'kasir' => redirect()->route('kasir.dashboard'),
            'keuangan' => redirect()->route('keuangan.dashboard'),
            'dapur' => redirect()->route('dapur.dashboard'),
            'sdm' => redirect()->route('sdm.dashboard'),
            default => abort(403, 'Role tidak dikenali.'),
        };
    }

    public function admin()
    {
        $now = now();
        $dateOnly = $now->format('Y-m-d');
        $timeOnly = $now->format('H:i:s');

        Reservation::where('status', 'pending')
            ->where(function ($query) use ($dateOnly, $timeOnly) {
                $query->whereDate('reservation_date', '<', $dateOnly)
                      ->orWhere(function ($q) use ($dateOnly, $timeOnly) {
                          $q->whereDate('reservation_date', '=', $dateOnly)
                            ->whereTime('end_time', '<', $timeOnly);
                      });
            })
            ->update(['status' => 'no_show']);

        Reservation::where('status', 'confirmed')
            ->where(function ($query) use ($dateOnly, $timeOnly) {
                $query->whereDate('reservation_date', '<', $dateOnly)
                      ->orWhere(function ($q) use ($dateOnly, $timeOnly) {
                          $q->whereDate('reservation_date', '=', $dateOnly)
                            ->whereTime('end_time', '<', $timeOnly);
                      });
            })
            ->update(['status' => 'completed']);

        /*
    |--------------------------------------------------------------------------
    | Ringkasan Operasional
    |--------------------------------------------------------------------------
    */

        $totalMenus = Menu::count();

        $activeMenus = Menu::where('is_available', true)->count();

        $totalTables = Table::count();

        $availableTables = Table::where('status', 'available')->count();

        $totalReservations = Reservation::count();

        $todayReservations = Reservation::whereDate('reservation_date', now()->toDateString())
            ->count();

        $pendingReservations = Reservation::where('status', 'pending')
            ->count();

        $totalOrders = Order::count();

        $todayOrders = Order::whereDate('created_at', now()->toDateString())
            ->count();

        $totalMembers = Customer::where('is_member', true)->count();

        /*
    |--------------------------------------------------------------------------
    | Ringkasan Keuangan
    |--------------------------------------------------------------------------
    */

        $totalIncome = FinancialTransaction::where('type', 'income')->sum('amount');

        $totalExpense = FinancialTransaction::where('type', 'expense')->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $todayIncome = FinancialTransaction::where('type', 'income')
            ->whereDate('transaction_date', now()->toDateString())
            ->sum('amount');

        $todayExpense = FinancialTransaction::where('type', 'expense')
            ->whereDate('transaction_date', now()->toDateString())
            ->sum('amount');

        /*
    |--------------------------------------------------------------------------
    | Ringkasan Internal
    |--------------------------------------------------------------------------
    */

        $totalEmployees = Employee::count();

        $activeEmployees = Employee::where('employment_status', 'active')->count();

        $totalStaffAccounts = User::whereIn('role', [
            'resepsionis',
            'kasir',
            'keuangan',
            'dapur',
            'sdm',
        ])->count();

        $lowStockIngredients = Ingredient::whereColumn('current_stock', '<=', 'minimum_stock')
            ->where('current_stock', '>', 0)
            ->count();

        $emptyStockIngredients = Ingredient::where('current_stock', '<=', 0)
            ->count();

        $unpaidSalaries = SalaryPayment::where('salary_month', now()->month)
            ->where('salary_year', now()->year)
            ->where('status', 'unpaid')
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Transaksi Terbaru
    |--------------------------------------------------------------------------
    */

        $latestTransactions = FinancialTransaction::with('creator')
            ->latest('transaction_date')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboards.admin', compact(
            'totalMenus',
            'activeMenus',
            'totalTables',
            'availableTables',
            'totalReservations',
            'todayReservations',
            'pendingReservations',
            'totalOrders',
            'todayOrders',
            'totalMembers',
            'totalIncome',
            'totalExpense',
            'balance',
            'todayIncome',
            'todayExpense',
            'totalEmployees',
            'activeEmployees',
            'totalStaffAccounts',
            'lowStockIngredients',
            'emptyStockIngredients',
            'unpaidSalaries',
            'latestTransactions'
        ));
    }
    public function member()
    {
        $menus = Menu::where('is_available', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $customer = Customer::where('user_id', auth()->id())->first();

        return view('dashboards.member', compact('menus', 'customer'));
    }
    public function resepsionis()
    {
        $now = now();
        $dateOnly = $now->format('Y-m-d');
        $timeOnly = $now->format('H:i:s');

        Reservation::where('status', 'pending')
            ->where(function ($query) use ($dateOnly, $timeOnly) {
                $query->whereDate('reservation_date', '<', $dateOnly)
                      ->orWhere(function ($q) use ($dateOnly, $timeOnly) {
                          $q->whereDate('reservation_date', '=', $dateOnly)
                            ->whereTime('end_time', '<', $timeOnly);
                      });
            })
            ->update(['status' => 'no_show']);

        Reservation::where('status', 'confirmed')
            ->where(function ($query) use ($dateOnly, $timeOnly) {
                $query->whereDate('reservation_date', '<', $dateOnly)
                      ->orWhere(function ($q) use ($dateOnly, $timeOnly) {
                          $q->whereDate('reservation_date', '=', $dateOnly)
                            ->whereTime('end_time', '<', $timeOnly);
                      });
            })
            ->update(['status' => 'completed']);

        $totalReservations = Reservation::count();

        $pendingReservations = Reservation::where('status', 'pending')
            ->count();

        $confirmedReservations = Reservation::where('status', 'confirmed')
            ->count();

        $availableTables = Table::where('status', 'available')
            ->count();

        return view('dashboards.resepsionis', compact(
            'totalReservations',
            'pendingReservations',
            'confirmedReservations',
            'availableTables'
        ));
    }

    public function kasir()
    {
        /*
        |--------------------------------------------------------------------------
        | Data Menu untuk POS Kasir
        |--------------------------------------------------------------------------
        | Semua menu yang aktif tetap ditampilkan, termasuk stok 0.
        | Stok 0 nanti diberi keterangan "stok habis" di view.
        */

        $menus = Menu::with('menuIngredients.ingredient')
            ->where('is_available', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $members = Customer::where('is_member', true)
            ->orderBy('name')
            ->get();

        $todayOrders = Order::whereDate('created_at', now()->toDateString())
            ->count();

        $todayIncome = Order::whereDate('created_at', now()->toDateString())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('dashboards.kasir', compact(
            'menus',
            'members',
            'todayOrders',
            'todayIncome'
        ));
    }

    public function keuangan()
    {
        $totalIncome = FinancialTransaction::where('type', 'income')->sum('amount');

        $totalExpense = FinancialTransaction::where('type', 'expense')->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $todayIncome = FinancialTransaction::where('type', 'income')
            ->whereDate('transaction_date', now()->toDateString())
            ->sum('amount');

        $todayExpense = FinancialTransaction::where('type', 'expense')
            ->whereDate('transaction_date', now()->toDateString())
            ->sum('amount');

        $salesIncome = FinancialTransaction::where('category', 'sales')->sum('amount');

        $stockExpense = FinancialTransaction::where('category', 'stock_purchase')->sum('amount');

        $salaryExpense = FinancialTransaction::where('category', 'salary')->sum('amount');

        $latestTransactions = FinancialTransaction::with('creator')
            ->latest('transaction_date')
            ->latest()
            ->limit(5)
            ->get();

        $pendingStockTransactions = StockTransaction::with(['ingredient', 'creator'])
            ->where('status', 'pengajuan')
            ->get();

        return view('dashboards.keuangan', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'todayIncome',
            'todayExpense',
            'salesIncome',
            'stockExpense',
            'salaryExpense',
            'latestTransactions',
            'pendingStockTransactions'
        ));
    }

    public function dapur()
    {
        $totalIngredients = Ingredient::count();

        $lowStockIngredients = Ingredient::whereColumn('current_stock', '<=', 'minimum_stock')
            ->where('current_stock', '>', 0)
            ->count();

        $emptyStockIngredients = Ingredient::where('current_stock', '<=', 0)->count();

        $stockIn = StockTransaction::where('type', 'in')->count();

        $stockOut = StockTransaction::where('type', 'out')->count();

        $monthlyPurchaseCost = StockTransaction::where('type', 'in')
            ->where('status', 'cair')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('total_price');

        return view('dashboards.dapur', compact(
            'totalIngredients',
            'lowStockIngredients',
            'emptyStockIngredients',
            'stockIn',
            'stockOut',
            'monthlyPurchaseCost'
        ));
    }

    public function sdm()
    {
        $totalEmployees = Employee::count();

        $activeEmployees = Employee::where('employment_status', 'active')->count();

        $totalStaffAccounts = User::whereIn('role', [
            'resepsionis',
            'kasir',
            'keuangan',
            'dapur',
            'sdm',
        ])->count();

        $unpaidSalaries = SalaryPayment::where('salary_month', now()->month)
            ->where('salary_year', now()->year)
            ->where('status', 'unpaid')
            ->count();

        return view('dashboards.sdm', compact(
            'totalEmployees',
            'activeEmployees',
            'totalStaffAccounts',
            'unpaidSalaries'
        ));
    }
}