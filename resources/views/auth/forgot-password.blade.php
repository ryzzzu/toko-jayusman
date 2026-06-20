<x-guest-layout>
    <div class="min-h-screen bg-slate-100 antialiased flex items-center justify-center p-4">
        <div class="w-full max-w-5xl">
            {{-- Card Container --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-xl shadow-slate-200/50">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    
                    {{-- Left Panel - Brand / Information --}}
                    <div class="relative bg-indigo-600 p-8 md:p-10 flex flex-col justify-between min-h-[400px] md:min-h-[460px]">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
                    
                        <div class="relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 text-sm font-bold text-white backdrop-blur-sm">
                                    J
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">Toko Jayusman</p>
                                    <p class="text-xs text-indigo-200">ERP Multi Cabang</p>
                                </div>
                            </div>

                            <div class="mt-10">
                                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/90 backdrop-blur-sm">
                                    <span class="relative flex h-1.5 w-1.5">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    </span>
                                    Reset Password
                                </div>
                                <h1 class="mt-6 text-3xl font-bold leading-tight text-white">
                                    Reset Password
                                    <span class="block text-indigo-200">Kembali akses akun Anda</span>
                                </h1>
                                <p class="mt-3 text-sm leading-relaxed text-indigo-100/80">
                                    Masukkan email terdaftar Anda untuk mendapatkan link reset password.
                                </p>
                            </div>
                        </div>

                        <div class="relative z-10 mt-8">
                            <div class="flex items-center gap-6 text-xs text-indigo-200/60">
                                <span>&copy; {{ date('Y') }} Toko Jayusman</span>
                                <span class="h-3 w-px bg-indigo-400/20"></span>
                                <span>v2.0</span>
                                <span class="h-3 w-px bg-indigo-400/20"></span>
                                <span>🔒 SSL Secure</span>
                            </div>
                        </div>
                    </div>

                    {{-- Right Panel - Reset Password Form --}}
                    <div class="p-8 md:p-10 flex flex-col justify-center min-h-[400px] md:min-h-[460px]">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-slate-900">Lupa Password?</h2>
                            <p class="mt-1 text-sm text-slate-500">Masukkan email untuk reset password</p>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                            @csrf

                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700"/>
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <x-text-input id="email" 
                                        class="block w-full rounded-lg border-slate-200 pl-10 focus:border-indigo-500 focus:ring-indigo-500"
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autofocus
                                        autocomplete="email"
                                        placeholder="nama@email.com"/>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600"/>
                            </div>

                            <button type="submit" class="flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-200">
                                Kirim Link Reset
                            </button>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                                    ← Kembali ke Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>