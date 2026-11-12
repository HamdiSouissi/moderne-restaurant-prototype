/**
 * CORTILE — menu filtering.
 * Cards are filtered by data-category with a short, smooth re-entrance.
 */

import { qs, qsa, on } from './utils.js';

export function initMenu() {
    const grid = qs('[data-menu-grid]');
    const filters = qsa('[data-filter]');
    if (!grid || !filters.length) return;

    const dishes = qsa('[data-dish]', grid);

    const apply = (key, animate = true) => {
        let visible = 0;

        dishes.forEach((dish) => {
            const match = key === 'all' || dish.dataset.category === key;
            dish.hidden = !match;
            if (match) visible += 1;
        });

        // A category with a single dish gets a wide, editorial layout.
        grid.classList.toggle('menu__grid--solo', visible === 1);

        if (animate && window.gsap) {
            const shown = dishes.filter((dish) => !dish.hidden);
            window.gsap.fromTo(
                shown,
                { opacity: 0, y: 22 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    stagger: 0.06,
                    ease: 'power2.out',
                    overwrite: true,
                    clearProps: 'transform,opacity',
                }
            );
        }

        window.ScrollTrigger?.refresh();
    };

    filters.forEach((button) => {
        on(button, 'click', () => {
            filters.forEach((filter) => {
                const active = filter === button;
                filter.classList.toggle('is-active', active);
                filter.setAttribute('aria-selected', String(active));
            });

            apply(button.dataset.filter);
        });
    });

    // Full menu by default
    apply('all', false);
}
