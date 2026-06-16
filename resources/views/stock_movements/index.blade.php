<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Mutasi Stok
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Riwayat barang masuk, barang keluar, penjualan, dan penyesuaian stok.
                </p>
            </div>

            @if(auth()->user()->role === 'warehouse')
                <a href="{{ route('stock-movements.create') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl text-sm font-semibold shadow">
                    + Input Mutasi Stok
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            {{-- KARTU STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Mutasi</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $movements->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Semua aktivitas stok
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Barang Masuk</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">
                        {{ $movements->where('type', 'in')->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Penambahan stok
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Barang Keluar</p>
                    <h3 class="text-3xl font-bold text-red-600 mt-2">
                        {{ $movements->where('type', 'out')->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Pengurangan manual
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Penjualan</p>
                    <h3 class="text-3xl font-bold text-indigo-700 mt-2">
                        {{ $movements->where('type', 'sale')->count() }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Keluar dari transaksi
                    </p>
                </div>
            </div>

            {{-- TABEL MUTASI --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            Riwayat Pergerakan Stok
                        </h3>
                        <p class="text-sm text-gray-500">
                            Setiap perubahan stok akan tercatat untuk mencegah manipulasi data.
                        </p>
                    </div>

                    <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-sm font-bold">
                        {{ $movements->count() }} Data
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-left">Cabang</th>
                                <th class="px-5 py-4 text-left">Produk</th>
                                <th class="px-5 py-4 text-center">Jenis</th>
                                <th class="px-5 py-4 text-center">Jumlah</th>
                                <th class="px-5 py-4 text-left">Petugas</th>
                                <th class="px-5 py-4 text-left">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($movements as $movement)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 py-4 text-gray-700">
                                        {{ $movement->movement_date }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $movement->branch->branch_name ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Cabang toko
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $movement->product->product_name ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Produk barang
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        @if($movement->type === 'in')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                Masuk
                                            </span>
                                        @elseif($movement->type === 'out')
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                Keluar
                                            </span>
                                        @elseif($movement->type === 'sale')
                                            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">
                                                Penjualan
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                                Penyesuaian
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        <span class="font-bold text-gray-900">
                                            {{ $movement->quantity }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($movement->user->name ?? 'U', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $movement->user->name ?? '-' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Petugas input
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $movement->description ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-14 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center text-2xl font-bold mb-3">
                                                !
                                            </div>

                                            <h3 class="font-bold text-gray-800">
                                                Belum ada mutasi stok
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Data barang masuk, keluar, dan penjualan akan tampil di sini.
                                            </p>

                                            @if(auth()->user()->role === 'warehouse')
                                                <a href="{{ route('stock-movements.create') }}"
                                                   class="mt-4 px-5 py-2.5 bg-indigo-700 text-white rounded-xl text-sm font-semibold">
                                                    Input Mutasi Stok
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>