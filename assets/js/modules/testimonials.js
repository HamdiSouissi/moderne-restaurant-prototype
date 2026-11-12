/**
 * CORTILE — testimonials carousel (Swiper).
 */

import { qs, qsa } from './utils.js';

export function initTestimonials() {
    const el = qs('.testimonials__swiper');
    if (!el || typeof window.Swiper === 'undefined') {
        // Graceful fallback: horizontal scrolling instead of a carousel.
        if (el) {
            el.style.overflowX = 'auto';
            qsa('.testimonial', el).forEach((slide) => {
                slide.style.flex = '0 0 auto';
                slide.style.marginRight = '20px';
            });
        }
        return;
    }

    const current = qs('[data-swiper-current]');
    const pad = (value) => String(value).padStart(2, '0');

    const swiper = new window.Swiper(el, {
        slidesPerView: 'auto',
        spaceBetween: 20,
        speed: 750,
        grabCursor: true,
        slideToClickedSlide: true,
        keyboard: { enabled: true },
        navigation: {
            prevEl: '[data-swiper-prev]',
            nextEl: '[data-swiper-next]',
        },
        breakpoints: {
            900: { spaceBetween: 28 },
        },
        on: {
            init(instance) {
                if (current) current.textContent = pad(instance.activeIndex + 1);
            },
            slideChange(instance) {
                if (current) current.textContent = pad(instance.activeIndex + 1);
            },
        },
    });

    return swiper;
}
