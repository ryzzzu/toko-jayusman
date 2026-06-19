<x-app-layout>
    <x-slot name="header">
        <h2>Transaksi Penjualan</h2>
    </x-slot>

    <div style="padding: 20px;">
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        @if($products->isEmpty())
            <p style="color: red;">Tidak ada produk dengan stok tersedia di cabang ini.</p>
        @else
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <h3>Barang 1</h3>
            <div>
                <label>Produk</label><br>
                <select name="product_id[]" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        @php
                            $stockQty = $product->stocks->first()->quantity ?? 0;
                        @endphp
                        <option value="{{ $product->id }}">
                            {{ $product->product_name }} - Stok: {{ $stockQty }} - Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>

            <div>
                <label>Jumlah</label><br>
                <input type="number" name="quantity[]" min="1" required>
            </div>

            <br>

            <h3>Barang 2 Jika Ada</h3>
            <div>
                <label>Produk</label><br>
                <select name="product_id[]">
                    <option value="">Tidak ada</option>
                    @foreach($products as $product)
                        @php
                            $stockQty = $product->stocks->first()->quantity ?? 0;
                        @endphp
                        <option value="{{ $product->id }}">
                            {{ $product->product_name }} - Stok: {{ $stockQty }} - Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>

            <div>
                <label>Jumlah</label><br>
                <input type="number" name="quantity[]" min="1">
            </div>

            <br>

            <div>
                <label>Pembayaran</label><br>
                <input type="number" name="payment" min="0" required>
            </div>

            <br>

            <button type="submit">Simpan Transaksi</button>
        </form>
        @endif
    </div>
</x-app-layout>