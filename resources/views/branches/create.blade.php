<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Tambah Cabang
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Tambahkan data cabang baru Toko Jayusman.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">
                        Form Tambah Cabang
                    </h3>
                    <p class="text-sm text-gray-500">
                        Lengkapi data cabang dengan benar.
                    </p>
                </div>

                <form action="{{ route('branches.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Cabang
                        </label>

                        <input type="text"
                               name="branch_name"
                               value="{{ old('branch_name') }}"
                               placeholder="Contoh: Mini Market Cianjur"
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('branch_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kota
                        </label>

                        <input type="text"
                               name="city"
                               value="{{ old('city') }}"
                               placeholder="Contoh: Cianjur"
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('city')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat
                        </label>

                        <textarea name="address"
                                  rows="4"
                                  placeholder="Masukkan alamat lengkap cabang"
                                  class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>

                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('branches.index') }}"
                           class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-semibold">
                            Kembali
                        </a>

                        <button type="submit"
                                class="px-5 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl font-semibold shadow">
                            Simpan Cabang
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>