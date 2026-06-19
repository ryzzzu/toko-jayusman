import './bootstrap';

import Alpine from 'alpinejs';
import { initLoading } from './loading';
import { initPageTransition } from './page-transition';
import { initDashboardCharts } from './charts';

window.Alpine = Alpine;

Alpine.start();
initLoading();
initPageTransition();

const bootCharts = () => requestAnimationFrame(() => initDashboardCharts());

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootCharts);
} else {
    bootCharts();
}

window.addEventListener('pageshow', bootCharts);

window.addEventListener('global-search', (event) => {
    const term = (event.detail ?? '').trim().toLowerCase();

    document.querySelectorAll('tbody[data-searchable]').forEach((tbody) => {
        const rows = tbody.querySelectorAll('tr[data-row]');
        let visible = 0;

        rows.forEach((row) => {
            const haystack = (row.getAttribute('data-search') ?? row.textContent ?? '').toLowerCase();
            const match = term === '' || haystack.includes(term);
            row.hidden = !match;
            if (match) visible++;
        });

        let empty = tbody.querySelector('[data-search-empty]');
        if (!empty && rows.length > 0) {
            empty = document.createElement('tr');
            empty.setAttribute('data-search-empty', '');
            empty.hidden = true;
            empty.innerHTML = '<td colspan="99" class="py-8 text-center text-sm text-slate-500">Tidak ada hasil untuk pencarian ini.</td>';
            tbody.appendChild(empty);
        }
        if (empty) {
            empty.hidden = term === '' || visible > 0;
        }
    });
});
