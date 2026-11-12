/**
 * CORTILE — motion system.
 * All GSAP work lives here: hero intro, reveals, parallax, counters,
 * magnetic buttons and the soft 3D tilt on menu cards.
 */

import { qs, qsa, isTouch, prefersReducedMotion } from './utils.js';

const DUR = { fast: 0.6, base: 1, slow: 1.4 };

export function initAnimations() {
    const reduced = prefersReducedMotion();

    if (!window.gsap || !window.ScrollTrigger || reduced) {
        document.documentElement.classList.add('no-gsap');
        // Content is visible immediately; only the decorative motion is skipped.
        if (!window.gsap) return;
    }

    const { gsap, ScrollTrigger } = window;
    gsap.registerPlugin(ScrollTrigger);

    initReveals(gsap, ScrollTrigger);
    initParallax(gsap, ScrollTrigger);
    initSignature(gsap, ScrollTrigger);
    initCounters(gsap, ScrollTrigger);
    initMagnetic(gsap);
    initTilt(gsap);
    initHeroScroll(gsap, ScrollTrigger);

    // Images change layout height when they decode.
    window.addEventListener('load', () => ScrollTrigger.refresh());
    document.fonts?.ready.then(() => ScrollTrigger.refresh());
}

/* -------------------------------------------------------------------------
 * Hero entrance — called once the loading screen is gone.
 * ---------------------------------------------------------------------- */
export function initHeroIntro() {
    if (!window.gsap || prefersReducedMotion()) return;

    const { gsap } = window;
    const tl = gsap.timeline({ defaults: { ease: 'expo.out' } });

    tl.to('[data-hero="eyebrow"]', { opacity: 1, y: 0, duration: DUR.base }, 0.05)
        .fromTo('.hero__title .line__inner',
            { yPercent: 110, y: 0 },
            { yPercent: 0, y: 0, duration: 1.35, stagger: 0.12 }, 0.1)
        .to('[data-hero="text"]', { opacity: 1, y: 0, duration: DUR.base }, 0.55)
        .to('[data-hero="actions"]', { opacity: 1, y: 0, duration: DUR.base }, 0.7)
        .to('[data-hero="foot"]', { opacity: 1, duration: DUR.base }, 0.9)
        .to('.hero__img', { scale: 1, duration: 2.4, ease: 'power2.out' }, 0);

    gsap.set('[data-hero="text"], [data-hero="actions"], [data-hero="foot"]', { y: 18 });

    initHeroMouse(gsap);
}

function initHeroMouse(gsap) {
    const media = qs('[data-hero-media]');
    const img = media?.querySelector('img');
    if (!media || !img || isTouch()) return;

    const moveX = gsap.quickTo(img, 'x', { duration: 0.9, ease: 'power3.out' });
    const moveY = gsap.quickTo(img, 'y', { duration: 0.9, ease: 'power3.out' });

    media.parentElement.addEventListener('mousemove', (event) => {
        const { innerWidth, innerHeight } = window;
        const x = (event.clientX / innerWidth - 0.5) * 26;
        const y = (event.clientY / innerHeight - 0.5) * 18;
        moveX(x);
        moveY(y);
    });
}

/* -------------------------------------------------------------------------
 * Reveals
 * ---------------------------------------------------------------------- */
function initReveals(gsap, ScrollTrigger) {
    gsap.set('[data-reveal]', { y: 30, opacity: 0 });

    ScrollTrigger.batch('[data-reveal]', {
        start: 'top 88%',
        once: true,
        onEnter: (batch) =>
            gsap.to(batch, {
                y: 0,
                opacity: 1,
                duration: 1.1,
                ease: 'power3.out',
                stagger: 0.09,
                overwrite: true,
            }),
    });

    // Section titles and quotes get a slightly longer, softer entrance.
    gsap.set('.section-title', { transformOrigin: '0% 100%' });

    // Gallery shots rise softly into place.
    if (qsa('.shot').length) {
        gsap.from('.shot', {
            y: 40,
            opacity: 0,
            duration: 1.1,
            stagger: 0.08,
            ease: 'power2.out',
            scrollTrigger: { trigger: '.gallery__grid', start: 'top 85%', once: true },
        });
    }

    // Stats line draws itself.
    gsap.from('.stats', {
        opacity: 0,
        duration: 1,
        scrollTrigger: { trigger: '.stats', start: 'top 92%', once: true },
    });
}

/* -------------------------------------------------------------------------
 * Parallax (subtle, GPU only)
 * ---------------------------------------------------------------------- */
