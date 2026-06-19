@php
    $todayCount = $latestTransactions->filter(fn ($t) => \Carbon\Carbon::parse($t->transaction_date)->isToday())->count();
@endphp

<div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-5">
    <div class="lg:col-span-2">
        <a href="{{ route('transactions.create') }}"
           class="group flex h-full min-h-[180px] flex-col items-center justify-center rounded-2xl border-2 border-dashed border-brand-300 bg-brand-50/50 p-8 text-center transition hover:border-brand-500 hover:bg-brand-50 dark:border-brand-800 dark:bg-brand-950/20 dark:hover:bg-brand-950/30">
            <span class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-600 text-white">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
            </span>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Mulai Transaksi</h2>
            <p class="mt-1 text-sm text-slate-500">Buka POS untuk melayani pelanggan</p>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:col-span-3">
        <x-ui.stat-card tone="brand" label="Transaksi Saya" :value="number_format($totalTransactions, 0, ',', '.')" />
        <x-ui.stat-card tone="emerald" label="Total Penjualan" :value="'Rp ' . number_format($totalIncome, 0, ',', '.')" />
        <x-ui.stat-card tone="amber" class="sm:col-span-2" label="Aktivitas Hari Ini" :value="$todayCount" trend="Dari transaksi terbaru" />
    </div>
</div>

<x-dashboard.latest-transactions :latest-transactions="$latestTransactions" />

<div class="mt-6 flex justify-center">
    <x-ui.button href="{{ route('transactions.index') }}" variant="secondary">Riwayat Transaksi Lengkap</x-ui.button>
</div>
