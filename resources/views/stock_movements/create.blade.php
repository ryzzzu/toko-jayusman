<x-app-layout>
    <x-slot name="header">
        <h2>Input Barang Masuk/Keluar</h2>
    </x-slot>

    <div style="padding: 20px;">
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form action="{{ route('stock-movements.store') }}" method="POST">
            @csrf

            <div>
                <label>Produk</label><br>
                <select name="product_id" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <br>

            <div>
                <label>Jenis</label><br>
                <select name="type" required>
                    <option value="in">Barang Masuk</option>
                    <option value="out">Barang Keluar</option>
                    <option value="adjustment">Penyesuaian Stok</option>
                </select>
            </div>

            <br>

            <div>
                <label>Jumlah</label><br>
                <input type="number" name="quantity" min="1" required>
            </div>

            <br>

            <div>
                <label>Keterangan</label><br>
                <textarea name="description"></textarea>
            </div>

            <br>

            <button type="submit">Simpan</button>
        </form>
    </div>
</x-app-layout>