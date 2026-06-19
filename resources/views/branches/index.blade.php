<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Data Cabang
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Kelola seluruh cabang mini market Toko Jayusman.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            Daftar Cabang
                        </h3>
                        <p class="text-sm text-gray-500">
                            Data cabang yang terdaftar di sistem.
                        </p>
                    </div>

                    <a href="{{ route('branches.create') }}"
                       class="px-5 py-2.5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-xl text-sm font-semibold">
                        + Tambah Cabang
                    </a>
                </div>

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-4 text-left">No</th>
                            <th class="px-5 py-4 text-left">Nama Cabang</th>
                            <th class="px-5 py-4 text-left">Kota</th>
                            <th class="px-5 py-4 text-left">Alamat</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($branches as $branch)
                            <tr>
                                <td class="px-5 py-4">{{ $loop->iteration }}</td>

                                <td class="px-5 py-4 font-semibold text-gray-900">
                                    {{ $branch->branch_name }}
                                </td>

                                <td class="px-5 py-4">
                                    {{ $branch->city }}
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    {{ $branch->address ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('branches.edit', $branch->id) }}"
                                       class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg font-semibold">
                                        Edit
                                    </a>

                                    <form action="{{ route('branches.destroy', $branch->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg font-semibold ml-2">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                    Belum ada data cabang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>