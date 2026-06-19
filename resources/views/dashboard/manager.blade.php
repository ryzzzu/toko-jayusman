@php
    $lowStockCount = $lowStocks->count();
    $todayCount = $latestTransactions->filter(fn ($t) => \Carbon\Carbon::parse($t->transaction_date)->isToday())->count();
@endphp

<x-ui.card class="mb-6 overflow-hidden border-0 bg-brand-800 p-0 text-white">
    <div class="flex flex-col gap-4 p-6 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm text-white/70">Dashboard Manajer Toko</p>
            <h2 class="mt-1 text-xl font-bold">{{ auth()->user()->name }}</h2>
            <p class="mt-1 text-sm text-white/80">Kelola penjualan, stok, dan operasional cabang Anda.</p>
        </div>
        <x-ui.button href="{{ route('reports.transactions') }}" variant="secondary" class="border-white/20 bg-white/10 text-white hover:bg-white/20">Laporan Transaksi</x-ui.button>
    </div>
</x-ui.card>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-ui.stat-card tone="emerald" label="Penjualan Toko" :value="'Rp ' . number_format($totalIncome, 0, ',', '.')" />
    <x-ui.stat-card tone="brand" label="Total Transaksi" :value="number_format($totalTransactions, 0, ',', '.')" :trend="$todayCount > 0 ? $todayCount . ' hari ini (terbaru)' : null" />
    <x-ui.stat-card tone="amber" label="Total Stok" :value="number_format($totalStock, 0, ',', '.')" />
    <x-ui.stat-card tone="rose" label="Stok Menipis" :value="$lowStockCount" :trend="$lowStockCount > 0 ? 'Perlu perhatian' : 'Stok aman'" />
</div>

<div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
    <x-ui.quick-link href="{{ route('products.index') }}" category="Master" label="Kelola Produk" icon="box" tone="brand" />
    <x-ui.quick-link href="{{ route('stocks.index') }}" category="Stok" label="Data Stok" icon="archive" tone="emerald" />
    <x-ui.quick-link href="{{ route('stock-movements.index') }}" category="Gudang" label="Mutasi Stok" icon="switch" tone="amber" />
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
    <x-dashboard.latest-transactions :latest-transactions="$latestTransactions" :show-cashier="true" />
    <x-dashboard.low-stocks :low-stocks="$lowStocks" />
</div>
