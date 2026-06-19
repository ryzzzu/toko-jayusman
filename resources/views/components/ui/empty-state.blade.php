@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-white px-6 py-14 text-center dark:border-slate-700 dark:bg-slate-900']) }}>
    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
    </div>
    <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="mt-4">{{ $action }}</div>
    @endisset
</div>
