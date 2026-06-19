<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Data Cabang</h1>
                <p class="text-sm text-slate-500">Kelola seluruh cabang mini market Toko Jayusman</p>
            </div>
            <x-ui.button href="{{ route('branches.create') }}" variant="primary">+ Tambah Cabang</x-ui.button>
        </div>
    </x-slot>

    <x-ui.card :padding="false">
        <x-slot:header>
            <h3 class="font-semibold text-slate-900 dark:text-white">Daftar Cabang</h3>
            <p class="text-sm text-slate-500">Data cabang yang terdaftar di sistem</p>
        </x-slot:header>
        <div class="ui-table-wrap rounded-none border-0 shadow-none">
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Cabang</th>
                        <th>Kota</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody data-searchable>
                    @forelse($branches as $branch)
                        <tr data-row data-search="{{ strtolower($branch->branch_name . ' ' . $branch->city . ' ' . ($branch->address ?? '')) }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $branch->branch_name }}</td>
                            <td>{{ $branch->city }}</td>
                            <td>{{ $branch->address ?? '-' }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <x-ui.button href="{{ route('branches.edit', $branch->id) }}" variant="secondary">Edit</x-ui.button>
                                    <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                                        @csrf @method('DELETE')
                                        <x-ui.button type="submit" variant="danger" loading-text="Menghapus...">Hapus</x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-8 text-center text-slate-500">Belum ada data cabang</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
