<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Laporan Transaksi
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Filter, pantau, dan cetak laporan transaksi penjualan Toko Jayusman.
                </p>
            </div>

            <div class="flex gap-2 print:hidden">
                <a href="{{ route('reports.transactions') }}"
                   class="px-4 py-2 rounded-xl bg-indigo-700 text-white text-sm font-semibold shadow">
                    Transaksi
                </a>

                <a href="{{ route('reports.stocks') }}"
                   class="px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-50">
                    Stok
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            nav,
            header,
            .print-hidden,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .print-area {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $grandTotal = $transactions->sum('total_price');
                $totalTransaksi = $transactions->count();
                $rataRata = $totalTransaksi > 0 ? $grandTotal / $totalTransaksi : 0;
            @endphp

            {{-- HERO --}}
            <div class="bg-gradient-to-r from-indigo-700 via-blue-700 to-sky-500 rounded-2xl p-6 text-white shadow-lg mb-6 print-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-sm text-white/80">
                            Laporan Penjualan
                        </p>
                        <h1 class="text-3xl font-bold mt-1">
                            Rekap Transaksi Mini Market
                        </h1>
                        <p class="text-white/90 mt-2 max-w-2xl">
                            Gunakan filter tanggal dan cabang untuk melihat transaksi sesuai kebutuhan laporan.
                        </p>
                    </div>

                    <div class="bg-white/15 rounded-xl px-5 py-4">
                        <p class="text-sm text-white/80">Tanggal Cetak</p>
                        <p class="font-bold">
                            {{ now()->format('d-m-Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- STATISTIC --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalTransaksi }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Transaksi sesuai filter
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <h3 class="text-3xl font-bold text-indigo-700 mt-2">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Akumulasi nilai transaksi
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Rata-rata Transaksi</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">
                        Rp {{ number_format($rataRata, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-2">
                        Nilai rata-rata transaksi
                    </p>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 print-hidden">
                <div class="mb-5">
                    <h3 class="text-lg font-bold text-gray-900">
                        Filter Laporan
                    </h3>
                    <p class="text-sm text-gray-500">
                        Pilih cabang dan rentang tanggal untuk menampilkan laporan.
                    </p>
                </div>

                <form method="GET" action="{{ route('reports.transactions') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                    @if(auth()->user()->role === 'owner')
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Cabang
                            </label>

                            <select name="branch_id"
                                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Semua Cabang</option>

                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Awal
                        </label>

                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Akhir
                        </label>

                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <button type="submit"
                            class="px-5 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl text-sm font-semibold shadow">
                        Filter
                    </button>

                    <button type="button"
                            onclick="window.print()"
                            class="px-5 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-xl text-sm font-semibold shadow">
                        Cetak
                    </button>
                </form>
            </div>

            {{-- PRINT HEADER --}}
            <div class="hidden print:block mb-6 text-center">
                <h1 class="text-2xl font-bold">
                    LAPORAN TRANSAKSI TOKO JAYUSMAN
                </h1>
                <p class="text-sm">
                    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
                </p>
                <hr class="my-4">
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden print-area">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">
                            Rekap Data Transaksi
                        </h3>
                        <p class="text-sm text-gray-500">
                            Menampilkan {{ $totalTransaksi }} data transaksi.
                        </p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-sm text-gray-500">
                            Total Pendapatan
                        </p>
                        <h3 class="text-2xl font-bold text-indigo-700">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">No</th>
                                <th class="px-5 py-4 text-left">Kode Transaksi</th>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-left">Cabang</th>
                                <th class="px-5 py-4 text-left">Kasir</th>
                                <th class="px-5 py-4 text-right">Total</th>
                                <th class="px-5 py-4 text-center print-hidden">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-5 py-4 font-semibold text-gray-900">
                                        {{ $transaction->transaction_code }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $transaction->transaction_date }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $transaction->branch->branch_name ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Cabang toko
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $transaction->cashier->name ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-right font-bold text-gray-900">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-center print-hidden">
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Selesai
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-14 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center text-2xl font-bold mb-3">
                                                !
                                            </div>

                                            <h3 class="font-bold text-gray-800">
                                                Belum ada transaksi
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Data transaksi akan muncul setelah kasir melakukan penjualan.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="bg-gray-50">
                            <tr>
                                <th colspan="5" class="px-5 py-4 text-right text-gray-900">
                                    Total Pendapatan
                                </th>
                                <th class="px-5 py-4 text-right text-indigo-700 text-lg">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </th>
                                <th class="print-hidden"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>