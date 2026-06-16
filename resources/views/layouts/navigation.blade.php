<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    @php
        $user = auth()->user();
        $role = $user->role ?? '';
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            {{-- LEFT SIDE --}}
            <div class="flex items-center gap-8">

                {{-- LOGO --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-700 via-blue-700 to-sky-400 flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-xl">J</span>
                    </div>

                    <div class="hidden md:block">
                        <h1 class="text-lg font-bold text-gray-900 leading-tight">
                            Toko Jayusman
                        </h1>
                        <p class="text-xs text-gray-500">
                            Monitoring Transaksi & Stok
                        </p>
                    </div>
                </a>

                {{-- DESKTOP MENU --}}
                <div class="hidden lg:flex items-center gap-2">

                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition
                       {{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>

                    @if($role === 'owner')
                        <a href="{{ route('branches.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('branches.*') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Cabang
                        </a>
                    @endif

                    @if(in_array($role, ['owner', 'manager']))
                        <a href="{{ route('categories.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('categories.*') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Kategori
                        </a>

                        <a href="{{ route('products.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('products.*') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Produk
                        </a>
                    @endif

                    @if(in_array($role, ['owner', 'manager', 'supervisor', 'warehouse']))
                        <a href="{{ route('stocks.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('stocks.*') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Stok
                        </a>
                    @endif

                    @if($role === 'cashier')
                        <a href="{{ route('transactions.create') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('transactions.create') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Transaksi Baru
                        </a>
                    @endif

                    @if(in_array($role, ['owner', 'manager', 'supervisor', 'cashier']))
                        <a href="{{ route('transactions.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('transactions.index') || request()->routeIs('transactions.show') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Transaksi
                        </a>
                    @endif

                    @if($role === 'warehouse')
                        <a href="{{ route('stock-movements.create') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('stock-movements.create') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Input Stok
                        </a>
                    @endif

                    @if(in_array($role, ['owner', 'manager', 'supervisor', 'warehouse']))
                        <a href="{{ route('stock-movements.index') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('stock-movements.index') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Mutasi Stok
                        </a>
                    @endif

                    @if(in_array($role, ['owner', 'manager']))
                        <a href="{{ route('reports.transactions') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition
                           {{ request()->routeIs('reports.transactions') ? 'bg-indigo-700 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Laporan
                        </a>
                    @endif
                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="hidden lg:flex items-center gap-4">

                {{-- ROLE BADGE --}}
                <div class="px-4 py-2 rounded-xl bg-gray-100">
                    <p class="text-xs text-gray-500 leading-none">Role</p>
                    <p class="text-sm font-bold text-gray-800 uppercase mt-1">
                        {{ $role }}
                    </p>
                </div>

                {{-- USER DROPDOWN --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                            <div class="w-10 h-10 rounded-full bg-indigo-700 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $user->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $user->email }}
                                </p>
                            </div>

                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Route::has('profile.edit'))
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil Akun
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- MOBILE BUTTON --}}
            <div class="flex items-center lg:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-gray-200 bg-white">
        <div class="px-4 pt-3 pb-4 space-y-2">

            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Dashboard
            </a>

            @if($role === 'owner')
                <a href="{{ route('branches.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('branches.*') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Cabang
                </a>
            @endif

            @if(in_array($role, ['owner', 'manager']))
                <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('categories.*') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Kategori
                </a>

                <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('products.*') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Produk
                </a>
            @endif

            @if(in_array($role, ['owner', 'manager', 'supervisor', 'warehouse']))
                <a href="{{ route('stocks.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('stocks.*') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Stok
                </a>
            @endif

            @if($role === 'cashier')
                <a href="{{ route('transactions.create') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('transactions.create') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Transaksi Baru
                </a>
            @endif

            @if(in_array($role, ['owner', 'manager', 'supervisor', 'cashier']))
                <a href="{{ route('transactions.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('transactions.*') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Transaksi
                </a>
            @endif

            @if($role === 'warehouse')
                <a href="{{ route('stock-movements.create') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('stock-movements.create') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Input Stok
                </a>
            @endif

            @if(in_array($role, ['owner', 'manager', 'supervisor', 'warehouse']))
                <a href="{{ route('stock-movements.index') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('stock-movements.index') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Mutasi Stok
                </a>
            @endif

            @if(in_array($role, ['owner', 'manager']))
                <a href="{{ route('reports.transactions') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold {{ request()->routeIs('reports.*') ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Laporan
                </a>
            @endif
        </div>

        <div class="px-4 py-4 border-t border-gray-200">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-indigo-700 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-3 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>