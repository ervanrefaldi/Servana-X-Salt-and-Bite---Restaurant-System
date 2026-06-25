<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Akun Staff
            </h2>

            <a href="{{ route('staff-accounts.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Kelola Akun Staff
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($employees->isEmpty())
                    <div class="mb-4 p-4 bg-yellow-100 text-yellow-700 rounded">
                        Tidak ada karyawan yang bisa dibuatkan akun staff.
                        Pastikan karyawan aktif, memiliki email, dan belum memiliki akun staff.
                    </div>
                @endif

                <form action="{{ route('staff-accounts.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Pilih Email Karyawan
                        </label>

                        <select name="employee_email"
                                id="employee_email"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">-- Pilih Email Karyawan --</option>

                            @foreach ($employees as $employee)
                                <option value="{{ $employee->email }}"
                                        data-name="{{ $employee->name }}"
                                        data-email="{{ $employee->email }}"
                                        data-phone="{{ $employee->phone }}"
                                        data-position="{{ $employee->position }}"
                                        {{ old('employee_email') == $employee->email ? 'selected' : '' }}>
                                    {{ $employee->email }} - {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>

                        <p class="text-sm text-gray-500 mt-1">
                            Email diambil dari data karyawan yang sudah terdaftar.
                        </p>
                    </div>

                    <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded">
                        <p class="font-semibold mb-2">
                            Preview Data Karyawan
                        </p>

                        <div class="text-sm space-y-1">
                            <p>Nama: <span id="preview_name">-</span></p>
                            <p>Email: <span id="preview_email">-</span></p>
                            <p>No HP: <span id="preview_phone">-</span></p>
                            <p>Posisi: <span id="preview_position">-</span></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Role Akses Website
                        </label>

                        <select name="role"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">-- Pilih Role --</option>
                            <option value="resepsionis" {{ old('role') == 'resepsionis' ? 'selected' : '' }}>
                                Resepsionis
                            </option>
                            <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>
                                Kasir
                            </option>
                            <option value="keuangan" {{ old('role') == 'keuangan' ? 'selected' : '' }}>
                                Keuangan
                            </option>
                            <option value="dapur" {{ old('role') == 'dapur' ? 'selected' : '' }}>
                                Dapur
                            </option>
                            <option value="sdm" {{ old('role') == 'sdm' ? 'selected' : '' }}>
                                SDM
                            </option>
                        </select>

                        <p class="text-sm text-gray-500 mt-1">
                            Role menentukan dashboard yang akan dibuka setelah staff login.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Status Akun
                        </label>

                        <select name="is_active"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Konfirmasi Password
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('staff-accounts.index') }}"
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Kembali
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;"
                                {{ $employees->isEmpty() ? 'disabled' : '' }}>
                            Simpan Akun Staff
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function updateEmployeePreview() {
            const select = document.getElementById('employee_email');
            const selected = select.options[select.selectedIndex];

            document.getElementById('preview_name').textContent = selected.dataset.name || '-';
            document.getElementById('preview_email').textContent = selected.dataset.email || '-';
            document.getElementById('preview_phone').textContent = selected.dataset.phone || '-';
            document.getElementById('preview_position').textContent = selected.dataset.position || '-';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('employee_email');

            select.addEventListener('change', updateEmployeePreview);

            updateEmployeePreview();
        });
    </script>
</x-app-layout>