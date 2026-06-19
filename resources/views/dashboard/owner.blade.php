@php
    $todayCount = $latestTransactions->filter(fn ($t) => \Carbon\Carbon::parse($t->transaction_date)->isToday())->count();

    $branchSales = $latestTransactions
        ->groupBy(fn ($t) => $t->branch->branch_name ?? 'Tanpa Cabang')
        ->map(fn ($items, $name) => ['name' => $name, 'total' => $items->sum('total_price')])
        ->sortByDesc('total')
        ->values();

    $maxSale = $branchSales->max('total') ?: 1;
    $topBranch = $branchSales->first();
@endphp

<x-ui.card class="mb-6 overflow-hidden border-0 bg-slate-900 p-0 text-white">
    <div class="flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between lg:p-8">
        <div>
            <p class="text-sm font-medium text-white/70">Selamat datang, Owner</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h2>
            <p class="mt-2 max-w-xl text-sm text-white/80">Pantau performa seluruh cabang mini market dari satu dashboard terpusat.</p>
        </div>
        <div class="flex gap-3">
            <div class="rounded-2xl bg-white/10 px-5 py-4">
                <p class="text-xs uppercase tracking-wide text-white/60">Total Cabang</p>
                <p class="mt-1 text-2xl font-bold">{{ $totalBranches }}</p>
            </div>
            <div class="rounded-2xl bg-white/10 px-5 py-4">
                <p class="text-xs uppercase tracking-wide text-white/60">Pendapatan</p>
                <p class="mt-1 text-lg font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</x-ui.card>

<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-ui.stat-card tone="brand" label="Total Cabang" :value="$totalBranches" />
    <x-ui.stat-card tone="emerald" label="Total Transaksi" :value="number_format($totalTransactions, 0, ',', '.')" :trend="$todayCount > 0 ? $todayCount . ' transaksi hari ini (terbaru)' : null" />
    <x-ui.stat-card tone="amber" label="Total Stok Barang" :value="number_format($totalStock, 0, ',', '.')" />
    <x-ui.stat-card tone="violet" label="Produk Terdaftar" :value="number_format($totalProducts, 0, ',', '.')" />
</div>

<div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
    <x-ui.card class="xl:col-span-2">
        <x-slot:header>
            <h3 class="font-semibold text-slate-900 dark:text-white">Penjualan per Cabang</h3>
            <p class="text-sm text-slate-500">Agregasi dari 5 transaksi terbaru</p>
        </x-slot:header>
        @if($branchSales->isNotEmpty())
            <div class="space-y-4">
                @foreach($branchSales as $branch)
                    @php $pct = round(($branch['total'] / $maxSale) * 100); @endphp
                    <div>
                        <div class="mb-1.5 flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $branch['name'] }}</span>
                            <span class="font-semibold text-slate-900 dark:text-white">Rp {{ number_format($branch['total'], 0, ',', '.') }}</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                            <div class="h-full rounded-full bg-brand-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-ui.empty-state title="Belum ada data penjualan" description="Grafik akan muncul setelah transaksi tercatat." />
        @endif
    </x-ui.card>

    @if($topBranch)
        <x-ui.card class="border-accent-200/60 bg-gradient-to-br from-accent-50 to-white dark:border-accent-900/40 dark:from-accent-950/30 dark:to-slate-900">
            <p class="text-xs font-bold uppercase tracking-widest text-accent-600">Cabang Teratas</p>
            <h3 class="mt-2 text-xl font-bold text-slate-900 dark:text-white">{{ $topBranch['name'] }}</h3>
            <p class="mt-1 text-3xl font-bold tracking-tight text-accent-600">Rp {{ number_format($topBranch['total'], 0, ',', '.') }}</p>
            <p class="mt-2 text-sm text-slate-500">Penjualan tertinggi dari transaksi terbaru</p>
            <x-ui.button href="{{ route('reports.transactions') }}" variant="primary" class="mt-5">Lihat Laporan</x-ui.button>
        </x-ui.card>
    @endif
</div>

<div class="mb-6 grid grid-cols-2 gap-3 md:grid-cols-4">
    <x-ui.quick-link href="{{ route('branches.index') }}" category="Master" label="Data Cabang" icon="building" tone="brand" />
    <x-ui.quick-link href="{{ route('products.index') }}" category="Master" label="Data Produk" icon="box" tone="emerald" />
    <x-ui.quick-link href="{{ route('stocks.index') }}" category="Operasional" label="Data Stok" icon="archive" tone="amber" />
    <x-ui.quick-link href="{{ route('transactions.index') }}" category="Penjualan" label="Transaksi" icon="receipt" tone="violet" />
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
    <x-dashboard.latest-transactions :latest-transactions="$latestTransactions" />
    <x-dashboard.low-stocks :low-stocks="$lowStocks" />
</div>
