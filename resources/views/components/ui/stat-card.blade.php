@props(['label', 'value', 'icon' => null, 'trend' => null, 'tone' => 'brand'])

@php
    $tones = [
        'brand' => ['border' => 'border-l-brand-500', 'icon' => 'bg-brand-50 text-brand-600 dark:bg-brand-950/50 dark:text-brand-400'],
        'emerald' => ['border' => 'border-l-accent-500', 'icon' => 'bg-accent-50 text-accent-600 dark:bg-accent-950/50 dark:text-accent-400'],
        'amber' => ['border' => 'border-l-amber-500', 'icon' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-400'],
        'violet' => ['border' => 'border-l-violet-500', 'icon' => 'bg-violet-50 text-violet-600 dark:bg-violet-950/50 dark:text-violet-400'],
        'rose' => ['border' => 'border-l-rose-500', 'icon' => 'bg-rose-50 text-rose-600 dark:bg-rose-950/50 dark:text-rose-400'],
        'slate' => ['border' => 'border-l-slate-500', 'icon' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'],
    ];
    $t = $tones[$tone] ?? $tones['brand'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200/80 border-l-4 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 ' . $t['border']]) }}>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
            <p class="mt-2 truncate text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $value }}</p>
            @if ($trend)
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $trend }}</p>
            @endif
        </div>
        @if ($icon)
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $t['icon'] }}">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
