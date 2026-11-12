/**
 * CORTILE — gallery & lightbox.
 * Accessible viewer: arrows, keyboard, swipe, click-to-zoom.
 */

import { qs, qsa, on, openDialog, closeDialog, trapFocus } from './utils.js';

export function initGallery() {
    const shots = qsa('[data-lightbox]');
    const lightbox = qs('#lightbox');
    if (!shots.length || !lightbox) return;

    const image = qs('[data-lightbox-img]', lightbox);
    const caption = qs('[data-lightbox-caption]', lightbox);
    const counter = qs('[data-lightbox-counter]', lightbox);
    const stage = qs('.lightbox__stage', lightbox);

    const items = shots.map((shot) => {
        const img = shot.querySelector('img');

        // Pick the largest variant declared in srcset (never a missing file).
        const candidates = (img?.getAttribute('srcset') || '')
            .split(',')
            .map((entry) => entry.trim().split(/\s+/))
            .filter((parts) => parts[0])
            .map(([url, descriptor]) => ({ url, width: parseInt(descriptor, 10) || 0 }))
            .sort((a, b) => b.width - a.width);

        return {
            src: candidates[0]?.url || img?.getAttribute('src') || '',
            alt: img?.getAttribute('alt') || '',
            caption: shot.dataset.caption || '',
        };
    });

    let index = 0;
    let releaseFocus = null;

    const pad = (value) => String(value).padStart(2, '0');

    const preload = (i) => {
        const item = items[(i + items.length) % items.length];
        if (!item) return;
        const pre = new Image();
        pre.src = item.src;
    };

    const render = () => {
        const item = items[index];
        if (!item) return;

        image.classList.remove('is-zoomed');
        image.src = item.src;
        image.alt = item.alt;
        caption.textContent = item.caption;
        counter.textContent = `${pad(index + 1)} / ${pad(items.length)}`;

        preload(index + 1);
        preload(index - 1);

        if (window.gsap) {
            window.gsap.fromTo(
                image,
                { opacity: 0, scale: 0.98 },
                { opacity: 1, scale: 1, duration: 0.6, ease: 'power2.out', overwrite: true }
            );
        }
    };

    const open = (i) => {
        index = i;
        render();
        openDialog(lightbox);
        releaseFocus = trapFocus(lightbox);
    };

    const close = () => {
        closeDialog(lightbox);
        releaseFocus?.();
        releaseFocus = null;
    };

    const step = (direction) => {
        index = (index + direction + items.length) % items.length;
        render();
    };

    shots.forEach((shot) => {
        on(shot, 'click', () => open(Number(shot.dataset.lightbox)));
        on(shot, 'keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                open(Number(shot.dataset.lightbox));
            }
        });
    });

    qsa('[data-lightbox-close]', lightbox).forEach((button) => on(button, 'click', close));
    on(qs('[data-lightbox-prev]', lightbox), 'click', () => step(-1));
    on(qs('[data-lightbox-next]', lightbox), 'click', () => step(1));

    on(image, 'click', () => image.classList.toggle('is-zoomed'));

    on(lightbox, 'click', (event) => {
        if (event.target === lightbox) close();
    });

    on(document, 'keydown', (event) => {
        if (!lightbox.classList.contains('is-open')) return;
        if (event.key === 'Escape') close();
        if (event.key === 'ArrowRight') step(1);
        if (event.key === 'ArrowLeft') step(-1);
    });

    // Swipe on touch devices
    let startX = null;
    on(stage, 'touchstart', (event) => {
        startX = event.touches[0].clientX;
    }, { passive: true });

    on(stage, 'touchend', (event) => {
        if (startX === null) return;
        const delta = event.changedTouches[0].clientX - startX;
        if (Math.abs(delta) > 55) step(delta > 0 ? -1 : 1);
        startX = null;
    }, { passive: true });
}
