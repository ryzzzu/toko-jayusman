<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">Mutasi Stok</h1>
                <p class="mt-0.5 text-sm text-slate-500">Riwayat barang masuk, keluar, dan penyesuaian</p>
            </div>
            @if(auth()->user()->role === 'warehouse')
                <x-ui.button href="{{ route('stock-movements.create') }}" variant="primary">Input Stok</x-ui.button>
            @endif
        </div>
    </x-slot>

    <div class="mb-5 grid grid-cols-2 gap-4 xl:grid-cols-4">
        <x-ui.stat-card label="Total Mutasi" :value="$movements->count()" />
        <x-ui.stat-card label="Barang Masuk" :value="$movements->where('type', 'in')->count()" />
        <x-ui.stat-card label="Barang Keluar" :value="$movements->where('type', 'out')->count()" />
        <x-ui.stat-card label="Penjualan" :value="$movements->where('type', 'sale')->count()" />
    </div>

    <x-ui.card :padding="false">
        <x-slot:header>
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">Riwayat Pergerakan Stok</h3>
                    <p class="text-sm text-slate-500">Setiap perubahan stok tercatat untuk mencegah manipulasi</p>
                </div>
                <x-ui.badge variant="brand">{{ $movements->count() }} data</x-ui.badge>
            </div>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Cabang</th>
                        <th>Produk</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Jumlah</th>
                        <th>Petugas</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody data-searchable>
                    @forelse($movements as $movement)
                        <tr data-row data-search="{{ strtolower($movement->movement_date . ' ' . ($movement->branch->branch_name ?? '') . ' ' . ($movement->product->product_name ?? '') . ' ' . $movement->type . ' ' . ($movement->user->name ?? '')) }}">
                            <td>{{ $movement->movement_date }}</td>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $movement->branch->branch_name ?? '-' }}</td>
                            <td>{{ $movement->product->product_name ?? '-' }}</td>
                            <td class="text-center">
                                @if($movement->type === 'in')
                                    <x-ui.badge variant="active">Masuk</x-ui.badge>
                                @elseif($movement->type === 'out')
                                    <x-ui.badge variant="failed">Keluar</x-ui.badge>
                                @elseif($movement->type === 'sale')
                                    <x-ui.badge variant="brand">Penjualan</x-ui.badge>
                                @else
                                    <x-ui.badge variant="pending">Penyesuaian</x-ui.badge>
                                @endif
                            </td>
                            <td class="text-center font-bold">{{ $movement->quantity }}</td>
                            <td>{{ $movement->user->name ?? '-' }}</td>
                            <td>{{ $movement->description ?? '-' }}</td>
                        </tr>
                    @empty
                        <x-ui.table-empty colspan="7" title="Belum ada mutasi stok" description="Data barang masuk, keluar, dan penjualan akan tampil di sini." data-row data-search="">
                            @if(auth()->user()->role === 'warehouse')
                                <x-slot:action>
                                    <x-ui.button href="{{ route('stock-movements.create') }}" variant="primary">Input Stok</x-ui.button>
                                </x-slot:action>
                            @endif
                        </x-ui.table-empty>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
