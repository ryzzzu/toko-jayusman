<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 dark:text-white">Data Kategori</h1>
                <p class="mt-0.5 text-sm text-slate-500">Kelola kategori barang</p>
            </div>
            <x-ui.button href="{{ route('categories.create') }}" variant="primary">Tambah Kategori</x-ui.button>
        </div>
    </x-slot>

    <x-ui.card :padding="false">
        <x-slot:header>
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Daftar Kategori</h3>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead><tr><th>No</th><th>Nama Kategori</th><th class="text-center">Aksi</th></tr></thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $category->category_name }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <x-ui.button href="{{ route('categories.edit', $category->id) }}" variant="secondary">Edit</x-ui.button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <x-ui.button type="submit" variant="danger" loading-text="Menghapus...">Hapus</x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-8 text-center text-slate-500">Belum ada data kategori</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
