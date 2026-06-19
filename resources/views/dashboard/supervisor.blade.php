@php
    $cashierActivity = $latestTransactions
        ->groupBy(fn ($t) => $t->cashier->name ?? 'Tidak diketahui')
        ->map(fn ($items, $name) => ['name' => $name, 'count' => $items->count(), 'total' => $items->sum('total_price')])
        ->sortByDesc('count')
        ->values();
@endphp

<x-ui.card class="mb-6 border-l-4 border-l-violet-500 bg-white p-6 dark:bg-slate-900">
    <p class="text-xs font-bold uppercase tracking-widest text-violet-600">Supervisor</p>
    <h2 class="mt-1 text-xl font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h2>
    <p class="mt-1 text-sm text-slate-500">Monitoring transaksi kasir dan status stok cabang.</p>
</x-ui.card>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat-card tone="violet" label="Transaksi Tercatat" :value="number_format($totalTransactions, 0, ',', '.')" />
    <x-ui.stat-card tone="emerald" label="Nilai Penjualan" :value="'Rp ' . number_format($totalIncome, 0, ',', '.')" />
    <x-ui.stat-card tone="amber" label="Total Stok" :value="number_format($totalStock, 0, ',', '.')" />
</div>

<div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
    <x-ui.card class="xl:col-span-1">
        <x-slot:header>
            <h3 class="font-semibold text-slate-900 dark:text-white">Aktivitas Kasir</h3>
            <p class="text-sm text-slate-500">Dari transaksi terbaru</p>
        </x-slot:header>
        @if($cashierActivity->isNotEmpty())
            <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($cashierActivity as $activity)
                    <li class="flex items-center justify-between py-3 first:pt-0 last:pb-0">
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $activity['name'] }}</p>
                            <p class="text-xs text-slate-500">{{ $activity['count'] }} transaksi</p>
                        </div>
                        <span class="text-sm font-semibold text-brand-600">Rp {{ number_format($activity['total'], 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="py-4 text-center text-sm text-slate-500">Belum ada aktivitas</p>
        @endif
    </x-ui.card>

    <div class="xl:col-span-2">
        <x-dashboard.latest-transactions :latest-transactions="$latestTransactions" :show-cashier="true" />
    </div>
</div>

<div class="mt-6">
    <x-dashboard.low-stocks :low-stocks="$lowStocks" />
</div>