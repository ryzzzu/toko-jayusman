<x-app-layout>
    <x-slot name="header">
        <h2>Laporan Stok Barang</h2>
    </x-slot>

    <div style="padding: 20px;">
        <form method="GET" action="{{ route('reports.stocks') }}">
            @if(auth()->user()->role === 'owner')
                <label>Cabang</label>
                <select name="branch_id">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->branch_name }}
                        </option>
                    @endforeach
                </select>
            @endif

            <button type="submit">Filter</button>
            <button type="button" onclick="window.print()">Cetak</button>
        </form>

        <br>

        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Cabang</th>
                <th>Kategori</th>
                <th>Produk</th>
                <th>Stok</th>
            </tr>

            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->branch->branch_name }}</td>
                    <td>{{ $stock->product->category->category_name }}</td>
                    <td>{{ $stock->product->product_name }}</td>
                    <td>{{ $stock->quantity }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>