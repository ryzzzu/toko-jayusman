<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Edit Kategori</h1>
    </x-slot>

    <x-ui.card class="max-w-xl">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <x-ui.input name="category_name" label="Nama Kategori" value="{{ old('category_name', $category->category_name) }}" required />
            <div class="flex gap-3">
                <x-ui.button type="submit" variant="primary" loading-text="Memperbarui...">Update</x-ui.button>
                <x-ui.button href="{{ route('categories.index') }}" variant="secondary">Batal</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
