<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-rose-50 via-pink-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-3xl shadow-2xl shadow-rose-500/10 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-5">
                    <div class="hidden md:block md:col-span-2 relative bg-gradient-to-br from-rose-600 via-pink-600 to-purple-600 p-8">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold">J</div>
                                    <div>
                                        <p class="text-white font-semibold">Toko Jayusman</p>
                                        <p class="text-xs text-rose-200/70">ERP Multi Cabang</p>
                                    </div>
                                </div>
                                <div class="mt-12">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/10">
                                        <svg class="w-4 h-4 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        <span class="text-xs text-white/80">Bergabung Sekarang</span>
                                    </div>
                                    <h3 class="mt-6 text-2xl font-bold text-white leading-tight">Mulai Perjalanan Digital Anda</h3>
                                    <ul class="mt-6 space-y-3">
                                        <li class="flex items-center gap-3 text-sm text-rose-100/70">
                                            <svg class="w-5 h-5 text-rose-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Akses semua fitur ERP
                                        </li>
                                        <li class="flex items-center gap-3 text-sm text-rose-100/70">
                                            <svg class="w-5 h-5 text-rose-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Pantau multi cabang
                                        </li>
                                        <li class="flex items-center gap-3 text-sm text-rose-100/70">
                                            <svg class="w-5 h-5 text-rose-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Laporan real-time
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-xs text-rose-200/40">&copy; {{ date('Y') }} Sistem Informasi Mini Market</p>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-3 p-8">
                        <div class="md:hidden mb-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-rose-600 to-purple-600 flex items-center justify-center text-white font-bold">J</div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Toko Jayusman</p>
                                    <p class="text-xs text-slate-500">ERP Multi Cabang</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-slate-900">Buat Akun Baru</h2>
                            <p class="mt-1 text-sm text-slate-500">Daftar untuk mulai menggunakan sistem</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            <div class="space-y-1.5">
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sm font-medium text-slate-700"/>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <x-text-input id="name" 
                                        class="block w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-2xl bg-slate-50/50 focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all duration-300"
                                        type="text" 
                                        name="name" 
                                        :value="old('name')" 
                                        required 
                                        autofocus 
                                        autocomplete="name"
                                        placeholder="John Doe"/>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-sm text-red-600"/>
                            </div>

                            <div class="space-y-1.5">
                                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700"/>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <x-text-input id="email" 
                                        class="block w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-2xl bg-slate-50/50 focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all duration-300"
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autocomplete="username"
                                        placeholder="nama@email.com"/>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-red-600"/>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700"/>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <x-text-input id="password" 
                                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-2xl bg-slate-50/50 focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all duration-300"
                                            type="password" 
                                            name="password" 
                                            required 
                                            autocomplete="new-password"
                                            placeholder="Min. 8 karakter"/>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-red-600"/>
                                </div>

                                <div class="space-y-1.5">
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-sm font-medium text-slate-700"/>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-rose-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </div>
                                        <x-text-input id="password_confirmation" 
                                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-2xl bg-slate-50/50 focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all duration-300"
                                            type="password" 
                                            name="password_confirmation" 
                                            required 
                                            autocomplete="new-password"
                                            placeholder="Konfirmasi"/>
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-sm text-red-600"/>
                                </div>
                            </div>

                            <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-rose-600 via-pink-600 to-purple-600 hover:from-rose-700 hover:via-pink-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-rose-500/30 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-rose-500/25">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                {{ __('Daftar') }}
                            </button>

                            <div class="text-center pt-2">
                                <p class="text-sm text-slate-500">
                                    Sudah punya akun? 
                                    <a href="#" class="font-semibold text-rose-600 hover:text-rose-700 transition-colors duration-200">
                                        Masuk sekarang
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>