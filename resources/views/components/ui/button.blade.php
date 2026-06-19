@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'loadingText' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';

    $variants = [
        'primary' => 'bg-brand-600 text-white hover:bg-brand-700 focus:ring-brand-500',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 focus:ring-slate-400 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800',
        'success' => 'bg-accent-600 text-white shadow-sm hover:bg-accent-700 focus:ring-accent-500',
        'warning' => 'border border-brand-300 bg-brand-50 text-brand-800 shadow-sm hover:bg-brand-100 focus:ring-brand-400 dark:border-brand-700 dark:bg-brand-950/40 dark:text-brand-300',
        'danger' => 'bg-red-600 text-white shadow-sm hover:bg-red-700 focus:ring-red-500',
        'ghost' => 'text-slate-600 hover:bg-slate-100 focus:ring-slate-400 dark:text-slate-300 dark:hover:bg-slate-800',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($loading) @if($loadingText) data-loading-text="{{ $loadingText }}" @endif>
        @if ($loading)
            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
        @endif
        {{ $slot }}
    </button>
@endif
