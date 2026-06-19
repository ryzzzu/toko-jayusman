<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Data Transaksi</h1>
                <p class="text-sm text-slate-500">Riwayat transaksi penjualan yang tercatat di sistem</p>
            </div>
            @if(auth()->user()->role === 'cashier')
                <x-ui.button href="{{ route('transactions.create') }}" variant="primary">+ Transaksi Baru</x-ui.button>
            @endif
        </div>
    </x-slot>

    @php
        $totalIncome = $transactions->sum('total_price');
        $totalTransactions = $transactions->count();
    @endphp

    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-ui.stat-card label="Jumlah Transaksi" :value="$totalTransactions" />
        <x-ui.stat-card class="md:col-span-2" label="Total Nilai Transaksi" :value="'Rp ' . number_format($totalIncome, 0, ',', '.')" />
    </div>

    <x-ui.card :padding="false">
        <x-slot:header>
            <h3 class="font-semibold text-slate-900 dark:text-white">Riwayat Transaksi</h3>
            <p class="text-sm text-slate-500">Data transaksi terbaru ditampilkan paling atas</p>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Kasir</th>
                        <th class="text-right">Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody data-searchable>
                    @forelse($transactions as $transaction)
                        <tr data-row data-search="{{ strtolower($transaction->transaction_code . ' ' . $transaction->transaction_date . ' ' . ($transaction->branch->branch_name ?? '') . ' ' . ($transaction->cashier->name ?? '')) }}">
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $transaction->transaction_code }}</td>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>{{ $transaction->branch->branch_name }}</td>
                            <td>{{ $transaction->cashier->name }}</td>
                            <td class="text-right font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            <td class="text-center"><x-ui.badge variant="active">Selesai</x-ui.badge></td>
                            <td class="text-center">
                                <x-ui.button href="{{ route('transactions.show', $transaction->id) }}" variant="secondary">Detail</x-ui.button>
                            </td>
                        </tr>
                    @empty
                        <x-ui.table-empty colspan="7" title="Belum ada transaksi" description="Transaksi akan muncul setelah kasir melakukan penjualan." data-row data-search="" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
