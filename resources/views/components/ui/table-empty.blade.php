@props(['title', 'description' => null, 'colspan' => 1])

<tr {{ $attributes }}>
    <td colspan="{{ $colspan }}" class="py-12 text-center">
        <div class="mx-auto flex max-w-sm flex-col items-center">
            <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $title }}</p>
            @if($description)
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $description }}</p>
            @endif
            @isset($action)
                <div class="mt-4">{{ $action }}</div>
            @endisset
        </div>
    </td>
</tr>
