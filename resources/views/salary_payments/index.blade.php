<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($canManage ?? false) ? 'Kelola Gaji Karyawan' : 'Lihat Gaji Karyawan' }}
        </h2>
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

            {{-- Filter Periode --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">
                    Filter Periode Gaji
                </h3>

                <form method="GET" action="{{ route('salary-payments.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Bulan Tutup Buku
                        </label>

                        <select name="month" class="w-full border-gray-300 rounded-md shadow-sm">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ (int) $month === $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tahun
                        </label>

                        <input type="number"
                               name="year"
                               value="{{ $year }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               min="2020"
                               max="2100">
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-md text-sm font-semibold"
                                style="background-color: #2563eb; color: #ffffff;">
                            Tampilkan
                        </button>
                    </div>

                    @if ($canManage ?? false)
                        <div class="flex items-end">
                            <a href="{{ route('employees.index') }}"
                               class="w-full text-center px-4 py-2 rounded-md text-sm font-semibold"
                               style="background-color: #4b5563; color: #ffffff;">
                                Kelola Karyawan
                            </a>
                        </div>
                    @endif
                </form>

                <div class="mt-4 p-4 bg-blue-50 text-blue-700 rounded">
                    <p class="text-sm">
                        <strong>Periode gaji:</strong>
                        {{ $periodStart->format('d-m-Y') }}
                        sampai
                        {{ $periodEnd->format('d-m-Y') }}.
                        Tutup buku dilakukan setiap tanggal 25.
                    </p>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Total Payroll</p>
                    <h3 class="text-2xl font-bold">
                        Rp{{ number_format($totalPayroll ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Sudah Dibayar</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        Rp{{ number_format($paidPayroll ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <p class="text-sm text-gray-500">Belum Dibayar</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        Rp{{ number_format($unpaidPayroll ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            {{-- Aturan --}}
            <div class="bg-white p-4 shadow-sm sm:rounded-lg mb-6">
                <p class="text-sm text-gray-700">
                    <strong>Aturan:</strong>
                    Periode gaji dibuka tanggal 26 bulan sebelumnya dan ditutup tanggal 25 bulan berjalan.
                    Gaji dihitung berdasarkan jumlah hari kerja dalam periode tersebut.
                    Jika karyawan masuk di tengah periode, gaji dihitung dari tanggal masuk sampai tutup buku.
                    Potongan per hari = gaji pokok / 30.
                    Bonus 10% diberikan hanya jika karyawan bekerja dari awal buka buku dan tidak memiliki hari tidak masuk.
                </p>
            </div>

            {{-- Tabel Gaji --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-4 border">Karyawan</th>
                            <th class="p-4 border">Tanggal Masuk</th>
                            <th class="p-4 border">Periode</th>
                            <th class="p-4 border">Gaji Pokok</th>
                            <th class="p-4 border">Gaji Harian</th>
                            <th class="p-4 border">Hari Digaji</th>
                            <th class="p-4 border">Gaji Periode</th>
                            <th class="p-4 border">Tidak Masuk</th>
                            <th class="p-4 border">Status Bonus</th>
                            <th class="p-4 border">Bonus</th>
                            <th class="p-4 border">Potongan</th>
                            <th class="p-4 border">Total Gaji</th>
                            <th class="p-4 border">Status Bayar</th>
                            @if ($canManage ?? false)
                                <th class="p-4 border">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($salaryPayments as $salaryPayment)
                            <tr>
                                <td class="p-4 border">
                                    <div class="font-semibold">
                                        {{ $salaryPayment->employee->name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $salaryPayment->employee->position ?? '-' }}
                                    </div>
                                </td>

                                <td class="p-4 border">
                                    {{ optional($salaryPayment->employee->hire_date)->format('d-m-Y') ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    {{ optional($salaryPayment->period_start)->format('d-m-Y') ?? '-' }}
                                    <br>
                                    s/d
                                    <br>
                                    {{ optional($salaryPayment->period_end)->format('d-m-Y') ?? '-' }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($salaryPayment->basic_salary ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($salaryPayment->daily_salary ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    {{ $salaryPayment->payable_days ?? 0 }} hari
                                </td>

                                <td class="p-4 border">
                                    Rp{{ number_format($salaryPayment->base_salary_for_period ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    @if (($canManage ?? false) && $salaryPayment->status === 'unpaid')
                                        <form action="{{ route('salary-payments.attendance', $salaryPayment) }}"
                                              method="POST"
                                              class="flex gap-2 items-center">
                                            @csrf
                                            @method('PATCH')

                                            <input type="number"
                                                   name="absent_days"
                                                   value="{{ $salaryPayment->absent_days ?? 0 }}"
                                                   min="0"
                                                   max="30"
                                                   class="w-20 border-gray-300 rounded-md shadow-sm">

                                            <button type="submit"
                                                    class="px-3 py-1 rounded text-xs font-semibold"
                                                    style="background-color: #2563eb; color: #ffffff;">
                                                Update
                                            </button>
                                        </form>
                                    @else
                                        {{ $salaryPayment->absent_days ?? 0 }} hari
                                    @endif
                                </td>

                                <td class="p-4 border">
                                    @if ($salaryPayment->bonus_status === 'eligible')
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                            Dapat Bonus
                                        </span>
                                    @elseif ($salaryPayment->bonus_status === 'not_eligible_hire_date')
                                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                            Masuk Tengah Periode
                                        </span>
                                    @elseif ($salaryPayment->bonus_status === 'not_eligible_absent')
                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                            Ada Tidak Masuk
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                            -
                                        </span>
                                    @endif

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $salaryPayment->bonus_note ?? '-' }}
                                    </div>
                                </td>

                                <td class="p-4 border text-green-600">
                                    Rp{{ number_format($salaryPayment->bonus ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border text-red-600">
                                    Rp{{ number_format($salaryPayment->deduction ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border font-semibold">
                                    Rp{{ number_format($salaryPayment->amount ?? 0, 0, ',', '.') }}
                                </td>

                                <td class="p-4 border">
                                    @if ($salaryPayment->status === 'paid')
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                            Sudah Dibayar
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ optional($salaryPayment->payment_date)->format('d-m-Y') }}
                                        </div>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>

                                @if ($canManage ?? false)
                                    <td class="p-4 border">
                                        <div class="flex flex-wrap gap-2">
                                            @if ($salaryPayment->status === 'unpaid')
                                                <form action="{{ route('salary-payments.paid', $salaryPayment) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Tandai gaji ini sudah dibayar?')">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                            class="px-3 py-1 rounded text-xs font-semibold"
                                                            style="background-color: #16a34a; color: #ffffff;">
                                                        Bayar
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('salary-payments.unpaid', $salaryPayment) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Kembalikan status menjadi belum dibayar?')">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                            class="px-3 py-1 rounded text-xs font-semibold"
                                                            style="background-color: #dc2626; color: #ffffff;">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ ($canManage ?? false) ? 14 : 13 }}" class="p-4 border text-center text-gray-500">
                                    Belum ada data gaji karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>