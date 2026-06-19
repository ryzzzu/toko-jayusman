<x-app-layout>
    @php
        $role = auth()->user()->role;
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">Dashboard</h1>
                <p class="mt-0.5 text-sm text-slate-500">Ringkasan operasional {{ auth()->user()->branch->branch_name ?? 'seluruh cabang' }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if($role === 'cashier')
                    <x-ui.button href="{{ route('transactions.create') }}" variant="primary">Transaksi Baru</x-ui.button>
                @endif
                @if(in_array($role, ['owner', 'manager']))
                    <x-ui.button href="{{ route('reports.transactions') }}" variant="secondary">Laporan</x-ui.button>
                @endif
                @if($role === 'warehouse')
                    <x-ui.button href="{{ route('stock-movements.create', ['type' => 'in']) }}" variant="secondary">Barang Masuk</x-ui.button>
                @endif
            </div>
        </div>
    </x-slot>

    <x-dashboard.branch-warning :branch-warning="$branchWarning ?? false" />

    @include('dashboard.analytics')
</x-app-layout>
