@props(['variant' => 'gray'])

@php
    $variants = [
        'active' => 'bg-accent-50 text-accent-700 ring-1 ring-inset ring-accent-600/20 dark:bg-accent-950/40 dark:text-accent-300',
        'pending' => 'bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-600/20 dark:bg-brand-950/40 dark:text-brand-300',
        'inactive' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-500/10 dark:bg-slate-800 dark:text-slate-400',
        'failed' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20 dark:bg-red-950/40 dark:text-red-300',
        'brand' => 'bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-600/20 dark:bg-brand-950/40 dark:text-brand-300',
        'gray' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-500/10 dark:bg-slate-800 dark:text-slate-400',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ' . ($variants[$variant] ?? $variants['gray'])]) }}>
    {{ $slot }}
</span>
