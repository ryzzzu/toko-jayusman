@props(['items' => [], 'max' => null, 'format' => 'number', 'horizontal' => false])

@php
    $max = $max ?? (collect($items)->max('value') ?: 1);
@endphp

@if(collect($items)->isEmpty())
    <x-dashboard.chart-empty title="Belum ada data grafik" description="Grafik akan terisi setelah transaksi tercatat di sistem." />
@else
    <div class="{{ $horizontal ? 'space-y-3' : 'flex h-52 items-end gap-3 pt-4' }}">
        @foreach($items as $item)
            @php
                $pct = $max > 0 ? round(($item['value'] / $max) * 100) : 0;
                $label = $item['label'] ?? $item['name'] ?? '—';
            @endphp
            @if($horizontal)
                <div>
                    <div class="mb-1 flex items-center justify-between gap-2 text-xs">
                        <span class="truncate font-medium text-slate-700 dark:text-slate-300">{{ $label }}</span>
                        <span class="shrink-0 font-semibold text-slate-900 dark:text-white">
                            @if($format === 'currency')
                                Rp {{ number_format($item['value'], 0, ',', '.') }}
                            @else
                                {{ number_format($item['value'], 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                        <div class="h-full rounded-full bg-brand-600" style="width: {{ max($pct, 4) }}%"></div>
                    </div>
                </div>
            @else
                <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                    <div class="flex w-full flex-1 items-end justify-center">
                        <div class="w-full max-w-[3rem] rounded-t bg-brand-600" style="height: {{ max($pct, 6) }}%"></div>
                    </div>
                    <span class="w-full truncate text-center text-[10px] font-medium text-slate-500" title="{{ $label }}">{{ $label }}</span>
                </div>
            @endif
        @endforeach
    </div>
@endif
