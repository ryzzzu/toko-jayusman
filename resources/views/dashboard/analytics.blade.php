@php
    use Carbon\Carbon;

    $role = auth()->user()->role;
    $latestTransactions = $latestTransactions ?? collect();
    $lowStocks = $lowStocks ?? collect();
    $charts = $charts ?? [];

    $today = Carbon::today()->toDateString();
    $todayTx = $latestTransactions->filter(fn ($t) => Carbon::parse($t->transaction_date)->toDateString() === $today);
    $todaySales = $todayTx->sum('total_price');
    $todayTxCount = $todayTx->count();

    // Payload chart — dari backend ($charts), tanpa data dummy
    $salesDaily = [
        'labels' => $charts['salesTrend']['labels'] ?? [],
        'totals' => $charts['salesTrend']['totals'] ?? [],
    ];
    $salesMonthly = $charts['monthlySales'] ?? ['labels' => [], 'values' => []];
    $stockFlow = $charts['stockFlow'] ?? ['labels' => [], 'in' => [], 'out' => []];
    $branchSales = $charts['branchSales'] ?? ['labels' => [], 'values' => []];
    $topProducts = $charts['topProducts'] ?? ['labels' => [], 'values' => []];
    $categorySales = $charts['categorySales'] ?? ['labels' => [], 'values' => []];

    $can = [
        'salesDaily' => in_array($role, ['owner', 'manager', 'supervisor', 'cashier'], true),
        'salesMonthly' => in_array($role, ['owner', 'manager', 'supervisor'], true),
        'stockFlow' => in_array($role, ['owner', 'manager', 'supervisor', 'warehouse'], true),
        'branchSales' => $role === 'owner',
        'topProducts' => in_array($role, ['owner', 'manager', 'supervisor'], true),
        'categorySales' => in_array($role, ['owner', 'manager', 'supervisor'], true),
        'transactionsTable' => in_array($role, ['owner', 'manager', 'supervisor', 'cashier'], true),
        'lowStockTable' => in_array($role, ['owner', 'manager', 'supervisor', 'warehouse'], true),
    ];
@endphp

<div class="dashboard-analytics space-y-8">
    {{-- KPI --}}
    <section>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @if(in_array($role, ['owner', 'manager', 'supervisor', 'cashier'], true))
                <x-dashboard.kpi-card label="Total Omset" :value="'Rp ' . number_format($totalIncome, 0, ',', '.')" compare="Akumulasi transaksi" />
                <x-dashboard.kpi-card label="Total Transaksi" :value="number_format($totalTransactions, 0, ',', '.')" compare="Transaksi tercatat" />
            @endif

            @if($role === 'cashier')
                <x-dashboard.kpi-card label="Omset Hari Ini" :value="'Rp ' . number_format($todaySales, 0, ',', '.')" footnote="Snapshot transaksi terbaru" />
                <x-dashboard.kpi-card label="Transaksi Hari Ini" :value="number_format($todayTxCount, 0, ',', '.')" />
            @endif

            @if($role === 'owner' && isset($totalBranches))
                <x-dashboard.kpi-card label="Total Cabang" :value="number_format($totalBranches, 0, ',', '.')" />
            @endif

            @if(in_array($role, ['owner', 'manager', 'supervisor', 'warehouse'], true))
                <x-dashboard.kpi-card label="Total Produk" :value="number_format($totalProducts, 0, ',', '.')" />
                <x-dashboard.kpi-card label="Total Stok" :value="number_format($totalStock, 0, ',', '.')" />
            @endif

            @if($role === 'owner')
                <x-dashboard.kpi-card label="Total Customer" value="—" compare="Modul customer belum tersedia" />
                <x-dashboard.kpi-card label="Total Supplier" value="—" compare="Modul supplier belum tersedia" />
            @endif
        </div>
    </section>

    {{-- Tren penjualan --}}
    @if($can['salesDaily'] || $can['salesMonthly'])
        <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            @if($can['salesDaily'])
                <x-dashboard.panel title="Penjualan Harian" description="Omset 7 hari terakhir">
                    <x-dashboard.chart
                        type="sales-daily"
                        :payload="$salesDaily"
                        :height="240"
                        empty-title="Belum ada penjualan harian"
                        empty-description="Grafik terisi setelah transaksi penjualan tercatat."
                    />
                </x-dashboard.panel>
            @endif

            @if($can['salesMonthly'])
                <x-dashboard.panel title="Penjualan Bulanan" description="Perkembangan omset per bulan">
                    <x-dashboard.chart
                        type="sales-monthly"
                        :payload="$salesMonthly"
                        :height="240"
                        empty-title="Agregasi bulanan belum tersedia"
                        empty-description="Backend dashboard belum mengirim data penjualan bulanan."
                    />
                </x-dashboard.panel>
            @endif
        </section>
    @endif

    {{-- Cabang & pergerakan stok --}}
    @if($can['branchSales'] || $can['stockFlow'])
        <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            @if($can['branchSales'])
                <x-dashboard.panel title="Penjualan per Cabang" description="Perbandingan performa cabang">
                    <x-dashboard.chart
                        type="branch-sales"
                        :payload="$branchSales"
                        :height="260"
                        empty-title="Belum ada data cabang"
                        empty-description="Grafik terisi setelah transaksi di berbagai cabang."
                    />
                </x-dashboard.panel>
            @endif

            @if($can['stockFlow'])
                <x-dashboard.panel @class(['lg:col-span-2' => !$can['branchSales']]) title="Barang Masuk vs Keluar" description="Pergerakan stok per periode">
                    <x-dashboard.chart
                        type="stock-flow"
                        :payload="$stockFlow"
                        :height="260"
                        empty-title="Data mutasi stok belum tersedia"
                        empty-description="Backend dashboard belum mengirim agregasi barang masuk & keluar."
                    />
                </x-dashboard.panel>
            @endif
        </section>
    @endif

    {{-- Produk & kategori --}}
    @if($can['topProducts'] || $can['categorySales'])
        <section class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @if($can['topProducts'])
                <x-dashboard.panel class="lg:col-span-2" title="Top 10 Produk Terlaris" description="Produk dengan penjualan tertinggi">
                    <x-dashboard.chart
                        type="top-products"
                        :payload="$topProducts"
                        :height="280"
                        empty-title="Data produk terlaris belum tersedia"
                        empty-description="Backend dashboard belum mengirim agregasi detail transaksi."
                    />
                </x-dashboard.panel>
            @endif

            @if($can['categorySales'])
                <x-dashboard.panel title="Kategori Produk" description="Distribusi penjualan per kategori">
                    <x-dashboard.chart
                        type="category-donut"
                        :payload="$categorySales"
                        :height="280"
                        empty-title="Data kategori belum tersedia"
                        empty-description="Backend dashboard belum mengirim agregasi kategori."
                    />
                </x-dashboard.panel>
            @endif
        </section>
    @endif

    {{-- Tabel --}}
    @if($can['transactionsTable'] || $can['lowStockTable'])
        <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            @if($can['transactionsTable'])
                <x-dashboard.latest-transactions
                    :latest-transactions="$latestTransactions"
                    :show-cashier="in_array($role, ['owner', 'manager', 'supervisor'], true)"
                />
            @endif

            @if($can['lowStockTable'])
                <x-dashboard.low-stocks :low-stocks="$lowStocks" />
            @endif
        </section>
    @endif
</div>