function initParallax(gsap, ScrollTrigger) {
    if (prefersReducedMotion()) return;

    qsa('[data-parallax]').forEach((el) => {
        const amount = parseFloat(el.dataset.parallax) || 0.1;

        gsap.fromTo(
            el,
            { yPercent: amount * 40 },
            {
                yPercent: -amount * 40,
                ease: 'none',
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.1,
                    invalidateOnRefresh: true,
                },
            }
        );
    });

    // Chef portrait: a very slow zoom while scrolling.
    const portrait = qs('.chef__portrait img');
    if (portrait) {
        gsap.fromTo(
            portrait,
            { scale: 1.06 },
            {
                scale: 1.14,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.chef__media',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1.4,
                },
            }
        );
    }
}

/* -------------------------------------------------------------------------
 * Signature dish: cinematic zoom-out
 * ---------------------------------------------------------------------- */
function initSignature(gsap, ScrollTrigger) {
    const img = qs('[data-signature-media] img');
    if (!img || prefersReducedMotion()) return;

    gsap.fromTo(
        img,
        { scale: 1.18, yPercent: -2 },
        {
            scale: 1.02,
            yPercent: 2,
            ease: 'none',
            scrollTrigger: {
                trigger: '.signature',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1.2,
            },
        }
    );
}

/* -------------------------------------------------------------------------
 * Counters (stats)
 * ---------------------------------------------------------------------- */
function initCounters(gsap, ScrollTrigger) {
    qsa('[data-count]').forEach((el) => {
        const target = parseInt(el.dataset.count, 10);
        if (Number.isNaN(target)) return;

        const state = { value: 0 };
        el.textContent = '0';

        ScrollTrigger.create({
            trigger: el,
            start: 'top 92%',
            once: true,
            onEnter: () =>
                gsap.to(state, {
                    value: target,
                    duration: 1.8,
                    ease: 'power2.out',
                    onUpdate: () => {
                        el.textContent = String(Math.round(state.value));
                    },
                }),
        });
    });
}

/* -------------------------------------------------------------------------
 * Magnetic buttons
 * ---------------------------------------------------------------------- */
function initMagnetic(gsap) {
    if (isTouch() || prefersReducedMotion()) return;

    qsa('.js-magnetic').forEach((el) => {
        const strength = 0.28;

        el.addEventListener('mousemove', (event) => {
            const rect = el.getBoundingClientRect();
            const x = (event.clientX - rect.left - rect.width / 2) * strength;
            const y = (event.clientY - rect.top - rect.height / 2) * strength;

            gsap.to(el, { x, y, duration: 0.5, ease: 'power2.out', overwrite: true });
        });

        el.addEventListener('mouseleave', () => {
            gsap.to(el, { x: 0, y: 0, duration: 0.7, ease: 'elastic.out(1, 0.5)', overwrite: true });
        });
    });
}

/* -------------------------------------------------------------------------
 * Soft 3D tilt on cards
 * ---------------------------------------------------------------------- */
function initTilt(gsap) {
    if (isTouch() || prefersReducedMotion()) return;

    qsa('.dish, .testimonial').forEach((card) => {
        gsap.set(card, { transformPerspective: 900, transformStyle: 'preserve-3d' });

        card.addEventListener('mousemove', (event) => {
            const rect = card.getBoundingClientRect();
            const px = (event.clientX - rect.left) / rect.width - 0.5;
            const py = (event.clientY - rect.top) / rect.height - 0.5;

            gsap.to(card, {
                rotateY: px * 4,
                rotateX: -py * 4,
                y: -6,
                duration: 0.6,
                ease: 'power2.out',
                overwrite: 'auto',
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                rotateX: 0,
                rotateY: 0,
                y: 0,
                duration: 0.9,
                ease: 'power3.out',
                overwrite: 'auto',
            });
        });
    });
}

/* -------------------------------------------------------------------------
 * Hero scroll: gentle lift + fade
 * ---------------------------------------------------------------------- */
function initHeroScroll(gsap, ScrollTrigger) {
    if (prefersReducedMotion()) return;

    gsap.to('.hero__media', {
        yPercent: 10,
        ease: 'none',
        scrollTrigger: {
            trigger: '.hero',
            start: 'top top',
            end: 'bottom top',
            scrub: true,
        },
    });

    gsap.to('.hero__content', {
        yPercent: 8,
        opacity: 0.25,
        ease: 'none',
        scrollTrigger: {
            trigger: '.hero',
            start: 'top top',
            end: '65% top',
            scrub: true,
        },
    });
}
