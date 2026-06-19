@php
    $customItems = $breadcrumb ?? null;

    $routeMap = [
        'dashboard' => [
            ['label' => 'Dashboard'],
        ],
        'branches.index' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Master Data'],
            ['label' => 'Cabang'],
        ],
        'branches.create' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Cabang', 'url' => route('branches.index')],
            ['label' => 'Tambah'],
        ],
        'branches.edit' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Cabang', 'url' => route('branches.index')],
            ['label' => 'Edit'],
        ],
        'categories.index' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Master Data'],
            ['label' => 'Kategori'],
        ],
        'categories.create' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Kategori', 'url' => route('categories.index')],
            ['label' => 'Tambah'],
        ],
        'categories.edit' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Kategori', 'url' => route('categories.index')],
            ['label' => 'Edit'],
        ],
        'products.index' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Master Data'],
            ['label' => 'Produk'],
        ],
        'products.create' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Produk', 'url' => route('products.index')],
            ['label' => 'Tambah'],
        ],
        'products.edit' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Produk', 'url' => route('products.index')],
            ['label' => 'Edit'],
        ],
        'stocks.index' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Operasional'],
            ['label' => 'Stok'],
        ],
        'transactions.index' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Operasional'],
            ['label' => 'Transaksi'],
        ],
        'transactions.create' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Transaksi', 'url' => route('transactions.index')],
            ['label' => 'POS / Transaksi Baru'],
        ],
        'transactions.show' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Transaksi', 'url' => route('transactions.index')],
            ['label' => 'Detail'],
        ],
        'stock-movements.index' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Operasional'],
            ['label' => 'Mutasi Stok'],
        ],
        'stock-movements.create' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Mutasi Stok', 'url' => route('stock-movements.index')],
            ['label' => 'Input Mutasi'],
        ],
        'reports.transactions' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Laporan'],
            ['label' => 'Transaksi'],
        ],
        'reports.stocks' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Laporan'],
            ['label' => 'Stok'],
        ],
        'profile.edit' => [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Profil Akun'],
        ],
    ];

    $currentRoute = Route::currentRouteName();
    $items = $customItems ?? ($routeMap[$currentRoute] ?? [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => ucfirst(str_replace(['.', '-', '_'], ' ', $currentRoute ?? 'Halaman'))],
    ]);
@endphp

<x-ui.breadcrumb :items="$items" />
