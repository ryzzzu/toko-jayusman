<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori
                        </label>

                        <select name="category_id"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk
                        </label>

                        <input type="text"
                               name="product_name"
                               value="{{ old('product_name', $product->product_name) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('product_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Barcode
                        </label>

                        <input type="text"
                               name="barcode"
                               value="{{ old('barcode', $product->barcode) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('barcode')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Beli
                            </label>

                            <input type="number"
                                   name="purchase_price"
                                   value="{{ old('purchase_price', $product->purchase_price) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   required>

                            @error('purchase_price')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga Jual
                            </label>

                            <input type="number"
                                   name="selling_price"
                                   value="{{ old('selling_price', $product->selling_price) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                   required>

                            @error('selling_price')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan
                        </label>

                        <input type="text"
                               name="unit"
                               value="{{ old('unit', $product->unit) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('unit')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('products.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded">
                            Kembali
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
