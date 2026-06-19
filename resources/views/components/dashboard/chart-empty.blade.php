<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-lg border border-dashed border-slate-200 bg-slate-50/50 px-6 py-10 text-center dark:border-slate-700 dark:bg-slate-800/30']) }}>
    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $title }}</p>
    <p class="mt-1 max-w-sm text-xs leading-relaxed text-slate-500">{{ $description }}</p>
</div>
