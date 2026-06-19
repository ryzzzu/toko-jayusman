<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Input Mutasi Stok</h1>
            <p class="text-sm text-slate-500">Barang masuk, keluar, atau penyesuaian stok</p>
        </div>
    </x-slot>

    <x-ui.card class="max-w-2xl">
        <form action="{{ route('stock-movements.store') }}" method="POST" class="space-y-5" x-data="{ type: '{{ old('type', request('type', 'in')) }}' }">
            @csrf

            <x-ui.select name="product_id" label="Produk" required>
                <option value="">Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->product_name }}</option>
                @endforeach
            </x-ui.select>

            <x-ui.select name="type" label="Jenis Mutasi" required x-model="type">
                <option value="in">Barang Masuk</option>
                <option value="out">Barang Keluar</option>
                <option value="adjustment">Penyesuaian Stok</option>
            </x-ui.select>

            <x-ui.input type="number" name="quantity" label="Jumlah" min="0" value="{{ old('quantity') }}" required x-bind:min="type === 'adjustment' ? 0 : 1" />

            <x-ui.textarea name="description" label="Keterangan" rows="3">{{ old('description') }}</x-ui.textarea>

            <div class="flex gap-3">
                <x-ui.button type="submit" variant="primary" loading-text="Menyimpan...">Simpan</x-ui.button>
                <x-ui.button href="{{ route('stock-movements.index') }}" variant="secondary">Batal</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
