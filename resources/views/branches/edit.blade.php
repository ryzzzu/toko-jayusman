<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-slate-900 dark:text-white">Edit Cabang</h1>
    </x-slot>

    <x-ui.card class="max-w-2xl">
        <form action="{{ route('branches.update', $branch->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <x-ui.input name="branch_name" label="Nama Cabang" value="{{ old('branch_name', $branch->branch_name) }}" required />
            <x-ui.input name="city" label="Kota" value="{{ old('city', $branch->city) }}" required />
            <x-ui.textarea name="address" label="Alamat" rows="3">{{ old('address', $branch->address) }}</x-ui.textarea>
            <div class="flex gap-3">
                <x-ui.button type="submit" variant="primary" loading-text="Memperbarui...">Update</x-ui.button>
                <x-ui.button href="{{ route('branches.index') }}" variant="secondary">Batal</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</x-app-layout>
