<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Laporan Stok Barang</h1>
                <p class="text-sm text-slate-500">Posisi stok atau mutasi stok per periode</p>
            </div>
            <div class="flex gap-2 no-print">
                <x-ui.button href="{{ route('reports.transactions') }}" variant="secondary">Transaksi</x-ui.button>
                <x-ui.button href="{{ route('reports.stocks') }}" variant="primary">Stok</x-ui.button>
            </div>
        </div>
    </x-slot>

    <x-ui.card class="no-print mb-6">
        <h3 class="mb-4 font-semibold text-slate-900 dark:text-white">Filter Laporan</h3>
        <form method="GET" action="{{ route('reports.stocks') }}" data-loading-search class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5 xl:items-end">
            @if(auth()->user()->role === 'owner')
                <x-ui.select name="branch_id" label="Cabang">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" @selected(request('branch_id') == $branch->id)>{{ $branch->branch_name }}</option>
                    @endforeach
                </x-ui.select>
            @endif
            <x-ui.input type="date" name="start_date" label="Tanggal Awal" value="{{ request('start_date') }}" />
            <x-ui.input type="date" name="end_date" label="Tanggal Akhir" value="{{ request('end_date') }}" />
            <x-ui.button type="submit" variant="primary" loading-text="Memuat...">Filter</x-ui.button>
            <x-ui.button type="button" variant="secondary" data-loading-print onclick="window.print()">Cetak</x-ui.button>
        </form>
        <p class="mt-3 text-xs text-slate-500">Kosongkan tanggal untuk melihat posisi stok saat ini. Isi tanggal awal & akhir untuk laporan mutasi per periode.</p>
    </x-ui.card>

    <x-ui.card :padding="false" class="print-area">
        <x-slot:header>
            @if($reportMode === 'movements')
                <h3 class="font-semibold text-slate-900 dark:text-white">Mutasi Stok Periode {{ request('start_date') }} — {{ request('end_date') }}</h3>
            @else
                <h3 class="font-semibold text-slate-900 dark:text-white">Posisi Stok Saat Ini</h3>
            @endif
        </x-slot:header>

        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            @if($reportMode === 'movements')
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Cabang</th>
                            <th>Produk</th>
                            <th>Jenis</th>
                            <th class="text-center">Jumlah</th>
                            <th>Petugas</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td>{{ $movement->movement_date }}</td>
                                <td>{{ $movement->branch->branch_name }}</td>
                                <td>{{ $movement->product->product_name }}</td>
                                <td>{{ $movement->type }}</td>
                                <td class="text-center font-bold">{{ $movement->quantity }}</td>
                                <td>{{ $movement->user->name ?? '-' }}</td>
                                <td>{{ $movement->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-8 text-center text-slate-500">Tidak ada mutasi pada periode ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th>Kategori</th>
                            <th>Produk</th>
                            <th class="text-center">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks as $stock)
                            <tr>
                                <td>{{ $stock->branch->branch_name }}</td>
                                <td>{{ $stock->product->category->category_name }}</td>
                                <td>{{ $stock->product->product_name }}</td>
                                <td class="text-center font-bold">{{ $stock->quantity }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-8 text-center text-slate-500">Belum ada data stok</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </x-ui.card>
</x-app-layout>
