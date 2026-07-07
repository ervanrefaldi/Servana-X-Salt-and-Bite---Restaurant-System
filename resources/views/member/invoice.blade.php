<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice - Servana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased selection:bg-[#991B1B] selection:text-white">

    @include('partials.public-navbar')

    <main class="py-12">
        <div class="max-w-3xl mx-auto px-6">

            <div class="mb-6 flex justify-between items-center no-print">
                <a href="{{ route('member.profile') }}" class="text-sm font-semibold text-gray-500 hover:text-[#991B1B] flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Profile
                </a>
                
                <button onclick="window.print()" class="px-5 py-2.5 bg-[#991B1B] text-white text-sm font-bold rounded-xl hover:bg-[#8B121A] transition-all shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Invoice
                </button>
            </div>

            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 print:shadow-none print:border-none print:p-0 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#991B1B] print:hidden"></div>

                {{-- Header --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-100 pb-8 mb-8 gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-[#FDEAE8] text-[#991B1B] rounded-xl flex items-center justify-center print:border print:border-[#991B1B]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">Servana</h3>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Premium Dining Experience</p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Invoice Number</p>
                        <p class="text-xl font-bold font-mono text-[#991B1B]">{{ $order->order_code }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                {{-- Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-2">Billed To</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $order->customer_name }}</p>
                        @if(isset($order->customer->member_code))
                            <p class="text-sm text-gray-500 font-mono mt-1">Member ID: {{ $order->customer->member_code }}</p>
                        @endif
                    </div>
                    
                    <div class="md:text-right">
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-2">Payment Details</p>
                        <div class="inline-block text-left">
                            <p class="text-sm text-gray-700 mb-1"><span class="font-medium text-gray-500 w-20 inline-block">Method:</span> {{ strtoupper($order->payment_method) }}</p>
                            <p class="text-sm text-gray-700"><span class="font-medium text-gray-500 w-20 inline-block">Status:</span> 
                                <span class="font-bold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="mb-8 rounded-xl overflow-hidden border border-gray-100 print:border-none">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 print:bg-transparent text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-4 font-semibold">Item</th>
                                <th class="p-4 font-semibold text-center">Qty</th>
                                <th class="p-4 font-semibold text-right">Price</th>
                                <th class="p-4 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($order->details as $detail)
                                <tr>
                                    <td class="p-4 text-gray-900 font-medium">
                                        {{ $detail->menu->name ?? 'Deleted Item' }}
                                    </td>
                                    <td class="p-4 text-gray-700 text-center">
                                        {{ $detail->quantity }}
                                    </td>
                                    <td class="p-4 text-gray-700 text-right">
                                        Rp{{ number_format($detail->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-gray-900 font-bold text-right">
                                        Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Total --}}
                <div class="flex justify-end">
                    <div class="w-full md:w-1/2 space-y-3">
                        <div class="flex justify-between items-center text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between items-center text-green-600 text-sm">
                            <span>Discount (Member 5%)</span>
                            <span class="font-medium">- Rp{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <span class="text-gray-900 font-bold uppercase tracking-wider text-sm">Total Amount</span>
                            <span class="text-2xl font-black text-[#991B1B]">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 pt-8 border-t border-gray-100 text-center text-sm text-gray-500 print:mb-0">
                    <p class="font-semibold text-gray-900 mb-1">Thank you for dining with Servana!</p>
                    <p>If you have any questions concerning this invoice, please contact our support.</p>
                </div>
            </div>

        </div>
    </main>

    <style>
        @media print {
            body { background: white; }
            nav, .no-print { display: none !important; }
            main { padding: 0 !important; }
        }
    </style>
</body>
</html>