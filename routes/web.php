<?php

use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\MemberRegisterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\StaffAccountController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Route yang bisa diakses tanpa login.
| Customer biasa bisa melihat menu dan membuat reservasi tanpa login.
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [MenuController::class, 'publicMenu'])
    ->name('public.menu');

Route::get('/daftar-member', [MemberRegisterController::class, 'create'])
    ->name('member.register');

Route::post('/daftar-member', [MemberRegisterController::class, 'store'])
    ->name('member.register.store');

Route::get('/reservasi', [ReservationController::class, 'create'])
    ->name('reservations.create');

Route::post('/reservasi', [ReservationController::class, 'store'])
    ->name('reservations.store');

Route::get('/reservasi/success', [ReservationController::class, 'success'])
    ->name('reservation.success');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
| Route yang hanya bisa diakses setelah login.
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Member Profile
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:member'])->group(function () {
        Route::get('/member/profile', [MemberProfileController::class, 'index'])
            ->name('member.profile');

        Route::patch('/member/profile', [MemberProfileController::class, 'update'])
            ->name('member.profile.update');

        Route::get('/member/invoice/{order}', [MemberProfileController::class, 'invoice'])
            ->name('member.invoice');
    });


    /*
    |--------------------------------------------------------------------------
    | Dashboard Redirect
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'redirect'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Dashboard Per Role
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/member/dashboard', [DashboardController::class, 'member'])
        ->middleware('role:member')
        ->name('member.dashboard');

    Route::get('/resepsionis/dashboard', [DashboardController::class, 'resepsionis'])
        ->middleware('role:resepsionis')
        ->name('resepsionis.dashboard');

    Route::get('/kasir/dashboard', [DashboardController::class, 'kasir'])
        ->middleware('role:kasir')
        ->name('kasir.dashboard');

    Route::get('/keuangan/dashboard', [DashboardController::class, 'keuangan'])
        ->middleware('role:keuangan')
        ->name('keuangan.dashboard');

    Route::get('/dapur/dashboard', [DashboardController::class, 'dapur'])
        ->middleware('role:dapur')
        ->name('dapur.dashboard');

    Route::get('/sdm/dashboard', [DashboardController::class, 'sdm'])
        ->middleware('role:sdm')
        ->name('sdm.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Admin Reports
    |--------------------------------------------------------------------------
    | Admin dapat melihat dan mencetak laporan Excel/PDF.
    | Excel dibuat manual sebagai CSV agar tetap kompatibel dengan PHP 8.5.
    | PDF dibuat menggunakan halaman print browser.
    */

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/reports', [AdminReportController::class, 'index'])
            ->name('admin.reports.index');

        Route::get('/admin/reports/financial', [AdminReportController::class, 'financial'])
            ->name('admin.reports.financial');

        Route::get('/admin/reports/financial/excel', [AdminReportController::class, 'financialExcel'])
            ->name('admin.reports.financial.excel');

        Route::get('/admin/reports/financial/pdf', [AdminReportController::class, 'financialPdf'])
            ->name('admin.reports.financial.pdf');
    });


    /*
    |--------------------------------------------------------------------------
    | Profile Routes Laravel Breeze
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Admin dan Resepsionis
    |--------------------------------------------------------------------------
    | Admin dan resepsionis dapat mengelola meja dan reservasi.
    */

    Route::middleware(['role:admin,resepsionis'])->group(function () {
        Route::resource('tables', TableController::class);

        Route::get('/reservations/manage', [ReservationController::class, 'index'])
            ->name('reservations.index');

        Route::get('/reservations/manage/{reservation}', [ReservationController::class, 'show'])
            ->name('reservations.show');

        Route::patch('/reservations/manage/{reservation}/status', [ReservationController::class, 'updateStatus'])
            ->name('reservations.updateStatus');
    });


    /*
    |--------------------------------------------------------------------------
    | Admin dan Kasir
    |--------------------------------------------------------------------------
    | Admin dan kasir dapat mengelola menu dan transaksi POS.
    */

    Route::middleware(['role:admin,kasir'])->group(function () {
        Route::resource('menus', MenuController::class);

        Route::get('/orders/check-member/{memberCode}', [OrderController::class, 'checkMember'])
            ->name('orders.checkMember');

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/create', [OrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [OrderController::class, 'store'])
            ->name('orders.store');

        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');
    });


    /*
    |--------------------------------------------------------------------------
    | Admin dan Keuangan
    |--------------------------------------------------------------------------
    | Admin dan bagian keuangan dapat melihat pemasukan, pengeluaran, dan saldo.
    */

    Route::middleware(['role:admin,keuangan'])->group(function () {
        Route::get('/financial-transactions', [FinancialTransactionController::class, 'index'])
            ->name('financial-transactions.index');

        Route::get('/financial-transactions/create', [FinancialTransactionController::class, 'create'])
            ->name('financial-transactions.create');

        Route::post('/financial-transactions', [FinancialTransactionController::class, 'store'])
            ->name('financial-transactions.store');

        Route::get('/financial-transactions/{financialTransaction}', [FinancialTransactionController::class, 'show'])
            ->name('financial-transactions.show');
    });


    /*
    |--------------------------------------------------------------------------
    | Admin dan Dapur
    |--------------------------------------------------------------------------
    | Admin dan dapur dapat mengelola stok bahan pokok.
    */

    Route::middleware(['role:admin,dapur'])->group(function () {
        Route::resource('ingredients', IngredientController::class);

        Route::get('/stock-transactions', [StockTransactionController::class, 'index'])
            ->name('stock-transactions.index');

        Route::get('/stock-transactions/create', [StockTransactionController::class, 'create'])
            ->name('stock-transactions.create');

        Route::post('/stock-transactions', [StockTransactionController::class, 'store'])
            ->name('stock-transactions.store');

        Route::get('/stock-transactions/{stockTransaction}', [StockTransactionController::class, 'show'])
            ->name('stock-transactions.show');
    });


    /*
    |--------------------------------------------------------------------------
    | Admin dan SDM
    |--------------------------------------------------------------------------
    | Admin dan SDM dapat mengelola data karyawan, akun staff, dan status gaji.
    */

    Route::middleware(['role:admin,sdm'])->group(function () {
        Route::resource('employees', EmployeeController::class);

        Route::resource('staff-accounts', StaffAccountController::class)
            ->parameters([
                'staff-accounts' => 'staffAccount',
            ]);

        Route::get('/salary-payments', [SalaryPaymentController::class, 'index'])
            ->name('salary-payments.index');

        Route::patch('/salary-payments/{salaryPayment}/paid', [SalaryPaymentController::class, 'markAsPaid'])
            ->name('salary-payments.paid');

        Route::patch('/salary-payments/{salaryPayment}/unpaid', [SalaryPaymentController::class, 'markAsUnpaid'])
            ->name('salary-payments.unpaid');
    });
});


/*
|--------------------------------------------------------------------------
| Auth Routes Laravel Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';