<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Toko Jayusman</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 font-sans antialiased">
    <div class="flex min-h-full lg:min-h-screen">
        {{-- Brand panel --}}
        <div class="relative hidden w-1/2 flex-col justify-between bg-brand-700 p-10 text-white lg:flex xl:p-14">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/15 text-sm font-semibold">J</div>
                <div>
                    <p class="text-sm font-semibold">Toko Jayusman</p>
                    <p class="text-xs text-white/70">ERP Multi Cabang</p>
                </div>
            </div>

            <div class="max-w-md">
                <h1 class="text-3xl font-semibold leading-snug tracking-tight xl:text-4xl">
                    Pantau transaksi & stok seluruh cabang dalam satu sistem.
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-white/75">
                    Monitoring terpusat untuk mini market multi cabang — transaksi, stok, dan laporan.
                </p>
            </div>

            <p class="text-xs text-white/50">&copy; {{ date('Y') }} Sistem Informasi Mini Market</p>
        </div>

        {{-- Form panel --}}
        <div class="flex w-full flex-1 items-center justify-center bg-white px-6 py-10 sm:px-10 lg:w-1/2 lg:px-16">
            <div class="w-full max-w-sm">
                <div class="mb-8 lg:hidden">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-lg bg-brand-600 text-sm font-semibold text-white">J</div>
                    <p class="text-lg font-semibold text-slate-900">Toko Jayusman</p>
                </div>

                <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Masuk ke akun</h2>
                <p class="mt-1.5 text-sm text-slate-500">Gunakan kredensial yang diberikan administrator.</p>

                <x-auth-session-status class="mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5" data-no-transition data-no-loading>
                    @csrf

                    <x-ui.input
                        id="email"
                        type="email"
                        name="email"
                        label="Email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                    />

                    <x-ui.input
                        id="password"
                        type="password"
                        name="password"
                        label="Password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            Ingat saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">Lupa password?</a>
                        @endif
                    </div>

                    <x-ui.button type="submit" variant="primary" class="w-full !py-2.5" loading-text="Masuk...">
                        Masuk
                    </x-ui.button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
