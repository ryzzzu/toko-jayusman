<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-semibold text-slate-900 dark:text-white">POS / Transaksi Penjualan</h1>
            <p class="text-sm text-slate-500">Input transaksi penjualan barang</p>
        </div>
    </x-slot>

    @if($products->isEmpty())
        <x-ui.empty-state title="Tidak ada produk tersedia" description="Stok produk di cabang ini kosong. Hubungi pegawai gudang.">
            <x-slot:action>
                <x-ui.button href="{{ route('dashboard') }}" variant="secondary">Kembali ke Dashboard</x-ui.button>
            </x-slot:action>
        </x-ui.empty-state>
    @else
        <x-ui.card class="max-w-3xl">
            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-4 rounded-2xl border border-slate-200 p-4 dark:border-slate-700">
                        <h3 class="font-semibold text-slate-900 dark:text-white">Barang 1</h3>
                        <x-ui.select name="product_id[]" label="Produk" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                @php $stockQty = $product->stocks->first()->quantity ?? 0; @endphp
                                <option value="{{ $product->id }}">{{ $product->product_name }} — Stok: {{ $stockQty }} — Rp {{ number_format($product->selling_price, 0, ',', '.') }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input type="number" name="quantity[]" label="Jumlah" min="1" required />
                    </div>

                    <div class="space-y-4 rounded-2xl border border-dashed border-slate-200 p-4 dark:border-slate-700">
                        <h3 class="font-semibold text-slate-900 dark:text-white">Barang 2 <span class="text-sm font-normal text-slate-400">(opsional)</span></h3>
                        <x-ui.select name="product_id[]" label="Produk">
                            <option value="">Tidak ada</option>
                            @foreach($products as $product)
                                @php $stockQty = $product->stocks->first()->quantity ?? 0; @endphp
                                <option value="{{ $product->id }}">{{ $product->product_name }} — Stok: {{ $stockQty }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.input type="number" name="quantity[]" label="Jumlah" min="1" />
                    </div>
                </div>

                <x-ui.input type="number" name="payment" label="Nominal Pembayaran (Rp)" min="0" required />

                <div class="flex gap-3">
                    <x-ui.button type="submit" variant="primary" loading-text="Memproses...">Simpan Transaksi</x-ui.button>
                    <x-ui.button href="{{ route('transactions.index') }}" variant="secondary">Batal</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    @endif
</x-app-layout>
