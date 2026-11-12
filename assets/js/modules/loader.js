/**
 * CORTILE — premium loading screen.
 * Counts to 100 while the hero photograph decodes, then lifts the curtain.
 */

import { qs, prefersReducedMotion } from './utils.js';

export function initLoader() {
    const loader = qs('#loader');
    const bar = qs('[data-loader-bar]');
    const count = qs('[data-loader-count]');
    if (!loader) return Promise.resolve();

    // Wait for the actual hero photograph that is already in the document —
    // no hard-coded file name, so the image pipeline can evolve freely.
    const heroImage = document.querySelector('.hero__img');
    const heroReady = new Promise((resolve) => {
        if (!heroImage) return resolve();
        if (heroImage.complete && heroImage.naturalWidth > 0) return resolve();
        heroImage.addEventListener('load', resolve, { once: true });
        heroImage.addEventListener('error', resolve, { once: true });
        setTimeout(resolve, 2600);
    });

    // Never hold the visitor for more than 2.8s.
    const maxWait = new Promise((resolve) => setTimeout(resolve, 2800));

    const done = new Promise((resolve) => {
        const finish = () => {
            loader.classList.add('is-done');
            document.documentElement.classList.add('is-loaded');
            setTimeout(() => loader.remove(), 900);
            resolve();
        };

        if (prefersReducedMotion() || !window.gsap) {
            if (bar) bar.style.transform = 'scaleX(1)';
            if (count) count.textContent = '100';
            Promise.race([heroReady, maxWait]).then(() => setTimeout(finish, 200));
            return;
        }

        const state = { value: 0 };
        const timeline = window.gsap.timeline({ paused: true });

        timeline
            .to(state, {
                value: 100,
                duration: 1.5,
                ease: 'power2.inOut',
                onUpdate: () => {
                    const value = Math.round(state.value);
                    if (bar) bar.style.transform = `scaleX(${state.value / 100})`;
                    if (count) count.textContent = String(value).padStart(2, '0');
                },
            })
            .to('.loader__brand, .loader__line, .loader__meta', {
                y: -18,
                opacity: 0,
                duration: 0.5,
                ease: 'power2.out',
                stagger: 0.05,
            }, '-=0.15')
            .to(loader, {
                yPercent: -100,
                duration: 0.95,
                ease: 'expo.inOut',
                onComplete: finish,
            }, '-=0.2');

        Promise.race([heroReady, maxWait]).then(() => {
            timeline.play();
        });
    });

    return done;
}
