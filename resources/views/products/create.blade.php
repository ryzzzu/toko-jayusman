<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Tambah Produk</h1>
    </x-slot>

    <x-ui.card class="max-w-2xl">
        <form action="{{ route('products.store') }}" method="POST" class="space-y-5">
            @csrf
            <x-ui.select name="category_id" label="Kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->category_name }}</option>
                @endforeach
            </x-ui.select>
            <x-ui.input name="product_name" label="Nama Produk" value="{{ old('product_name') }}" required />
            <x-ui.input name="barcode" label="Barcode" value="{{ old('barcode') }}" />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-ui.input type="number" name="purchase_price" label="Harga Beli" value="{{ old('purchase_price', 0) }}" min="0" required />
                <x-ui.input type="number" name="selling_price" label="Harga Jual" value="{{ old('selling_price', 0) }}" min="0" required />
            </div>
            <x-ui.input name="unit" label="Satuan" value="{{ old('unit', 'pcs') }}" required />
            <div class="flex gap-3">
                <x-ui.button type="submit" variant="primary" loading-text="Menyimpan...">Simpan</x-ui.button>
                <x-ui.button href="{{ route('products.index') }}" variant="secondary">Batal</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
