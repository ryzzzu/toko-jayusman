<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Toko Jayusman') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased"
      x-data="{
            sidebarOpen: false,
            sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            globalSearch: '',
            toggleCollapse() {
                this.sidebarCollapsed = !this.sidebarCollapsed;
                localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
            },
            dispatchSearch() {
                window.dispatchEvent(new CustomEvent('global-search', { detail: this.globalSearch.toLowerCase() }));
            }
         }"
      x-init="$watch('globalSearch', () => dispatchSearch())">

    @include('layouts.partials.sidebar')

    <div class="min-h-full app-shell"
         :class="sidebarCollapsed ? 'lg:pl-[72px]' : 'lg:pl-64'">

        @include('layouts.partials.topbar')

        <main class="px-4 py-6 lg:px-8 lg:py-8">
            @include('layouts.partials.page-header')

            <x-ui.flash />

            {{ $slot }}
        </main>

        @include('layouts.partials.footer')
    </div>
</body>
</html>
