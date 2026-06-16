<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Gaji Bulanan
            </h2>

            <a href="{{ route('sdm.dashboard') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #2563eb; color: #ffffff;">
                Kembali ke Dashboard SDM
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="GET" action="{{ route('salary-payments.index') }}" class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label class="block mb-2 font-medium">Bulan</label>
                        <select name="month" class="w-full border-gray-300 rounded-md shadow-sm">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ (int) $month === $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Tahun</label>
                        <input type="number"
                               name="year"
                               value="{{ $year }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow w-full"
                                style="background-color: #2563eb; color: #ffffff;">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Payroll</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($totalPayroll, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Sudah Dibayar</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($paidPayroll, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Belum Dibayar</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        Rp{{ number_format($unpaidPayroll, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">No</th>
                            <th class="p-4 border">Karyawan</th>
                            <th class="p-4 border">Posisi</th>
                            <th class="p-4 border">Periode</th>
                            <th class="p-4 border">Nominal Gaji</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border">Tanggal Bayar</th>
                            <th class="p-4 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($salaryPayments as $index => $payment)
                            <tr>
                                <td class="p-4 border">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 border font-semibold">
                                    {{ $payment->employee->name ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $payment->employee->position ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ $payment->salary_month }}-{{ $payment->salary_year }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($payment->amount, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    @if ($payment->status === 'paid')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Sudah Dibayar
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    {{ $payment->payment_date ? $payment->payment_date->format('d-m-Y') : '-' }}
                                </td>

                                <td class="p-4 border">
                                    @if ($payment->status === 'unpaid')
                                        <form action="{{ route('salary-payments.paid', $payment) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin gaji ini sudah dibayar?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="inline-block px-3 py-2 rounded-md text-sm font-semibold shadow"
                                                    style="background-color: #16a34a; color: #ffffff;">
                                                Tandai Dibayar
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('salary-payments.unpaid', $payment) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin mengubah status menjadi belum dibayar?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="inline-block px-3 py-2 rounded-md text-sm font-semibold shadow"
                                                    style="background-color: #dc2626; color: #ffffff;">
                                                Batalkan Status
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-4 border text-center text-gray-500">
                                    Belum ada data gaji untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>