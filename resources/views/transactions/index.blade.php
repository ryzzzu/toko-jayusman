<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Data Transaksi</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Riwayat transaksi penjualan yang tercatat di sistem.
                </p>
            </div>

            @if(auth()->user()->role === 'cashier')
                <a href="{{ route('transactions.create') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl text-sm font-semibold shadow">
                    + Transaksi Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $totalIncome = $transactions->sum('total_price');
                $totalTransactions = $transactions->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500">Jumlah Transaksi</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTransactions }}</h3>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 md:col-span-2">
                    <p class="text-sm text-gray-500">Total Nilai Transaksi</p>
                    <h3 class="text-3xl font-bold text-indigo-700 mt-2">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Transaksi</h3>
                    <p class="text-sm text-gray-500">Data transaksi terbaru ditampilkan paling atas.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-4 text-left">Kode</th>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-left">Cabang</th>
                                <th class="px-5 py-4 text-left">Kasir</th>
                                <th class="px-5 py-4 text-right">Total</th>
                                <th class="px-5 py-4 text-center">Status</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 font-semibold text-gray-900">
                                        {{ $transaction->transaction_code }}
                                    </td>

                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $transaction->transaction_date }}
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $transaction->branch->branch_name }}
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $transaction->cashier->name }}
                                    </td>

                                    <td class="px-5 py-4 text-right font-bold text-gray-900">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Selesai
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                           class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg font-semibold">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>