@props(['items' => []])

<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'flex items-center gap-1.5 text-sm']) }}>
    @foreach ($items as $index => $item)
        @if ($index > 0)
            <svg class="h-3.5 w-3.5 shrink-0 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
        @endif

        @if (!empty($item['url']) && $index < count($items) - 1)
            <a href="{{ $item['url'] }}"
               class="truncate font-medium text-slate-500 transition hover:text-brand-600 dark:text-slate-400 dark:hover:text-brand-400">
                {{ $item['label'] }}
            </a>
        @else
            <span class="truncate font-semibold text-slate-900 dark:text-white" @if($index === count($items) - 1) aria-current="page" @endif>
                {{ $item['label'] }}
            </span>
        @endif
    @endforeach
</nav>
