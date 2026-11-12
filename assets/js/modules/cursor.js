/**
 * CORTILE — custom cursor.
 * A gold dot follows the pointer exactly, a ring follows with a slight lag.
 * Interactive elements grow the ring; labelled elements reveal a word.
 */

import { qs, isTouch, prefersReducedMotion } from './utils.js';

export function initCursor() {
    if (isTouch() || prefersReducedMotion()) return;

    const cursor = qs('[data-cursor]');
    if (!cursor) return;

    const dot = qs('.cursor__dot', cursor);
    const ring = qs('.cursor__ring', cursor);
    const label = qs('[data-cursor-label]', cursor);
    if (!dot || !ring) return;

    let visible = false;

    const moveDot = (x, y) => {
        dot.style.transform = `translate3d(${x}px, ${y}px, 0)`;
    };

    let moveRing;
    if (window.gsap) {
        moveRing = window.gsap.quickTo(ring, 'x', { duration: 0.45, ease: 'power3.out' });
        window.gsap.quickTo(ring, 'y', { duration: 0.45, ease: 'power3.out' });
        moveRing = (x, y) => {
            window.gsap.to(ring, { x, y, duration: 0.42, ease: 'power3.out', overwrite: true });
        };
    } else {
        moveRing = (x, y) => {
            ring.style.transform = `translate3d(${x}px, ${y}px, 0)`;
        };
    }

    document.addEventListener('mousemove', (event) => {
        const { clientX: x, clientY: y } = event;

        if (!visible) {
            visible = true;
            cursor.classList.remove('is-hidden');
        }

        moveDot(x, y);
        moveRing(x, y);
    });

    document.addEventListener('mouseleave', () => {
        visible = false;
        cursor.classList.add('is-hidden');
    });

    document.addEventListener('mouseenter', () => {
        visible = true;
        cursor.classList.remove('is-hidden');
    });

    document.addEventListener('mousedown', () => cursor.classList.add('is-pressed'));
    document.addEventListener('mouseup', () => cursor.classList.remove('is-pressed'));

    /* Hover states ---------------------------------------------------------- */
    const labelled = 'a, button, .shot, [data-cursor]';

    document.addEventListener('mouseover', (event) => {
        const el = event.target.closest(labelled);
        if (!el) return;

        const text = el.dataset.cursor || (el.classList.contains('shot') ? 'View' : '');
        cursor.classList.add('is-active');

        if (label) {
            label.textContent = text || '';
            label.style.opacity = text ? '' : '0';
        }

        if (!text) {
            ring.style.background = 'transparent';
            ring.style.borderColor = 'rgba(185, 146, 91, 0.85)';
        } else {
            ring.style.background = '';
            ring.style.borderColor = '';
        }
    });

    document.addEventListener('mouseout', (event) => {
        const el = event.target.closest(labelled);
        if (!el) return;
        const stillInside = el.contains(event.relatedTarget);
        if (stillInside) return;

        cursor.classList.remove('is-active');
        if (label) label.style.opacity = '0';
        ring.style.background = '';
        ring.style.borderColor = '';
    });
}
