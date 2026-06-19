@props(['padding' => true])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900']) }}>
    @isset($header)
        <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
            {{ $header }}
        </div>
    @endisset

    <div @class([$padding ? 'p-5' : ''])>
        {{ $slot }}
    </div>
</div>
