@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900']) }}>
    <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
                @if($description)
                    <p class="mt-0.5 text-xs text-slate-500">{{ $description }}</p>
                @endif
            </div>
            @isset($action)
                <div class="shrink-0">{{ $action }}</div>
            @endisset
        </div>
    </div>
    <div class="p-5">
        {{ $slot }}
    </div>
</div>
