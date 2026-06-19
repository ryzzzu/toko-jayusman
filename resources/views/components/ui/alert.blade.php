@props(['type' => 'info'])

@php
    $types = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-300',
        'error' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-900 dark:bg-red-950/50 dark:text-red-300',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900 dark:bg-amber-950/50 dark:text-amber-300',
        'info' => 'border-brand-200 bg-brand-50 text-brand-800 dark:border-brand-900 dark:bg-brand-950/50 dark:text-brand-300',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900 dark:bg-amber-950/50 dark:text-amber-300',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'mb-6 rounded-2xl border px-4 py-3 text-sm font-medium ' . ($types[$type] ?? $types['info'])]) }}>
    {{ $slot }}
</div>
