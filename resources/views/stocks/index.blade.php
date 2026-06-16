<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Data Stok Barang</h2>
            <p class="text-sm text-gray-500 mt-1">
                Monitoring jumlah stok barang di setiap cabang toko.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $totalStock = $stocks->sum('quantity');
                $lowStockCount = $stocks->where('quantity', '<=', 10)->count();
                $safeStockCount = $stocks->where('quantity', '>', 10)->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Stok</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStock }}</h3>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Stok Aman</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $safeStockCount }}</h3>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Stok Menipis</p>
                    <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $lowStockCount }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Stok Barang</h3>
                    <p class="text-sm text-gray-500">Stok ditampilkan berdasarkan cabang dan produk.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">Cabang</th>
                                <th class="px-5 py-4 text-left">Produk</th>
                                <th class="px-5 py-4 text-left">Kategori</th>
                                <th class="px-5 py-4 text-center">Jumlah Stok</th>
                                <th class="px-5 py-4 text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($stocks as $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-semibold text-gray-900">
                                        {{ $stock->branch->branch_name }}
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $stock->product->product_name }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold">
                                            {{ $stock->product->category->category_name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-center font-bold text-gray-900">
                                        {{ $stock->quantity }}
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        @if($stock->quantity <= 10)
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                Menipis
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                Aman
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                        Belum ada data stok.
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