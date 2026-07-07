@extends('layouts.pos')

@section('title', 'Dashboard Keuangan - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Finance Dashboard</h2>
            <p class="text-gray-500 text-sm">Monitor revenue, expenses, and manage stock purchase approvals.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('financial-transactions.create') }}" class="px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium shadow-sm hover:bg-[#8B121A] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                New Manual Transaction
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Financial Overview -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Financial Overview (All Time)</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Income</p>
                    <h3 class="text-xl font-bold text-gray-900">Rp{{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-[#FDEAE8] text-brand-red flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Expense</p>
                    <h3 class="text-xl font-bold text-gray-900">Rp{{ number_format($totalExpense ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-brand-red rounded-2xl p-6 shadow-sm border border-transparent flex items-center gap-4 text-white">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-white/80 font-medium">Net Balance</p>
                    <h3 class="text-xl font-bold">Rp{{ number_format($balance ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Today & Categories -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Today's Flow</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Income Today</span>
                        </div>
                        <span class="font-bold text-green-600">Rp{{ number_format($todayIncome ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#FDEAE8] text-brand-red flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </div>
                            <span class="font-medium text-gray-700">Expense Today</span>
                        </div>
                        <span class="font-bold text-brand-red">Rp{{ number_format($todayExpense ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Expense Categories</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Sales Income (Kasir)</span>
                        <span class="font-bold text-green-600">Rp{{ number_format($salesIncome ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5"><div class="bg-green-500 h-1.5 rounded-full" style="width: 75%"></div></div>
                    
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-gray-500">Stock Purchase (Dapur)</span>
                        <span class="font-bold text-brand-red">Rp{{ number_format($stockExpense ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5"><div class="bg-brand-red h-1.5 rounded-full" style="width: 45%"></div></div>
                    
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-gray-500">Salary Expense (SDM)</span>
                        <span class="font-bold text-brand-red">Rp{{ number_format($salaryExpense ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5"><div class="bg-brand-red h-1.5 rounded-full" style="width: 30%"></div></div>
                </div>
            </div>
        </div>

        <!-- Pending Stock Approvals -->
        <h3 class="text-lg font-bold text-gray-900 mb-4">Pending Purchase Approvals</h3>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="bg-gray-50 text-gray-700 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Item</th>
                            <th class="px-6 py-4">Supplier</th>
                            <th class="px-6 py-4">Quantity</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pendingStockTransactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $transaction->ingredient->name ?? $transaction->ingredient_name }}</td>
                                <td class="px-6 py-4">{{ $transaction->supplier_name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ number_format($transaction->quantity, 2, ',', '.') }} {{ $transaction->unit }}</td>
                                <td class="px-6 py-4 font-bold text-brand-red">Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('stock-transactions.updateStatus', $transaction) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cair">
                                            <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" onclick="return confirm('Cairkan dana dan setujui pembelian ini?')">Approve</button>
                                        </form>
                                        <form action="{{ route('stock-transactions.updateStatus', $transaction) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="bg-[#FDEAE8] hover:bg-[#FADBD8] text-brand-red px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" onclick="return confirm('Tolak pembelian ini?')">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                    No pending purchase approvals.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Transactions -->
        <div class="flex justify-between items-end mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
            <a href="{{ route('financial-transactions.index') }}" class="text-sm font-semibold text-brand-red hover:underline">View All</a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="bg-gray-50 text-gray-700 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($latestTransactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $transaction->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-brand-red' }}">
                                        {{ $transaction->type === 'income' ? 'Income' : 'Expense' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $transaction->category)) }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    No financial transactions yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection