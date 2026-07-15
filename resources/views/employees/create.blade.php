@extends('layouts.pos')

@section('title', 'Tambah Data Karyawan - Servana POS')

@section('content')
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <!-- Page Header -->
    <div class="px-8 pt-8 pb-6 flex justify-between items-end border-b border-gray-100 shrink-0">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Tambah Karyawan</h2>
            <p class="text-gray-500 text-sm">Tambahkan staf baru ke data karyawan.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Directory
            </a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-8 shadow-sm sm:rounded-2xl border border-gray-100">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf

                    <h3 class="text-lg font-semibold mb-4">
                        Data Karyawan
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Karyawan
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Andi Saputra"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: andi@gmail.com">

                        <p class="text-sm text-gray-500 mt-1">
                            Email hanya sebagai data identitas karyawan, bukan akun login sistem.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nomor Telepon
                        </label>

                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: 081234567890">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Posisi
                        </label>

                        <input type="text"
                               name="position"
                               value="{{ old('position') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Waiter, Barista, Cleaning Service"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Gaji Pokok
                        </label>

                        <input type="number"
                               name="basic_salary"
                               value="{{ old('basic_salary', 0) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               min="0"
                               required>

                        <p class="text-sm text-gray-500 mt-1">
                            Bonus dan potongan akan dihitung otomatis pada menu Kelola Gaji.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Status Kerja
                        </label>

                        <select name="employment_status"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="active" {{ old('employment_status') == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive" {{ old('employment_status') == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                            <option value="resigned" {{ old('employment_status') == 'resigned' ? 'selected' : '' }}>
                                Resign
                            </option>
                        </select>
                    </div>

                    <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded">
                        <p class="font-semibold mb-1">
                            Aturan Penggajian
                        </p>
                        <p class="text-sm">
                            Potongan per hari = gaji pokok / 30.
                            Bonus 10% diberikan jika karyawan tidak memiliki absen selama satu periode gaji.
                        </p>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('employees.index') }}"
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Kembali
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;">
                            Simpan Karyawan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
