<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Detail Transaksi</h1>
                <p class="text-sm text-slate-500">{{ $transaction->transaction_code }}</p>
            </div>
            <div class="flex gap-2 no-print">
                <x-ui.button type="button" variant="secondary" onclick="window.print()">Cetak Struk</x-ui.button>
                <x-ui.button href="{{ route('transactions.index') }}" variant="ghost">Kembali</x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="print-area mx-auto max-w-3xl space-y-6">
        @if(session('success'))
            <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
        @endif

        <x-ui.card>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><p class="text-xs uppercase text-slate-400">Tanggal</p><p class="font-semibold">{{ $transaction->transaction_date }}</p></div>
                <div><p class="text-xs uppercase text-slate-400">Cabang</p><p class="font-semibold">{{ $transaction->branch->branch_name }}</p></div>
                <div><p class="text-xs uppercase text-slate-400">Kasir</p><p class="font-semibold">{{ $transaction->cashier->name }}</p></div>
                <div><p class="text-xs uppercase text-slate-400">Status</p><x-ui.badge variant="active">Selesai</x-ui.badge></div>
            </div>
        </x-ui.card>

        <x-ui.card :padding="false">
            <x-slot:header><h3 class="font-semibold text-slate-900 dark:text-white">Rincian Barang</h3></x-slot:header>
            <div class="ui-table-wrap rounded-none border-0 shadow-none">
                <table class="ui-table">
                    <thead><tr><th>Produk</th><th class="text-center">Qty</th><th class="text-right">Harga</th><th class="text-right">Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($transaction->details as $detail)
                            <tr>
                                <td class="font-medium">{{ $detail->product->product_name }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="text-right font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-slate-500">Total</span><span class="text-xl font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Bayar</span><span class="font-semibold">Rp {{ number_format($transaction->payment, 0, ',', '.') }}</span></div>
                <div class="flex justify-between border-t border-slate-100 pt-2 dark:border-slate-800"><span class="text-slate-500">Kembalian</span><span class="font-semibold text-accent-600 dark:text-accent-400">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span></div>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>
