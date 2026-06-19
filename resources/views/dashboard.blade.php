<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Monitoring
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Sistem monitoring transaksi dan stok barang Toko Jayusman
                </p>
            </div>

            <div class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            @if(!empty($branchWarning))
                <div class="mb-5 p-4 bg-yellow-100 text-yellow-800 rounded-xl">
                    Akun Anda belum terhubung ke cabang. Hubungi Pak Jayusman untuk penugasan cabang.
                </div>
            @endif

            {{-- WELCOME CARD --}}
            <div class="bg-gradient-to-r from-indigo-700 via-blue-700 to-sky-500 rounded-2xl p-6 text-white shadow-lg mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-sm text-white/80">Selamat datang,</p>
                        <h1 class="text-3xl font-bold mt-1">
                            {{ auth()->user()->name }}
                        </h1>
                        <p class="mt-2 text-white/90 max-w-2xl">
                            Pantau seluruh transaksi, stok barang, dan aktivitas cabang mini market
                            secara terpusat dalam satu dashboard.
                        </p>
                    </div>

                    <div class="bg-white/15 rounded-xl px-5 py-4 text-center">
                        <p class="text-sm text-white/80">Role</p>
                        <p class="text-xl font-bold uppercase">
                            {{ auth()->user()->role }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- STATISTIC CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

                @if(auth()->user()->role === 'owner')
                    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Cabang</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-2">
                                    {{ $totalBranches }}
                                </h3>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                                C
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Produk</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $totalProducts }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            P
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Stok</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $totalStock }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-700 flex items-center justify-center font-bold">
                            S
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Transaksi</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $totalTransactions }}
                            </h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold">
                            T
                        </div>
                    </div>
                </div>

            </div>

            {{-- INCOME CARD --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <h3 class="text-4xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Akumulasi seluruh transaksi yang sudah tercatat di sistem.
                        </p>
                    </div>

                    @if(in_array(auth()->user()->role, ['owner', 'manager']))
                    <a href="{{ route('reports.transactions') }}"
                       class="inline-flex items-center justify-center px-5 py-3 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl font-semibold">
                        Lihat Laporan
                    </a>
                    @endif
                </div>
            </div>

            {{-- QUICK MENU --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">

                @if(auth()->user()->role === 'owner')
                    <a href="{{ route('branches.index') }}"
                       class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
                        <p class="text-sm text-gray-500">Master Data</p>
                        <h4 class="font-bold text-gray-900 mt-1">Data Cabang</h4>
                    </a>
                @endif

                @if(in_array(auth()->user()->role, ['owner', 'manager']))
                    <a href="{{ route('products.index') }}"
                       class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
                        <p class="text-sm text-gray-500">Master Data</p>
                        <h4 class="font-bold text-gray-900 mt-1">Data Produk</h4>
                    </a>
                @endif

                @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'warehouse']))
                    <a href="{{ route('stocks.index') }}"
                       class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
                        <p class="text-sm text-gray-500">Persediaan</p>
                        <h4 class="font-bold text-gray-900 mt-1">Data Stok</h4>
                    </a>
                @endif

                @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier']))
                    <a href="{{ route('transactions.index') }}"
                       class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition">
                        <p class="text-sm text-gray-500">Penjualan</p>
                        <h4 class="font-bold text-gray-900 mt-1">Data Transaksi</h4>
                    </a>
                @endif

            </div>

            {{-- TABLE SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- TRANSAKSI TERBARU --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">
                            Transaksi Terbaru
                        </h3>
                        <p class="text-sm text-gray-500">
                            Data transaksi terakhir yang masuk ke sistem.
                        </p>
                    </div>

                    <div class="p-5 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="pb-3">Kode</th>
                                    <th class="pb-3">Cabang</th>
                                    <th class="pb-3">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($latestTransactions as $transaction)
                                    <tr class="border-b last:border-b-0">
                                        <td class="py-3 font-medium text-gray-900">
                                            {{ $transaction->transaction_code }}
                                        </td>
                                        <td class="py-3 text-gray-600">
                                            {{ $transaction->branch->branch_name }}
                                        </td>
                                        <td class="py-3 font-semibold text-gray-900">
                                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-5 text-center text-gray-500">
                                            Belum ada transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- STOK MENIPIS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">
                            Stok Menipis
                        </h3>
                        <p class="text-sm text-gray-500">
                            Barang dengan stok kurang dari atau sama dengan 10.
                        </p>
                    </div>

                    <div class="p-5 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="pb-3">Produk</th>
                                    <th class="pb-3">Cabang</th>
                                    <th class="pb-3">Stok</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($lowStocks as $stock)
                                    <tr class="border-b last:border-b-0">
                                        <td class="py-3 font-medium text-gray-900">
                                            {{ $stock->product->product_name }}
                                        </td>
                                        <td class="py-3 text-gray-600">
                                            {{ $stock->branch->branch_name }}
                                        </td>
                                        <td class="py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                {{ $stock->quantity }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-5 text-center text-gray-500">
                                            Tidak ada stok menipis.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>