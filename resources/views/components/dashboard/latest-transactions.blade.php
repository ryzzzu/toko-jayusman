@props(['showCashier' => false, 'latestTransactions' => null])

@php
    $latestTransactions = $latestTransactions ?? collect();
@endphp

<x-ui.card :padding="false" {{ $attributes }}>
    <x-slot:header>
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="font-semibold text-slate-900 dark:text-white">Transaksi Terbaru</h3>
                <p class="text-sm text-slate-500">5 transaksi terakhir yang tercatat</p>
            </div>
            @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier']))
                <x-ui.button href="{{ route('transactions.index') }}" variant="ghost">Lihat Semua</x-ui.button>
            @endif
        </div>
    </x-slot:header>
    <div class="ui-table-wrap rounded-none border-0 shadow-none">
        <table class="ui-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    @if($showCashier)<th>Kasir</th>@endif
                    <th>Cabang</th>
                    <th class="text-right">Total</th>
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
                        <td class="text-right font-semibold text-slate-900 dark:text-white">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr data-row data-search="">
                        <td colspan="{{ $showCashier ? 4 : 3 }}" class="py-10 text-center">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Belum ada transaksi</p>
                            <p class="mt-1 text-xs text-slate-500">Transaksi akan muncul setelah penjualan dilakukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-ui.card>
