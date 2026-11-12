/**
 * =============================================================================
 *  CORTILE — application entry point
 * =============================================================================
 *  Native ES modules, no build step. Each feature lives in its own file so a
 *  real restaurant site can remove or adapt one without touching the rest.
 *
 *  Vendors (CDN, loaded with `defer` before this module):
 *    · GSAP + ScrollTrigger — reveals, parallax, magnetic buttons
 *    · Lenis               — smooth scrolling
 *    · Swiper              — testimonial carousel
 *
 *  Everything degrades gracefully: no vendor, no problem — the page remains
 *  readable, navigable and fully functional.
 * =============================================================================
 */

import { initSmoothScroll } from './modules/smooth.js';
import { initLoader } from './modules/loader.js';
import { initHeader } from './modules/header.js';
import { initCursor } from './modules/cursor.js';
import { initAnimations, initHeroIntro } from './modules/animations.js';
import { initMenu } from './modules/menu.js';
import { initGallery } from './modules/gallery.js';
import { initAccordion } from './modules/accordion.js';
import { initReservation } from './modules/reservation.js';
import { initCart } from './modules/cart.js';
import { initTestimonials } from './modules/testimonials.js';
import { initNewsletter } from './modules/newsletter.js';

/** Wait (briefly) for a vendor script, so CDN hiccups never break the page. */
function waitFor(check, timeout = 1200) {
    return new Promise((resolve) => {
        if (check()) return resolve(true);

        const started = Date.now();
        const timer = setInterval(() => {
            if (check()) {
                clearInterval(timer);
                resolve(true);
            } else if (Date.now() - started > timeout) {
                clearInterval(timer);
                resolve(false);
            }
        }, 40);
    });
}

async function boot() {
    const hasGsap = await waitFor(() => Boolean(window.gsap && window.ScrollTrigger));

    if (!hasGsap) {
        document.documentElement.classList.add('no-gsap');
    }

    if (!window.Lenis || !hasGsap) {
        document.documentElement.classList.add('no-smooth');
    }

    // Interface behaviour
    initHeader();
    initMenu();
    initGallery();
    initAccordion();
    initReservation();
    initCart();
    initTestimonials();
    initNewsletter();
    initCursor();

    // Motion
    initSmoothScroll();
    initAnimations();

    // The hero choreography waits for the curtain to lift.
    const loaderDone = initLoader();
    await loaderDone;

    initHeroIntro();

    window.ScrollTrigger?.refresh();

    // Late layout shifts (web fonts, lazy images) can alter trigger positions.
    setTimeout(() => window.ScrollTrigger?.refresh(), 800);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
