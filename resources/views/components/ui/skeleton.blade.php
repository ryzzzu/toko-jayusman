@props(['variant' => 'text', 'lines' => 1])

@php
    $base = 'animate-pulse rounded-lg bg-slate-200/80 dark:bg-slate-700/60';
@endphp

@switch($variant)
    @case('stat')
        <div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900']) }}>
            <div class="{{ $base }} h-3 w-24"></div>
            <div class="{{ $base }} mt-3 h-8 w-32"></div>
        </div>
        @break

    @case('card')
        <div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900']) }}>
            <div class="{{ $base }} h-4 w-40"></div>
            <div class="{{ $base }} mt-4 h-3 w-full"></div>
            <div class="{{ $base }} mt-2 h-3 w-5/6"></div>
            <div class="{{ $base }} mt-2 h-3 w-2/3"></div>
        </div>
        @break

    @case('table-row')
        <tr {{ $attributes }}>
            @for ($i = 0; $i < ($lines ?: 4); $i++)
                <td class="px-5 py-4">
                    <div class="{{ $base }} h-3.5 {{ $i === 0 ? 'w-28' : ($i === ($lines - 1) ? 'w-16' : 'w-full') }}"></div>
                </td>
            @endfor
        </tr>
        @break

    @case('table')
        <div {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900']) }}>
            <div class="border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                <div class="{{ $base }} h-4 w-48"></div>
                <div class="{{ $base }} mt-2 h-3 w-64"></div>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @for ($r = 0; $r < 5; $r++)
                    <div class="flex items-center gap-4 px-5 py-4">
                        <div class="{{ $base }} h-3.5 flex-1"></div>
                        <div class="{{ $base }} h-3.5 w-24"></div>
                        <div class="{{ $base }} h-3.5 w-20"></div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @default
        <div {{ $attributes->merge(['class' => $base . ' h-3 w-full']) }}></div>
@endswitch
