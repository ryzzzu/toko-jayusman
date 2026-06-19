@php
    $user = auth()->user();
    $role = $user->role ?? '';
    $roleLabels = [
        'owner' => 'Owner',
        'manager' => 'Manajer',
        'supervisor' => 'Supervisor',
        'cashier' => 'Kasir',
        'warehouse' => 'Gudang',
    ];

    $groups = [
        [
            'label' => 'Utama',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home', 'roles' => ['owner', 'manager', 'supervisor', 'cashier', 'warehouse']],
            ],
        ],
        [
            'label' => 'Master Data',
            'items' => [
                ['label' => 'Cabang', 'route' => 'branches.index', 'icon' => 'building', 'roles' => ['owner']],
                ['label' => 'Kategori', 'route' => 'categories.index', 'icon' => 'tag', 'roles' => ['owner', 'manager']],
                ['label' => 'Produk', 'route' => 'products.index', 'icon' => 'box', 'roles' => ['owner', 'manager']],
            ],
        ],
        [
            'label' => 'Operasional',
            'items' => [
                ['label' => 'Stok', 'route' => 'stocks.index', 'icon' => 'archive', 'roles' => ['owner', 'manager', 'supervisor', 'warehouse']],
                ['label' => 'POS', 'route' => 'transactions.create', 'icon' => 'cart', 'roles' => ['cashier']],
                ['label' => 'Transaksi', 'route' => 'transactions.index', 'icon' => 'receipt', 'roles' => ['owner', 'manager', 'supervisor', 'cashier'], 'active' => ['transactions.index', 'transactions.show']],
                ['label' => 'Barang Masuk', 'route' => 'stock-movements.create', 'query' => ['type' => 'in'], 'icon' => 'arrow-down', 'roles' => ['warehouse'], 'active' => ['stock-movements.create']],
                ['label' => 'Barang Keluar', 'route' => 'stock-movements.create', 'query' => ['type' => 'out'], 'icon' => 'arrow-up', 'roles' => ['warehouse']],
                ['label' => 'Mutasi Stok', 'route' => 'stock-movements.index', 'icon' => 'switch', 'roles' => ['owner', 'manager', 'supervisor', 'warehouse']],
            ],
        ],
        [
            'label' => 'Laporan',
            'items' => [
                ['label' => 'Lap. Transaksi', 'route' => 'reports.transactions', 'icon' => 'chart', 'roles' => ['owner', 'manager'], 'active' => ['reports.transactions']],
                ['label' => 'Lap. Stok', 'route' => 'reports.stocks', 'icon' => 'document', 'roles' => ['owner', 'manager'], 'active' => ['reports.stocks']],
            ],
        ],
    ];

    $isActive = function ($item) {
        foreach ($item['active'] ?? [$item['route']] as $pattern) {
            if (request()->routeIs($pattern)) return true;
        }
        return false;
    };
@endphp

<aside class="fixed inset-y-0 left-0 z-40 flex flex-col border-r border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900"
       :class="[
           sidebarCollapsed ? 'w-[72px]' : 'w-64',
           sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
       ]">

    {{-- Brand --}}
    <div class="flex h-16 items-center border-b border-slate-100 px-4 dark:border-slate-800"
         :class="sidebarCollapsed ? 'justify-center' : 'gap-3'">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 text-sm font-bold text-white shadow-sm">J</div>
        <div x-show="!sidebarCollapsed" x-cloak class="min-w-0">
            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">Toko Jayusman</p>
            <p class="truncate text-[11px] text-slate-500">ERP Multi Cabang</p>
        </div>
    </div>

    {{-- Nav groups --}}
    <nav class="flex-1 overflow-y-auto px-2 py-4">
        @foreach ($groups as $group)
            @php
                $visibleItems = collect($group['items'])->filter(fn ($item) => in_array($role, $item['roles']));
            @endphp
            @if ($visibleItems->isNotEmpty())
                <div class="mb-4">
                    <p x-show="!sidebarCollapsed"
                       class="mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        {{ $group['label'] }}
                    </p>
                    <div class="space-y-0.5">
                        @foreach ($visibleItems as $item)
                            @php
                                $active = $isActive($item);
                                $href = route($item['route']) . (!empty($item['query']) ? '?' . http_build_query($item['query']) : '');
                            @endphp
                            <a href="{{ $href }}"
                               title="{{ $item['label'] }}"
           class="group flex items-center rounded-xl text-sm font-medium
                                      {{ $active
                                          ? 'bg-brand-600 text-white'
                                          : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white' }}"
                               :class="sidebarCollapsed ? 'justify-center p-2.5' : 'gap-3 px-3 py-2.5'">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                                             {{ $active ? 'bg-white/15' : 'bg-slate-100 text-slate-500 group-hover:bg-white dark:bg-slate-800' }}">
                                    @include('layouts.partials.icon', ['name' => $item['icon'], 'active' => $active])
                                </span>
                                <span x-show="!sidebarCollapsed" x-cloak class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </nav>

    {{-- Collapse toggle --}}
    <div class="hidden border-t border-slate-100 p-3 dark:border-slate-800 lg:block">
        <button type="button"
                @click="toggleCollapse()"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-500 transition hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800"
                :class="sidebarCollapsed ? '' : ''">
            <svg class="h-4 w-4 transition duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"/>
            </svg>
            <span x-show="!sidebarCollapsed">Ciutkan</span>
        </button>
    </div>
</aside>

<div class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
     x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" style="display:none;"></div>
