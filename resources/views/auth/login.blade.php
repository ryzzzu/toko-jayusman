<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Toko Jayusman</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#f4f1ff] flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl p-3 md:p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 min-h-[540px]">

{{-- BAGIAN KIRI --}}
<div 
    class="hidden md:flex relative overflow-hidden rounded-3xl p-10 text-white"
    style="
        background:
            radial-gradient(circle at 88% 12%, rgba(207, 123, 255, 0.95) 0%, rgba(207, 123, 255, 0.55) 22%, transparent 42%),
            radial-gradient(circle at 72% 48%, rgba(205, 244, 255, 0.95) 0%, rgba(205, 244, 255, 0.75) 20%, transparent 46%),
            radial-gradient(circle at 12% 10%, rgba(151, 230, 255, 0.95) 0%, rgba(88, 178, 255, 0.8) 18%, transparent 40%),
            radial-gradient(circle at 18% 62%, rgba(7, 0, 153, 0.98) 0%, rgba(31, 12, 177, 0.95) 24%, transparent 52%),
            linear-gradient(135deg, #8ee8ff 0%, #4e6df5 28%, #1700a8 48%, #b8eaff 73%, #e7d9ff 100%);
    "
>
    <div class="absolute top-8 left-8 text-7xl font-bold">*</div>

    <div class="relative z-10 flex flex-col justify-end">
        <p class="text-base mb-4">
            Sistem Monitoring
        </p>

        <h1 class="text-3xl font-bold leading-tight">
            Pantau transaksi dan stok barang Toko Jayusman
        </h1>

        <p class="mt-5 text-sm text-white/90 leading-relaxed">
            Kelola transaksi, stok barang, dan laporan seluruh cabang mini market
            secara lebih mudah dalam satu sistem.
        </p>
    </div>
</div>
            {{-- BAGIAN KANAN --}}
            <div class="flex items-center justify-center px-6 md:px-12 py-10">
                <div class="w-full max-w-sm">

                    <div class="mb-6">
                        <div class="text-4xl text-indigo-600 font-bold mb-3">*</div>

                        <h2 class="text-3xl font-bold text-gray-900">
                            Login
                        </h2>

                        <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                            Masuk untuk mengakses dashboard Toko Jayusman.
                        </p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">
                                Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan email"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2.5 text-sm"
                            >

                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">
                                Password
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2.5 text-sm"
                            >

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Remember dan Forgot --}}
                        <div class="flex items-center justify-between mb-5">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                >

                                <span class="ml-2 text-sm text-gray-600">
                                    Ingat saya
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                                >
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        {{-- Tombol Login --}}
                        <button
                            type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-lg shadow-indigo-200 transition duration-200"
                        >
                            Masuk
                        </button>
                    </form>

                    <p class="mt-6 text-center text-xs text-gray-400">
                        © {{ date('Y') }} Sistem Monitoring Toko Jayusman
                    </p>

                </div>
            </div>

        </div>
    </div>

</body>
</html>