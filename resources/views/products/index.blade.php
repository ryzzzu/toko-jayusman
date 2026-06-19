<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">Data Produk</h1>
                <p class="mt-0.5 text-sm text-slate-500">Kelola produk, harga, dan satuan barang</p>
            </div>
            <x-ui.button href="{{ route('products.create') }}" variant="primary">Tambah Produk</x-ui.button>
        </div>
    </x-slot>

    <x-ui.card :padding="false">
        <x-slot:header>
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Daftar Produk</h3>
            <p class="mt-0.5 text-sm text-slate-500">{{ $products->count() }} produk terdaftar</p>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Barcode</th>
                        <th class="text-right">Harga Beli</th>
                        <th class="text-right">Harga Jual</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody data-searchable>
                    @forelse($products as $product)
                        <tr data-row data-search="{{ strtolower($product->product_name . ' ' . ($product->category->category_name ?? '') . ' ' . ($product->barcode ?? '')) }}">
                            <td class="font-medium text-slate-900 dark:text-white">{{ $product->product_name }}</td>
                            <td><x-ui.badge variant="brand">{{ $product->category->category_name ?? '-' }}</x-ui.badge></td>
                            <td>{{ $product->barcode ?? '-' }}</td>
                            <td class="text-right">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                            <td class="text-right font-semibold text-slate-900 dark:text-white">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $product->unit }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <x-ui.button href="{{ route('products.edit', $product->id) }}" variant="secondary">Edit</x-ui.button>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <x-ui.button type="submit" variant="danger" loading-text="Menghapus...">Hapus</x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-ui.table-empty colspan="7" title="Belum ada produk" description="Tambahkan produk pertama untuk mulai transaksi." data-row data-search="" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
