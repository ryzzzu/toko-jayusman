@props([
    'type',
    'payload' => [],
    'height' => 260,
    'emptyTitle' => 'Belum ada data',
    'emptyDescription' => 'Data akan tampil otomatis setelah tersedia.',
])

@php
    $hasData = match ($type) {
        'sales-daily', 'sales-monthly', 'stock-flow' => count($payload['labels'] ?? []) > 0,
        'branch-sales', 'top-products' => count($payload['labels'] ?? []) > 0
            && collect($payload['values'] ?? [])->sum() > 0,
        'category-donut' => count($payload['labels'] ?? []) > 0
            && collect($payload['values'] ?? [])->sum() > 0,
        default => false,
    };
@endphp

@if($hasData)
    <div class="relative w-full" style="height: {{ $height }}px">
        <canvas
            data-dashboard-chart
            data-chart-type="{{ $type }}"
            data-chart-payload='@json($payload)'
            role="img"
            aria-label="{{ $emptyTitle }}"
        ></canvas>
    </div>
@else
    <x-dashboard.chart-empty :title="$emptyTitle" :description="$emptyDescription" />
@endif
