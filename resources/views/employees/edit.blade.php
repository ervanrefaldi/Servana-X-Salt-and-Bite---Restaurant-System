<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Data Karyawan
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

                <form action="{{ route('employees.update', $employee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h3 class="text-lg font-semibold mb-4">
                        Data Karyawan
                    </h3>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama Karyawan
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $employee->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email', $employee->email) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">

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
                               value="{{ old('phone', $employee->phone) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Posisi
                        </label>

                        <input type="text"
                               name="position"
                               value="{{ old('position', $employee->position) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Gaji Pokok
                        </label>

                        <input type="number"
                               name="basic_salary"
                               value="{{ old('basic_salary', $employee->basic_salary) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               min="0"
                               required>

                        <p class="text-sm text-gray-500 mt-1">
                            Perubahan gaji pokok akan dipakai pada periode gaji berikutnya atau saat data gaji belum dibayar diperbarui.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Status Kerja
                        </label>

                        <select name="employment_status"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="active" {{ old('employment_status', $employee->employment_status) == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive" {{ old('employment_status', $employee->employment_status) == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                            <option value="resigned" {{ old('employment_status', $employee->employment_status) == 'resigned' ? 'selected' : '' }}>
                                Resign
                            </option>
                        </select>
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
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>