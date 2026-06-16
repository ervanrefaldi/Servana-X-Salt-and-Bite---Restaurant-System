<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Akun Staff
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

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nama Staff</p>
                    <p class="text-lg font-semibold">{{ $staffAccount->name }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="text-lg font-semibold">{{ $staffAccount->email }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nomor HP</p>
                    <p class="text-lg font-semibold">{{ $staffAccount->phone ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Role</p>
                    <p class="text-lg font-semibold">{{ ucfirst($staffAccount->role) }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Status Akun</p>
                    <p class="text-lg font-semibold">
                        {{ $staffAccount->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </p>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('staff-accounts.index') }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #4b5563; color: #ffffff;">
                        Back
                    </a>

                    <a href="{{ route('staff-accounts.edit', $staffAccount) }}"
                       class="inline-block px-4 py-2 rounded-md text-sm font-semibold shadow"
                       style="background-color: #f59e0b; color: #ffffff;">
                        Edit Akun
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>