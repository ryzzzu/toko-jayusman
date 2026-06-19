@props(['type' => 'info'])

@php
    $types = [
        'success' => 'border-accent-200 bg-accent-50 text-accent-800 dark:border-accent-900 dark:bg-accent-950/50 dark:text-accent-300',
        'error' => 'border-red-200 bg-red-50 text-red-800 dark:border-red-900 dark:bg-red-950/50 dark:text-red-300',
        'warning' => 'border-brand-200 bg-brand-50 text-brand-800 dark:border-brand-800 dark:bg-brand-950/50 dark:text-brand-300',
        'info' => 'border-brand-200 bg-brand-50 text-brand-800 dark:border-brand-900 dark:bg-brand-950/50 dark:text-brand-300',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'mb-5 rounded-lg border px-4 py-3 text-sm ' . ($types[$type] ?? $types['info'])]) }}>
    {{ $slot }}
</div>
