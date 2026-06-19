const CONTENT_ID = 'page-content';
const EXIT_MS = 160;

function getContent() {
    return document.getElementById(CONTENT_ID);
}

function shouldSkipLink(link) {
    if (!link || link.target === '_blank' || link.hasAttribute('download')) return true;
    if (link.dataset.noTransition !== undefined) return true;

    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:')) return true;

    try {
        const url = new URL(href, window.location.origin);
        return url.origin !== window.location.origin;
    } catch {
        return true;
    }
}

function shouldSkipForm(form) {
    if (!(form instanceof HTMLFormElement)) return true;
    if (form.dataset.noTransition !== undefined) return true;
    return false;
}

function playEnter() {
    const el = getContent();
    if (!el) return;

    el.classList.remove('page-content--exit');
    el.classList.remove('page-content--enter');
    void el.offsetWidth;
    el.classList.add('page-content--enter');
}

function playExit(then) {
    const el = getContent();
    if (!el) {
        then();
        return;
    }

    el.classList.remove('page-content--enter');
    el.classList.add('page-content--exit');

    window.setTimeout(then, EXIT_MS);
}

function navigateTo(url) {
    playExit(() => {
        window.location.href = url;
    });
}

export function initPageTransition() {
    if (!getContent()) {
        return;
    }

    playEnter();

    window.addEventListener('pageshow', () => playEnter());

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        if (shouldSkipLink(link)) return;
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

        event.preventDefault();
        navigateTo(link.href);
    });

    document.addEventListener('submit', (event) => {
        if (event.defaultPrevented) return;

        const form = event.target;
        if (shouldSkipForm(form)) return;

        event.preventDefault();
        playExit(() => form.submit());
    });
}
