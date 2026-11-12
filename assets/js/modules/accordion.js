/**
 * CORTILE — FAQ accordion.
 * One panel open at a time, animated height, fully keyboard accessible.
 */

import { qsa, qs, on } from './utils.js';

export function initAccordion() {
    const accordion = qs('[data-accordion]');
    if (!accordion) return;

    const items = qsa('.accordion__item', accordion);

    const setState = (item, open) => {
        const trigger = qs('.accordion__trigger', item);
        const panel = qs('.accordion__panel', item);
        if (!trigger || !panel) return;

        trigger.setAttribute('aria-expanded', String(open));

        if (window.gsap) {
            window.gsap.killTweensOf(panel);

            if (open) {
                window.gsap.set(panel, { height: 'auto' });
                const height = panel.offsetHeight;
                window.gsap.fromTo(
                    panel,
                    { height: 0 },
                    {
                        height,
                        duration: 0.5,
                        ease: 'power2.out',
                        onComplete: () => window.gsap.set(panel, { height: 'auto' }),
                    }
                );
            } else {
                window.gsap.to(panel, {
                    height: 0,
                    duration: 0.42,
                    ease: 'power2.inOut',
                });
            }
        } else {
            panel.style.height = open ? 'auto' : '0px';
        }
    };

    items.forEach((item) => {
        const trigger = qs('.accordion__trigger', item);
        if (!trigger) return;

        on(trigger, 'click', () => {
            const isOpen = trigger.getAttribute('aria-expanded') === 'true';

            items.forEach((other) => {
                if (other !== item) setState(other, false);
            });

            setState(item, !isOpen);

            if (window.ScrollTrigger) {
                setTimeout(() => window.ScrollTrigger.refresh(), 520);
            }
        });
    });

    // Open the first question by default — it answers the most common question.
    if (items[0]) {
        setState(items[0], true);
    }
}
