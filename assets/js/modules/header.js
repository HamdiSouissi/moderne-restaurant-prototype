/**
 * CORTILE — header behaviour.
 * Frosted background on scroll, auto-hide, active section, scroll progress,
 * and the full-screen mobile navigation.
 */

import { qs, qsa, on, rafThrottle } from './utils.js';

export function initHeader() {
    const header = qs('[data-header]');
    const progress = qs('[data-progress]');
    const toggle = qs('[data-menu-toggle]');
    const mobileNav = qs('#mobileNav');
    const navLinks = qsa('[data-nav]');
    let lastScroll = 0;

    const updateScrollUI = rafThrottle(() => {
        const scrollY = window.scrollY;
        const max = document.documentElement.scrollHeight - window.innerHeight;

        if (header) {
            header.classList.toggle('is-scrolled', scrollY > 40);

            const goingDown = scrollY > lastScroll;
            const shouldHide = goingDown && scrollY > 600 &&
                !header.classList.contains('is-open') &&
                !document.body.classList.contains('is-locked');

            header.classList.toggle('is-hidden', shouldHide);
        }

        if (progress) {
            const ratio = max > 0 ? Math.min(1, Math.max(0, scrollY / max)) : 0;
            progress.style.transform = `scaleX(${ratio})`;
        }

        lastScroll = scrollY;
    });

    on(window, 'scroll', updateScrollUI, { passive: true });
    updateScrollUI();

    /* Active navigation link ------------------------------------------------ */
    const sections = navLinks
        .map((link) => {
            const id = link.dataset.nav;
            const section = document.getElementById(id);
            return section ? { link, section } : null;
        })
        .filter(Boolean);

    if ('IntersectionObserver' in window && sections.length) {
        const visible = new Map();

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    visible.set(entry.target, entry.isIntersecting ? entry.intersectionRatio : 0);
                });

                let best = null;
                let bestRatio = 0;
                visible.forEach((ratio, section) => {
                    if (ratio > bestRatio) {
                        bestRatio = ratio;
                        best = section;
                    }
                });

                if (best) {
                    sections.forEach(({ link, section }) => {
                        const isActive = section === best;
                        link.classList.toggle('is-active', isActive);
                        if (isActive) link.setAttribute('aria-current', 'true');
                        else link.removeAttribute('aria-current');
                    });
                }
            },
            { rootMargin: '-25% 0px -55% 0px', threshold: [0, 0.15, 0.35, 0.6, 1] }
        );

        sections.forEach(({ section }) => observer.observe(section));
    }

    /* Mobile navigation ----------------------------------------------------- */
    if (!toggle || !mobileNav) return;

    const setMenu = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        mobileNav.classList.toggle('is-open', open);
        mobileNav.setAttribute('aria-hidden', String(!open));
        header?.classList.toggle('is-open', open);
        document.body.classList.toggle('is-locked', open);
        document.documentElement.style.overflow = open ? 'hidden' : '';

        if (window.gsap && !open === false) {
            window.gsap.fromTo(
                qsa('.mobile-nav__list a', mobileNav),
                { y: 30, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.7, stagger: 0.06, ease: 'power3.out', delay: 0.15 }
            );
        }
    };

    on(toggle, 'click', () => {
        setMenu(toggle.getAttribute('aria-expanded') !== 'true');
    });

    qsa('[data-mobile-link]', mobileNav).forEach((link) => {
        on(link, 'click', () => setMenu(false));
    });

    on(document, 'keydown', (event) => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setMenu(false);
            toggle.focus();
        }
    });
}
