@props(['showCashier' => false, 'latestTransactions' => null])

@php
    $latestTransactions = $latestTransactions ?? collect();
@endphp

<x-dashboard.panel title="Transaksi Terbaru" :description="$latestTransactions->count() . ' transaksi terakhir dari backend'" {{ $attributes }}>
    <x-slot:action>
        @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier']))
            <x-ui.button href="{{ route('transactions.index') }}" variant="ghost">Lihat Semua</x-ui.button>
        @endif
    </x-slot:action>

    <div class="ui-table-wrap rounded-none border-0 shadow-none">
        <table class="ui-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    @if($showCashier)<th>Kasir</th>@endif
                    <th>Cabang</th>
                    <th>Tanggal</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody data-searchable>
                @forelse($latestTransactions as $transaction)
                    <tr data-row data-search="{{ strtolower($transaction->transaction_code . ' ' . ($transaction->branch->branch_name ?? '') . ' ' . ($transaction->cashier->name ?? '')) }}">
                        <td>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400">
                                {{ $transaction->transaction_code }}
                            </a>
                        </td>
                        @if($showCashier)
                            <td>{{ $transaction->cashier->name ?? '—' }}</td>
                        @endif
                        <td>{{ $transaction->branch->branch_name ?? '—' }}</td>
                        <td class="text-slate-500">{{ $transaction->transaction_date }}</td>
                        <td class="text-right font-semibold text-slate-900 dark:text-white">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td class="text-center"><x-ui.badge variant="active">Selesai</x-ui.badge></td>
                    </tr>
                @empty
                    <x-ui.table-empty :colspan="$showCashier ? 6 : 5" title="Belum ada transaksi" description="Transaksi akan muncul setelah penjualan dilakukan." data-row data-search="" />
                @endforelse
            </tbody>
        </table>
    </div>
</x-dashboard.panel>
