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
                <br><br>
            @endif

            <label>Tanggal Awal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}">
            <br><br>

            <label>Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}">
            <br><br>

            <button type="submit">Filter</button>
            <button type="button" onclick="window.print()">Cetak</button>
        </form>

        <br>

        @if($reportMode === 'movements')
            <p><strong>Mutasi stok periode {{ request('start_date') }} s/d {{ request('end_date') }}</strong></p>

            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Tanggal</th>
                    <th>Cabang</th>
                    <th>Produk</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                </tr>

                @forelse($movements as $movement)
                    <tr>
                        <td>{{ $movement->movement_date }}</td>
                        <td>{{ $movement->branch->branch_name }}</td>
                        <td>{{ $movement->product->product_name }}</td>
                        <td>{{ $movement->type }}</td>
                        <td>{{ $movement->quantity }}</td>
                        <td>{{ $movement->user->name ?? '-' }}</td>
                        <td>{{ $movement->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Tidak ada mutasi stok pada periode ini.</td>
                    </tr>
                @endforelse
            </table>
        @else
            <p><strong>Posisi stok saat ini</strong> (isi tanggal awal & akhir untuk laporan mutasi per periode)</p>

            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Cabang</th>
                    <th>Kategori</th>
                    <th>Produk</th>
                    <th>Stok</th>
                </tr>

                @forelse($stocks as $stock)
                    <tr>
                        <td>{{ $stock->branch->branch_name }}</td>
                        <td>{{ $stock->product->category->category_name }}</td>
                        <td>{{ $stock->product->product_name }}</td>
                        <td>{{ $stock->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data stok.</td>
                    </tr>
                @endforelse
            </table>
        @endif
    </div>
</x-app-layout>
