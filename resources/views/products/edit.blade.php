<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Edit Produk</h1>
    </x-slot>

    <x-ui.card class="max-w-2xl">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <x-ui.select name="category_id" label="Kategori" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->category_name }}</option>
                @endforeach
            </x-ui.select>
            <x-ui.input name="product_name" label="Nama Produk" value="{{ old('product_name', $product->product_name) }}" required />
            <x-ui.input name="barcode" label="Barcode" value="{{ old('barcode', $product->barcode) }}" />
            <div class="grid gap-5 sm:grid-cols-2">
                <x-ui.input type="number" name="purchase_price" label="Harga Beli" value="{{ old('purchase_price', $product->purchase_price) }}" min="0" required />
                <x-ui.input type="number" name="selling_price" label="Harga Jual" value="{{ old('selling_price', $product->selling_price) }}" min="0" required />
            </div>
            <x-ui.input name="unit" label="Satuan" value="{{ old('unit', $product->unit) }}" required />
            <div class="flex gap-3">
                <x-ui.button type="submit" variant="primary" loading-text="Memperbarui...">Update</x-ui.button>
                <x-ui.button href="{{ route('products.index') }}" variant="secondary">Batal</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
