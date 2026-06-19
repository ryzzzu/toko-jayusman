@php
    $user = auth()->user();
    $role = $user->role ?? '';

    $roleMeta = [
        'owner' => ['label' => 'Owner', 'accent' => 'bg-brand-600', 'badge' => 'bg-brand-50 text-brand-700 ring-brand-600/20 dark:bg-brand-950/40 dark:text-brand-300'],
        'manager' => ['label' => 'Manajer Toko', 'accent' => 'bg-accent-600', 'badge' => 'bg-accent-50 text-accent-700 ring-accent-600/20 dark:bg-accent-950/40 dark:text-accent-300'],
        'supervisor' => ['label' => 'Supervisor', 'accent' => 'bg-brand-500', 'badge' => 'bg-brand-50 text-brand-700 ring-brand-600/20 dark:bg-brand-950/40 dark:text-brand-300'],
        'cashier' => ['label' => 'Kasir', 'accent' => 'bg-accent-500', 'badge' => 'bg-accent-50 text-accent-700 ring-accent-600/20 dark:bg-accent-950/40 dark:text-accent-300'],
        'warehouse' => ['label' => 'Pegawai Gudang', 'accent' => 'bg-brand-700', 'badge' => 'bg-slate-100 text-slate-700 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-300'],
    ];

    $meta = $roleMeta[$role] ?? ['label' => ucfirst($role), 'accent' => 'bg-slate-600', 'badge' => 'bg-slate-100 text-slate-700 ring-slate-600/20'];
    $lowStockCount = isset($lowStocks) ? $lowStocks->count() : 0;
@endphp

<header class="sticky top-0 z-20 border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
    <div class="flex h-14 items-center gap-2 px-3 sm:gap-3 sm:px-4 lg:px-8">
        <button type="button"
                class="inline-flex shrink-0 items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50 lg:hidden dark:border-slate-700 dark:hover:bg-slate-800"
                @click="sidebarOpen = true">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        </button>

        <div class="hidden min-w-0 shrink-0 md:block lg:max-w-[11rem] xl:max-w-xs">
            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ config('app.name', 'Toko Jayusman') }}</p>
            <p class="truncate text-[11px] text-slate-500">Mini Market Multi Cabang</p>
        </div>

        <div class="relative min-w-0 flex-1">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="search"
                   x-model="globalSearch"
                   placeholder="Cari data di halaman ini..."
                   class="w-full rounded-lg border-slate-200 bg-slate-50 py-2 pl-10 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
        </div>

        @if($role === 'cashier')
            <x-ui.button href="{{ route('transactions.create') }}" variant="primary" class="hidden shrink-0 sm:inline-flex">
                + POS
            </x-ui.button>
        @endif

        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
            <div class="hidden items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 lg:flex dark:border-slate-700 dark:bg-slate-800"
                 x-data="{ timeLabel:'', init(){ this.tick(); setInterval(()=>this.tick(),1000); }, tick(){ this.timeLabel=new Date().toLocaleTimeString('id-ID',{timeZone:'Asia/Jakarta',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false}); } }">
                <span class="font-mono text-[11px] font-semibold tabular-nums text-slate-800 dark:text-white" x-text="timeLabel"></span>
                <span class="text-[9px] font-bold uppercase text-brand-600">WIB</span>
            </div>

            <x-dropdown align="right" width="72" contentClasses="py-2 bg-white dark:bg-slate-900">
                <x-slot name="trigger">
                    <button type="button" class="relative rounded-lg border border-slate-200 p-2 text-slate-500 hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        @if($lowStockCount > 0)
                            <span class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white">{{ min($lowStockCount, 9) }}{{ $lowStockCount > 9 ? '+' : '' }}</span>
                        @endif
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Notifikasi</p>
                    </div>
                    @if($lowStockCount > 0)
                        <a href="{{ route('stocks.index') }}" class="flex gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-xs font-bold text-red-600">!</span>
                            <span>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $lowStockCount }} produk stok menipis</p>
                                <p class="text-xs text-slate-500">Perlu restock segera</p>
                            </span>
                        </a>
                    @else
                        <p class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada notifikasi baru</p>
                    @endif
                </x-slot>
            </x-dropdown>

            <x-dropdown align="right" width="64" contentClasses="py-2 bg-white dark:bg-slate-900">
                <x-slot name="trigger">
                    <button type="button" class="flex items-center gap-2 rounded-lg border border-slate-200 p-1 pr-2 hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800 sm:pr-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-700 dark:bg-slate-700 dark:text-slate-200">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <span class="hidden max-w-[88px] truncate text-xs font-semibold text-slate-800 dark:text-white lg:block">{{ $user->name }}</span>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
                        <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $user->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                        <span class="mt-1.5 inline-flex rounded-md px-2 py-0.5 text-[10px] font-bold uppercase ring-1 ring-inset {{ $meta['badge'] }}">{{ $meta['label'] }}</span>
                    </div>
                    @if (Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800">Profil Akun</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" data-no-loading data-no-transition>@csrf
                        <button type="submit" class="block w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30">Keluar</button>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <div class="flex items-center justify-between gap-3 border-t border-slate-100 px-3 py-2 sm:px-4 lg:px-8 dark:border-slate-800">
        <div class="min-w-0 flex-1">
            @include('layouts.partials.breadcrumb')
        </div>
        <div class="hidden shrink-0 items-center gap-2 sm:flex">
            <span class="inline-flex rounded-md px-2 py-0.5 text-[10px] font-bold uppercase ring-1 ring-inset {{ $meta['badge'] }}">{{ $meta['label'] }}</span>
            @if($user->branch)
                <span class="inline-flex max-w-[140px] truncate rounded-md bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300" title="{{ $user->branch->branch_name }}">
                    {{ $user->branch->branch_name }}
                </span>
            @endif
        </div>
    </div>
</header>
