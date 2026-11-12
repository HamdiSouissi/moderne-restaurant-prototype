/**
 * CORTILE — small shared utilities.
 * No framework, no build step: native ES modules.
 */

export const qs = (selector, scope = document) => scope.querySelector(selector);
export const qsa = (selector, scope = document) => [...scope.querySelectorAll(selector)];

export const on = (el, type, handler, options) => {
    if (!el) return () => {};
    el.addEventListener(type, handler, options);
    return () => el.removeEventListener(type, handler, options);
};

export const prefersReducedMotion = () =>
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export const isTouch = () =>
    window.matchMedia('(hover: none), (pointer: coarse)').matches;

/** € 24,50 — Italian formatting */
export const formatEUR = (value) =>
    '€ ' + Number(value).toFixed(2).replace('.', ',');

/** Tiny throttle with requestAnimationFrame */
export function rafThrottle(fn) {
    let ticking = false;
    return (...args) => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
            fn(...args);
            ticking = false;
        });
    };
}

/* -------------------------------------------------------------------------
 * Dialogs: one place that handles aria attributes, focus and scroll locking.
 * ---------------------------------------------------------------------- */
let openDialogs = 0;
const focusableSelector =
    'a[href], button:not([disabled]), input:not([disabled]), select, textarea, [tabindex]:not([tabindex="-1"])';

export function openDialog(el) {
    if (!el) return;
    el.hidden = false;
    el.setAttribute('aria-hidden', 'false');
    requestAnimationFrame(() => el.classList.add('is-open'));

    openDialogs += 1;
    document.body.classList.add('is-locked');
    document.documentElement.style.overflow = 'hidden';

    const focusTarget = el.querySelector('[data-autofocus]') || el.querySelector(focusableSelector);
    if (focusTarget) setTimeout(() => focusTarget.focus({ preventScroll: true }), 120);

    el._lastFocused = document.activeElement;
}

export function closeDialog(el) {
    if (!el) return;
    el.classList.remove('is-open');
    el.setAttribute('aria-hidden', 'true');
    setTimeout(() => { el.hidden = true; }, 450);

    openDialogs = Math.max(0, openDialogs - 1);
    if (openDialogs === 0) {
        document.body.classList.remove('is-locked');
        document.documentElement.style.overflow = '';
    }

    if (el._lastFocused && typeof el._lastFocused.focus === 'function') {
        el._lastFocused.focus({ preventScroll: true });
    }
}

/** Keep tab focus inside a dialog while it is open */
export function trapFocus(el) {
    const handler = (event) => {
        if (event.key !== 'Tab' || !el.classList.contains('is-open')) return;
        const items = qsa(focusableSelector, el).filter((node) => node.offsetParent !== null);
        if (!items.length) return;

        const first = items[0];
        const last = items[items.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    };

    document.addEventListener('keydown', handler);
    return () => document.removeEventListener('keydown', handler);
}

/* -------------------------------------------------------------------------
 * Toast
 * ---------------------------------------------------------------------- */
let toastTimer;

export function toast(message) {
    const el = qs('[data-toast]');
    const text = qs('[data-toast-text]', el || document);
    if (!el || !text) return;

    text.textContent = message;
    el.classList.add('is-visible');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.classList.remove('is-visible'), 2800);
}
