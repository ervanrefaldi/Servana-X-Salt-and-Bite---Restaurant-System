<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Akun Staff
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

                <div class="mb-6 p-4 bg-blue-50 text-blue-700 rounded">
                    <p class="font-semibold mb-2">
                        Data Karyawan
                    </p>

                    <div class="text-sm space-y-1">
                        <p>
                            Nama:
                            <strong>{{ $staffAccount->employee->name ?? $staffAccount->name }}</strong>
                        </p>

                        <p>
                            Email:
                            <strong>{{ $staffAccount->employee->email ?? $staffAccount->email }}</strong>
                        </p>

                        <p>
                            No HP:
                            <strong>{{ $staffAccount->employee->phone ?? $staffAccount->phone ?? '-' }}</strong>
                        </p>

                        <p>
                            Posisi:
                            <strong>{{ $staffAccount->employee->position ?? '-' }}</strong>
                        </p>
                    </div>

                    <p class="text-xs mt-3">
                        Nama, email, dan nomor HP mengikuti data karyawan.
                        Edit data tersebut melalui menu Kelola Karyawan.
                    </p>
                </div>

                <form action="{{ route('staff-accounts.update', $staffAccount) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Role Akses Website
                        </label>

                        <select name="role"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            @foreach (['resepsionis', 'kasir', 'keuangan', 'dapur', 'sdm'] as $role)
                                <option value="{{ $role }}" {{ old('role', $staffAccount->role) == $role ? 'selected' : '' }}>
                                    {{ $role === 'sdm' ? 'SDM' : ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Status Akun
                        </label>

                        <select name="is_active"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="1" {{ old('is_active', $staffAccount->is_active) == '1' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ old('is_active', $staffAccount->is_active) == '0' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <hr class="my-6">

                    <p class="text-sm text-gray-500 mb-4">
                        Kosongkan password jika tidak ingin mengganti password.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Password Baru
                            </label>

                            <input type="password"
                                   name="password"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">
                                Konfirmasi Password Baru
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   class="w-full border-gray-300 rounded-md shadow-sm">
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
                                style="background-color: #2563eb; color: #ffffff;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>