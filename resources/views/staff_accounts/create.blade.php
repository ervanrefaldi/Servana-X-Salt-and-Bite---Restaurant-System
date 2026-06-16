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

                <form action="{{ route('staff-accounts.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Nama Staff</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="contoh@email.com"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Nomor HP</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               placeholder="Opsional">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Role</label>
                        <select name="role"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="">-- Pilih Role --</option>
                            <option value="resepsionis" {{ old('role') == 'resepsionis' ? 'selected' : '' }}>Resepsionis</option>
                            <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="keuangan" {{ old('role') == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                            <option value="dapur" {{ old('role') == 'dapur' ? 'selected' : '' }}>Dapur</option>
                            <option value="sdm" {{ old('role') == 'sdm' ? 'selected' : '' }}>SDM</option>
                        </select>

                        <p class="text-sm text-gray-500 mt-1">
                            SDM hanya membuat akun staff internal, bukan admin dan bukan member.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">Status Akun</label>
                        <select name="is_active"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 font-medium">Password</label>
                            <input type="password"
                                   name="password"
                                   class="w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-2 font-medium">Konfirmasi Password</label>
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
                            Back
                        </a>

                        <button type="submit"
                                class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                                style="background-color: #2563eb; color: #ffffff;">
                            Simpan Akun
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>