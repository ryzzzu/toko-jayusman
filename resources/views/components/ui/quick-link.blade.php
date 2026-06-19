@props(['href', 'label', 'description' => null, 'category' => null, 'icon' => null, 'tone' => 'brand'])

@php
    $tones = [
        'brand' => ['box' => 'bg-brand-600', 'hover' => 'hover:border-brand-200 hover:bg-brand-50/50 dark:hover:border-brand-800 dark:hover:bg-brand-950/20'],
        'accent' => ['box' => 'bg-accent-600', 'hover' => 'hover:border-accent-200 hover:bg-accent-50/50 dark:hover:border-accent-800 dark:hover:bg-accent-950/20'],
        'slate' => ['box' => 'bg-slate-600', 'hover' => 'hover:border-slate-300 hover:bg-slate-50 dark:hover:border-slate-600'],
    ];
    $t = $tones[$tone] ?? $tones['brand'];
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'group flex items-center gap-3 rounded-xl border border-slate-200/80 bg-white p-4 dark:border-slate-800 dark:bg-slate-900 ' . $t['hover']]) }}>
    @if($icon)
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-white {{ $t['box'] }}">
            @include('layouts.partials.icon', ['name' => $icon, 'class' => 'h-5 w-5'])
        </span>
    @endif
    <span class="min-w-0">
        @if($category)
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $category }}</p>
        @endif
        <p class="truncate font-semibold text-slate-900 group-hover:text-brand-700 dark:text-white dark:group-hover:text-brand-400">{{ $label }}</p>
        @if($description)
            <p class="mt-0.5 truncate text-xs text-slate-500">{{ $description }}</p>
        @endif
    </span>
</a>
