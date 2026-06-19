function getFormMethod(form) {
    const override = form.querySelector('input[name="_method"]')?.value;
    return (override || form.method || 'GET').toUpperCase();
}

function getFormLoadingMessage(form, submitBtn) {
    if (form.dataset.loadingMessage) return form.dataset.loadingMessage;
    if (submitBtn?.dataset.loadingText) return submitBtn.dataset.loadingText;

    const method = getFormMethod(form);

    if (form.dataset.loadingExport !== undefined) return 'Mengekspor...';
    if (method === 'DELETE') return 'Menghapus...';
    if (method === 'PUT' || method === 'PATCH') return 'Memperbarui...';
    if (method === 'GET') return 'Memuat...';

    return 'Menyimpan...';
}

function setSubmitButtonLoading(form, message) {
    const buttons = form.querySelectorAll('button[type="submit"], input[type="submit"]');

    buttons.forEach((btn) => {
        if (btn.disabled) return;

        btn.disabled = true;

        if (btn.tagName === 'BUTTON') {
            if (!btn.dataset.originalHtml) {
                btn.dataset.originalHtml = btn.innerHTML;
            }
            btn.innerHTML = `
                <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span>${message}</span>
            `;
        } else {
            if (!btn.dataset.originalValue) {
                btn.dataset.originalValue = btn.value;
            }
            btn.value = message;
        }
    });
}

function showFormLoading(form) {
    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
    const message = getFormLoadingMessage(form, submitBtn);

    setSubmitButtonLoading(form, message);
}

export function initLoading() {
    document.addEventListener('click', (event) => {
        const printBtn = event.target.closest('[data-loading-print]');
        if (printBtn instanceof HTMLButtonElement) {
            printBtn.disabled = true;
            window.setTimeout(() => {
                printBtn.disabled = false;
            }, 1500);
        }
    });

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (form.dataset.noLoading !== undefined) return;

        const method = getFormMethod(form);
        if (method === 'GET' && form.dataset.loadingSearch === undefined) return;

        if (form.dataset.loadingConfirm !== undefined) {
            const confirmed = window.confirm(form.dataset.loadingConfirm);
            if (!confirmed) {
                event.preventDefault();
                return;
            }
        }

        showFormLoading(form);
    }, true);
}
