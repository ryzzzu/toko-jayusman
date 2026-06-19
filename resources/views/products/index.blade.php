<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Data Produk</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola produk, harga beli, harga jual, dan satuan barang.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl text-sm font-semibold shadow">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $products->count() }}</h3>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Pengelolaan Harga</p>
                    <h3 class="text-3xl font-bold text-indigo-700 mt-2">Aktif</h3>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Data Produk</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">Terpusat</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Produk</h3>
                    <p class="text-sm text-gray-500">Produk yang digunakan dalam transaksi penjualan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">Produk</th>
                                <th class="px-5 py-4 text-left">Kategori</th>
                                <th class="px-5 py-4 text-left">Barcode</th>
                                <th class="px-5 py-4 text-right">Harga Beli</th>
                                <th class="px-5 py-4 text-right">Harga Jual</th>
                                <th class="px-5 py-4 text-center">Satuan</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($product->product_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $product->product_name }}</p>
                                                <p class="text-xs text-gray-500">Data master produk</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold">
                                            {{ $product->category->category_name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">{{ $product->barcode ?? '-' }}</td>

                                    <td class="px-5 py-4 text-right">
                                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-center">{{ $product->unit }}</td>

                                    <td class="px-5 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                               class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                        Belum ada produk.
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