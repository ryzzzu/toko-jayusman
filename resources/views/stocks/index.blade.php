<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Data Stok Barang</h1>
                <p class="text-sm text-slate-500">Monitoring jumlah stok barang di setiap cabang</p>
            </div>
        </div>
    </x-slot>

    @php
        $totalStock = $stocks->sum('quantity');
        $lowStockCount = $stocks->where('quantity', '<=', 10)->count();
        $safeStockCount = $stocks->where('quantity', '>', 10)->count();
    @endphp

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-ui.stat-card label="Total Stok" :value="number_format($totalStock, 0, ',', '.')" />
        <x-ui.stat-card label="Stok Aman" :value="$safeStockCount" />
        <x-ui.stat-card label="Stok Menipis" :value="$lowStockCount" />
    </div>

    <x-ui.card :padding="false">
        <x-slot:header>
            <h3 class="font-semibold text-slate-900 dark:text-white">Daftar Stok Barang</h3>
            <p class="text-sm text-slate-500">Stok ditampilkan berdasarkan cabang dan produk</p>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Cabang</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody data-searchable>
                    @forelse($stocks as $stock)
                        <tr data-row data-search="{{ strtolower($stock->branch->branch_name . ' ' . $stock->product->product_name . ' ' . ($stock->product->category->category_name ?? '')) }}">
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $stock->branch->branch_name }}</td>
                            <td>{{ $stock->product->product_name }}</td>
                            <td><x-ui.badge variant="brand">{{ $stock->product->category->category_name ?? '-' }}</x-ui.badge></td>
                            <td class="text-center font-bold">{{ $stock->quantity }}</td>
                            <td class="text-center">
                                @if($stock->quantity <= 10)
                                    <x-ui.badge variant="failed">Menipis</x-ui.badge>
                                @else
                                    <x-ui.badge variant="active">Aman</x-ui.badge>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <x-ui.table-empty colspan="5" title="Belum ada data stok" description="Stok akan muncul setelah produk dan cabang terdaftar." data-row data-search="" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
