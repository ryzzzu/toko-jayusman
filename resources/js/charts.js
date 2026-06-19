import Chart from 'chart.js/auto';

const colors = {
    brand: '#2563eb',
    brandSoft: 'rgba(37, 99, 235, 0.12)',
    accent: '#059669',
    accentSoft: 'rgba(5, 150, 105, 0.12)',
    slate: '#94a3b8',
    grid: '#e2e8f0',
    text: '#64748b',
    palette: ['#2563eb', '#059669', '#0ea5e9', '#6366f1', '#14b8a6', '#64748b', '#0284c7', '#047857'],
};

const instances = new Map();

function isDark() {
    return document.documentElement.classList.contains('dark');
}

function gridColor() {
    return isDark() ? '#334155' : colors.grid;
}

function textColor() {
    return isDark() ? '#94a3b8' : colors.text;
}

function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value ?? 0);
}

function formatNumber(value) {
    return new Intl.NumberFormat('id-ID').format(value ?? 0);
}

function baseOptions(extra = {}) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: {
                display: false,
                labels: {
                    color: textColor(),
                    font: { family: '"Plus Jakarta Sans", sans-serif', size: 11 },
                    boxWidth: 10,
                    padding: 14,
                },
            },
            tooltip: {
                backgroundColor: '#0f172a',
                titleColor: '#f8fafc',
                bodyColor: '#e2e8f0',
                padding: 10,
                cornerRadius: 6,
                titleFont: { family: '"Plus Jakarta Sans", sans-serif', size: 12, weight: '600' },
                bodyFont: { family: '"Plus Jakarta Sans", sans-serif', size: 11 },
            },
        },
        ...extra,
    };
}

function buildConfig(type, payload) {
    switch (type) {
        case 'sales-daily':
            return {
                type: 'line',
                data: {
                    labels: payload.labels ?? [],
                    datasets: [{
                        label: 'Omset',
                        data: payload.totals ?? [],
                        borderColor: colors.brand,
                        backgroundColor: colors.brandSoft,
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointBackgroundColor: colors.brand,
                    }],
                },
                options: baseOptions({
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` Omset: ${formatCurrency(ctx.parsed.y)}`,
                            },
                        },
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: textColor(), font: { size: 11 } } },
                        y: {
                            grid: { color: gridColor() },
                            ticks: {
                                color: textColor(),
                                font: { size: 11 },
                                callback: (v) => (v >= 1_000_000 ? `${(v / 1_000_000).toFixed(1)}jt` : v >= 1_000 ? `${(v / 1_000).toFixed(0)}rb` : v),
                            },
                        },
                    },
                }),
            };

        case 'sales-monthly':
            return {
                type: 'bar',
                data: {
                    labels: payload.labels ?? [],
                    datasets: [{
                        label: 'Omset Bulanan',
                        data: payload.values ?? [],
                        backgroundColor: colors.brand,
                        borderRadius: 4,
                        maxBarThickness: 40,
                    }],
                },
                options: baseOptions({
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` Omset: ${formatCurrency(ctx.parsed.y)}`,
                            },
                        },
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: textColor(), font: { size: 11 } } },
                        y: {
                            grid: { color: gridColor() },
                            ticks: { color: textColor(), font: { size: 11 } },
                        },
                    },
                }),
            };

        case 'stock-flow':
            return {
                type: 'bar',
                data: {
                    labels: payload.labels ?? [],
                    datasets: [
                        {
                            label: 'Barang Masuk',
                            data: payload.in ?? [],
                            backgroundColor: colors.accent,
                            borderRadius: 4,
                            stack: 'flow',
                        },
                        {
                            label: 'Barang Keluar',
                            data: payload.out ?? [],
                            backgroundColor: colors.brand,
                            borderRadius: 4,
                            stack: 'flow',
                        },
                    ],
                },
                options: baseOptions({
                    plugins: {
                        legend: { display: true, position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` ${ctx.dataset.label}: ${formatNumber(ctx.parsed.y)} unit`,
                            },
                        },
                    },
                    scales: {
                        x: { stacked: true, grid: { display: false }, ticks: { color: textColor(), font: { size: 11 } } },
                        y: {
                            stacked: true,
                            grid: { color: gridColor() },
                            ticks: { color: textColor(), font: { size: 11 }, stepSize: 1 },
                        },
                    },
                }),
            };

        case 'branch-sales':
            return {
                type: 'bar',
                data: {
                    labels: payload.labels ?? [],
                    datasets: [{
                        data: payload.values ?? [],
                        backgroundColor: colors.brand,
                        borderRadius: 4,
                        maxBarThickness: 48,
                    }],
                },
                options: baseOptions({
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` ${formatCurrency(ctx.parsed.y)}`,
                            },
                        },
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: textColor(), font: { size: 11 }, maxRotation: 45 } },
                        y: {
                            grid: { color: gridColor() },
                            ticks: { color: textColor(), font: { size: 11 } },
                        },
                    },
                }),
            };

        case 'top-products':
            return {
                type: 'bar',
                data: {
                    labels: payload.labels ?? [],
                    datasets: [{
                        data: payload.values ?? [],
                        backgroundColor: colors.accent,
                        borderRadius: 4,
                        barThickness: 20,
                    }],
                },
                options: baseOptions({
                    indexAxis: 'y',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (ctx) => ` Terjual: ${formatNumber(ctx.parsed.x)} unit`,
                            },
                        },
                    },
                    scales: {
                        x: { grid: { color: gridColor() }, ticks: { color: textColor(), font: { size: 11 } } },
                        y: { grid: { display: false }, ticks: { color: textColor(), font: { size: 11 } } },
                    },
                }),
            };

        case 'category-donut':
            return {
                type: 'doughnut',
                data: {
                    labels: payload.labels ?? [],
                    datasets: [{
                        data: payload.values ?? [],
                        backgroundColor: (payload.labels ?? []).map((_, i) => colors.palette[i % colors.palette.length]),
                        borderWidth: 0,
                        hoverOffset: 4,
                    }],
                },
                options: baseOptions({
                    cutout: '70%',
                    plugins: {
                        legend: { display: true, position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label(context) {
                                    const total = (payload.values ?? []).reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                    return ` ${context.label}: ${formatNumber(context.parsed)} (${pct}%)`;
                                },
                            },
                        },
                    },
                }),
            };

        default:
            return null;
    }
}

function destroyCharts() {
    instances.forEach((chart) => chart.destroy());
    instances.clear();
}

export function initDashboardCharts() {
    destroyCharts();

    document.querySelectorAll('[data-dashboard-chart]').forEach((canvas) => {
        const type = canvas.dataset.chartType;
        const payload = JSON.parse(canvas.dataset.chartPayload || '{}');
        const config = buildConfig(type, payload);

        if (!config) return;

        instances.set(canvas, new Chart(canvas, config));
    });
}
