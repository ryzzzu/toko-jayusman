@props(['lowStocks' => null])

@php
    $lowStocks = $lowStocks ?? collect();
@endphp

<x-dashboard.panel title="Stok Hampir Habis" description="Produk dengan stok ≤ 10 unit" {{ $attributes }}>
    <x-slot:action>
        @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'warehouse']))
            <x-ui.button href="{{ route('stocks.index') }}" variant="ghost">Kelola Stok</x-ui.button>
        @endif
    </x-slot:action>

    <div class="ui-table-wrap rounded-none border-0 shadow-none">
        <table class="ui-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Cabang</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody data-searchable>
                @forelse($lowStocks as $stock)
                    <tr data-row data-search="{{ strtolower($stock->product->product_name . ' ' . $stock->branch->branch_name) }}">
                        <td class="font-medium text-slate-900 dark:text-white">{{ $stock->product->product_name }}</td>
                        <td>{{ $stock->branch->branch_name }}</td>
                        <td class="text-center font-semibold">{{ $stock->quantity }}</td>
                        <td class="text-center">
                            <x-ui.badge variant="{{ $stock->quantity <= 5 ? 'failed' : 'pending' }}">
                                {{ $stock->quantity <= 5 ? 'Kritis' : 'Menipis' }}
                            </x-ui.badge>
                        </td>
                    </tr>
                @empty
                    <x-ui.table-empty colspan="4" title="Stok aman" description="Tidak ada produk dengan stok menipis saat ini." data-row data-search="" />
                @endforelse
            </tbody>
        </table>
    </div>
</x-dashboard.panel>
