<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Toko Jayusman</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-950 font-sans antialiased">
    <div class="flex min-h-full">
        <div class="relative hidden w-1/2 overflow-hidden lg:flex lg:flex-col lg:justify-between bg-gradient-to-br from-brand-950 via-brand-800 to-indigo-900 p-12 text-white">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 text-lg font-bold backdrop-blur">J</div>
                <div>
                    <p class="font-bold">Toko Jayusman</p>
                    <p class="text-sm text-white/70">ERP Multi Cabang</p>
                </div>
            </div>
            <div>
                <h1 class="max-w-md text-4xl font-bold leading-tight tracking-tight">Pantau transaksi & stok seluruh cabang dalam satu sistem.</h1>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-white/75">Solusi monitoring terpusat untuk mini market multi cabang — transaksi, stok, dan laporan real-time.</p>
            </div>
            <p class="text-xs text-white/50">&copy; {{ date('Y') }} Sistem Informasi Mini Market</p>
        </div>

        <div class="flex w-full flex-col justify-center px-6 py-12 lg:w-1/2 lg:px-16 xl:px-24">
            <div class="mx-auto w-full max-w-md">
                <div class="mb-8 lg:hidden">
                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-600 text-lg font-bold text-white">J</div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Toko Jayusman</h2>
                </div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Masuk ke akun</h2>
                <p class="mt-2 text-sm text-slate-500">Gunakan kredensial yang diberikan administrator.</p>

                <x-auth-session-status class="mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf
                    <x-ui.input id="email" type="email" name="email" label="Email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    <x-ui.input id="password" type="password" name="password" label="Password" required autocomplete="current-password" />

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            Ingat saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">Lupa password?</a>
                        @endif
                    </div>

                    <x-ui.button type="submit" variant="primary" class="w-full" loading-text="Masuk...">Masuk</x-ui.button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
