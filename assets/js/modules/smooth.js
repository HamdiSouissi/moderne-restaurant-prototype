/**
 * CORTILE — smooth scrolling.
 * Lenis + GSAP ticker + anchor navigation that respects the fixed header.
 */

import { qsa, prefersReducedMotion } from './utils.js';

let lenis = null;

export function initSmoothScroll() {
    if (prefersReducedMotion() || typeof window.Lenis === 'undefined') {
        initAnchorsFallback();
        return null;
    }

    lenis = new window.Lenis({
        duration: 1.15,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 1,
        touchMultiplier: 1.6,
        syncTouch: false,
        autoRaf: false,
    });

    // Drive Lenis from the GSAP ticker so both stay on the same frame.
    if (window.gsap) {
        lenis.on('scroll', window.ScrollTrigger?.update);
        window.gsap.ticker.add((time) => lenis.raf(time * 1000));
        window.gsap.ticker.lagSmoothing(0);
    } else {
        const raf = (time) => {
            lenis.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);
    }

    initAnchors();
    return lenis;
}

export function getLenis() {
    return lenis;
}

export function lockScroll() {
    if (lenis) lenis.stop();
    document.documentElement.style.overflow = 'hidden';
}

export function unlockScroll() {
    if (lenis) lenis.start();
    document.documentElement.style.overflow = '';
}

/** Scroll to an element or selector, accounting for the fixed header. */
export function scrollTo(target) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return;

    if (lenis) {
        lenis.scrollTo(el, { offset: -70, duration: 1.5 });
    } else {
        const top = el.getBoundingClientRect().top + window.scrollY - 70;
        window.scrollTo({ top, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });
    }
}

function initAnchors() {
    qsa('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const id = link.getAttribute('href');
            if (!id || id === '#') return;

            const target = document.querySelector(id);
            if (!target) return;

            event.preventDefault();
            closeMobileNavIfOpen();
            scrollTo(target);
            history.replaceState(null, '', id);
        });
    });
}

function initAnchorsFallback() {
    qsa('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const target = document.querySelector(link.getAttribute('href') || '');
            if (!target) return;
            event.preventDefault();
            const top = target.getBoundingClientRect().top + window.scrollY - 70;
            window.scrollTo({ top, behavior: 'auto' });
        });
    });
}

function closeMobileNavIfOpen() {
    const nav = document.querySelector('[data-menu-toggle]');
    if (nav && nav.getAttribute('aria-expanded') === 'true') {
        nav.click();
    }
}
