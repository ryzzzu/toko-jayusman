@props(['padding' => true])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900']) }}>
    @isset($header)
        <div class="border-b border-slate-100 px-6 py-4 dark:border-slate-800">
            {{ $header }}
        </div>
    @endisset

    <div @class([$padding ? 'p-6' : ''])>
        {{ $slot }}
    </div>
</div>
