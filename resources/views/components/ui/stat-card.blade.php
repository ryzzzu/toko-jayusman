@props(['label', 'value', 'icon' => null, 'trend' => null, 'tone' => 'slate'])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900']) }}>
    <p class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $label }}</p>
    <p class="mt-1.5 text-2xl font-semibold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ $value }}</p>
    @if ($trend)
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $trend }}</p>
    @endif
</div>
