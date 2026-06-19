@props([
    'label',
    'value',
    'tone' => 'slate',
    'compare' => null,
    'delta' => null,
    'deltaDirection' => 'up',
    'footnote' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900']) }}>
    <p class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $label }}</p>
    <p class="mt-1.5 text-2xl font-semibold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ $value }}</p>
    @if($compare !== null && $compare !== '')
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $compare }}</p>
    @elseif($delta !== null && $delta !== '')
        <p @class(['mt-1 flex items-center gap-1 text-xs font-medium', $deltaDirection === 'down' ? 'text-red-600' : 'text-accent-600'])>{{ $delta }}</p>
    @endif
    @if($footnote)
        <p class="mt-1 text-xs text-slate-400">{{ $footnote }}</p>
    @endif
</div>
