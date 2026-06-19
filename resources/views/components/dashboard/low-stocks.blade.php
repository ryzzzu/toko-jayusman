@props(['lowStocks' => null])

@php
    $lowStocks = $lowStocks ?? collect();
@endphp

<x-ui.card :padding="false" {{ $attributes }}>
    <x-slot:header>
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="font-semibold text-slate-900 dark:text-white">Stok Menipis</h3>
                <p class="text-sm text-slate-500">Produk dengan stok &le; 10 unit</p>
            </div>
            @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'warehouse']))
                <x-ui.button href="{{ route('stocks.index') }}" variant="ghost">Kelola Stok</x-ui.button>
            @endif
        </div>
    </x-slot:header>
    <div class="ui-table-wrap rounded-none border-0 shadow-none">
        <table class="ui-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Cabang</th>
                    <th class="text-center">Stok</th>
                </tr>
            </thead>
            <tbody data-searchable>
                @forelse($lowStocks as $stock)
                    <tr data-row data-search="{{ strtolower($stock->product->product_name . ' ' . $stock->branch->branch_name) }}">
                        <td class="font-medium text-slate-900 dark:text-white">{{ $stock->product->product_name }}</td>
                        <td>{{ $stock->branch->branch_name }}</td>
                        <td class="text-center">
                            <x-ui.badge variant="{{ $stock->quantity <= 5 ? 'failed' : 'pending' }}">{{ $stock->quantity }}</x-ui.badge>
                        </td>
                    </tr>
                @empty
                    <tr data-row data-search="">
                        <td colspan="3" class="py-10 text-center">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Stok aman</p>
                            <p class="mt-1 text-xs text-slate-500">Tidak ada produk dengan stok menipis saat ini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-ui.card>
