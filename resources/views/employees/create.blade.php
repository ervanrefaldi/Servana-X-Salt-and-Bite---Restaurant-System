<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Karyawan & Akun Staff
            </h2>

            <a href="{{ route('employees.index') }}"
               class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
               style="background-color: #4b5563; color: #ffffff;">
                Kembali ke Kelola Karyawan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf

                    <h3 class="text-lg font-semibold mb-4">
                        Data Akun Login Staff
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
                            Email Login
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: andi@gmail.com"
                               required>

                        <p class="text-sm text-gray-500 mt-1">
                            Email ini digunakan karyawan untuk login ke sistem.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Role Akses
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
                            Role menentukan dashboard yang bisa diakses setelah login.
                        </p>
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

                    <hr class="my-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Data Karyawan
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nomor HP
                        </label>

                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Opsional">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Alamat
                        </label>

                        <textarea name="address"
                                  rows="3"
                                  class="w-full border-gray-300 rounded-md shadow-sm"
                                  placeholder="Alamat karyawan">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Tanggal Masuk
                        </label>

                        <input type="date"
                               name="hire_date"
                               value="{{ old('hire_date') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Posisi
                        </label>

                        <input type="text"
                               name="position"
                               value="{{ old('position') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Contoh: Kasir, Staff Dapur, Staff Keuangan"
                               required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Gaji Pokok
                            </label>

                            <input type="number"
                                   name="basic_salary"
                                   id="basic_salary"
                                   value="{{ old('basic_salary', 0) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm salary-input"
                                   min="0"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Bonus
                            </label>

                            <input type="number"
                                   name="bonus"
                                   id="bonus"
                                   value="{{ old('bonus', 0) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm salary-input"
                                   min="0">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Potongan
                            </label>

                            <input type="number"
                                   name="deduction"
                                   id="deduction"
                                   value="{{ old('deduction', 0) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm salary-input"
                                   min="0">
                        </div>
                    </div>

                    <div class="mb-4 p-4 bg-blue-50 text-blue-700 rounded">
                        <p class="font-semibold">
                            Total Gaji:
                            <span id="total_salary_preview">Rp0</span>
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

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('employees.index') }}"
                           class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                           style="background-color: #4b5563; color: #ffffff;">
                            Back
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;">
                            Simpan Karyawan & Buat Akun
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function formatRupiah(number) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
        }

        function updateTotalSalary() {
            const basicSalary = parseFloat(document.getElementById('basic_salary').value || 0);
            const bonus = parseFloat(document.getElementById('bonus').value || 0);
            const deduction = parseFloat(document.getElementById('deduction').value || 0);

            const total = basicSalary + bonus - deduction;

            document.getElementById('total_salary_preview').textContent = formatRupiah(total);
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.salary-input').forEach(function (input) {
                input.addEventListener('input', updateTotalSalary);
            });

            updateTotalSalary();
        });
    </script>
</x-app-layout>