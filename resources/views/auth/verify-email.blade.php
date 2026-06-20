<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 shadow-2xl shadow-cyan-500/30">
                    <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-slate-900 tracking-tight">Verifikasi Email</h2>
                <p class="mt-2 text-sm text-slate-600 max-w-sm mx-auto">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-cyan-500/10 p-8 border border-white/50">
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <svg class="h-6 w-6 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-emerald-700">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        </div>
                    </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-cyan-500/30 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl hover:shadow-cyan-500/25">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('Kirim Ulang Email Verifikasi') }}
                        </button>
                    </form>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-slate-500">atau</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border-2 border-slate-200 rounded-2xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:border-slate-300 focus:outline-none focus:ring-4 focus:ring-slate-200 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Keluar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>