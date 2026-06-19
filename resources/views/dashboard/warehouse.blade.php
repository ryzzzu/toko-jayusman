@php
    $lowStockCount = $lowStocks->count();
@endphp

<x-ui.card class="mb-6 overflow-hidden border-0 border-l-4 border-l-slate-600 bg-slate-800 p-0 text-white">
    <div class="p-6">
        <p class="text-sm text-white/70">Dashboard Gudang</p>
        <h2 class="mt-1 text-xl font-bold">{{ auth()->user()->name }}</h2>
        <p class="mt-1 text-sm text-white/80">Kelola barang masuk, keluar, dan pantau stok minimum.</p>
    </div>
</x-ui.card>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
    <x-ui.stat-card tone="slate" label="Total Stok" :value="number_format($totalStock, 0, ',', '.')" />
    <x-ui.stat-card tone="brand" label="Produk Terdaftar" :value="number_format($totalProducts, 0, ',', '.')" />
    <x-ui.stat-card tone="rose" label="Stok Minimum" :value="$lowStockCount" :trend="$lowStockCount > 0 ? 'Perlu restock' : 'Semua aman'" />
</div>

<div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
    <x-ui.quick-link href="{{ route('stock-movements.create', ['type' => 'in']) }}" label="Barang Masuk" description="Catat penerimaan stok" icon="arrow-down" tone="emerald" />
    <x-ui.quick-link href="{{ route('stock-movements.create', ['type' => 'out']) }}" label="Barang Keluar" description="Catat pengeluaran stok" icon="arrow-up" tone="rose" />
    <x-ui.quick-link href="{{ route('stock-movements.index') }}" label="Riwayat Mutasi" description="Histori pergerakan stok" icon="switch" tone="brand" />
</div>

<x-dashboard.low-stocks :low-stocks="$lowStocks" />

<div class="mt-6 text-center">
    <x-ui.button href="{{ route('stocks.index') }}" variant="primary">Kelola Data Stok</x-ui.button>
</div>
