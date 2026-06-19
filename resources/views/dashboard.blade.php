<x-app-layout>
    @php
        $role = auth()->user()->role;
        $headers = [
            'owner' => ['Dashboard Owner', 'Ringkasan performa seluruh cabang mini market'],
            'manager' => ['Dashboard Manajer', 'Penjualan, stok, dan operasional cabang'],
            'supervisor' => ['Dashboard Supervisor', 'Monitoring transaksi kasir dan stok'],
            'cashier' => ['Dashboard Kasir', 'Fokus transaksi — cepat dan mudah'],
            'warehouse' => ['Dashboard Gudang', 'Barang masuk, keluar, dan stok minimum'],
        ];
        [$title, $subtitle] = $headers[$role] ?? ['Dashboard', 'Sistem Informasi Mini Market'];
    @endphp

    <x-slot name="header">
        <div>
            <h1 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h1>
            <p class="text-sm text-slate-500">{{ $subtitle }}</p>
        </div>
    </x-slot>

    <x-dashboard.branch-warning :branch-warning="$branchWarning ?? false" />

    @switch($role)
        @case('owner')
            @include('dashboard.owner')
            @break
        @case('manager')
            @include('dashboard.manager')
            @break
        @case('supervisor')
            @include('dashboard.supervisor')
            @break
        @case('cashier')
            @include('dashboard.cashier')
            @break
        @case('warehouse')
            @include('dashboard.warehouse')
            @break
        @default
            @include('dashboard.manager')
    @endswitch
</x-app-layout>
