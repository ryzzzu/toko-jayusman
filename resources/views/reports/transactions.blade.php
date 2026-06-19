<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">Laporan Transaksi</h1>
                <p class="mt-0.5 text-sm text-slate-500">Filter dan cetak laporan penjualan</p>
            </div>
            <div class="flex gap-2 no-print">
                <x-ui.button href="{{ route('reports.transactions') }}" variant="primary">Transaksi</x-ui.button>
                <x-ui.button href="{{ route('reports.stocks') }}" variant="secondary">Stok</x-ui.button>
            </div>
        </div>
    </x-slot>

    @php
        $grandTotal = $transactions->sum('total_price');
        $totalTransaksi = $transactions->count();
        $rataRata = $totalTransaksi > 0 ? $grandTotal / $totalTransaksi : 0;
    @endphp

    <div class="no-print mb-5 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-ui.stat-card label="Total Transaksi" :value="$totalTransaksi" trend="Sesuai filter" />
        <x-ui.stat-card label="Total Pendapatan" :value="'Rp ' . number_format($grandTotal, 0, ',', '.')" />
        <x-ui.stat-card label="Rata-rata Transaksi" :value="'Rp ' . number_format($rataRata, 0, ',', '.')" />
    </div>

    <x-ui.card class="no-print mb-6">
        <h3 class="mb-4 font-semibold text-slate-900 dark:text-white">Filter Laporan</h3>
        <form method="GET" action="{{ route('reports.transactions') }}" data-loading-search class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5 xl:items-end">
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
    </x-ui.card>

    <div class="hidden print:block print-area mb-6 text-center">
        <h1 class="text-2xl font-bold">LAPORAN TRANSAKSI TOKO JAYUSMAN</h1>
        <p class="text-sm text-slate-500">Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <x-ui.card :padding="false" class="print-area">
        <x-slot:header>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">Rekap Data Transaksi</h3>
                    <p class="text-sm text-slate-500">Menampilkan {{ $totalTransaksi }} transaksi</p>
                </div>
                <p class="text-lg font-bold text-brand-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
            </div>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Kasir</th>
                        <th class="text-right">Total</th>
                        <th class="text-center no-print">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold">{{ $transaction->transaction_code }}</td>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>{{ $transaction->branch->branch_name ?? '-' }}</td>
                            <td>{{ $transaction->cashier->name ?? '-' }}</td>
                            <td class="text-right font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            <td class="text-center no-print"><x-ui.badge variant="active">Selesai</x-ui.badge></td>
                        </tr>
                    @empty
                        <x-ui.table-empty colspan="7" title="Belum ada transaksi" description="Data muncul setelah kasir melakukan penjualan." data-row data-search="" />
                    @endforelse
                </tbody>
                @if($totalTransaksi > 0)
                    <tfoot>
                        <tr class="bg-slate-50 font-semibold dark:bg-slate-800">
                            <td colspan="5" class="text-right">Total Pendapatan</td>
                            <td class="text-right text-brand-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            <td class="no-print"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
