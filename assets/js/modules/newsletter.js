/**
 * CORTILE — newsletter (simulated).
 */

import { qs, on } from './utils.js';

export function initNewsletter() {
    const form = qs('[data-newsletter]');
    if (!form) return;

    const input = qs('input[type="email"]', form);
    const error = qs('[data-newsletter-error]', form);
    const success = qs('[data-newsletter-success]', form);

    on(form, 'submit', (event) => {
        event.preventDefault();

        const value = input.value.trim();
        const valid = /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(value);

        if (!valid) {
            if (error) error.textContent = 'Please enter a valid email address.';
            input.setAttribute('aria-invalid', 'true');
            input.focus();
            return;
        }

        if (error) error.textContent = '';
        input.removeAttribute('aria-invalid');
        input.value = '';

        if (success) {
            success.hidden = false;
            if (window.gsap) {
                window.gsap.fromTo(
                    success,
                    { opacity: 0, y: 6 },
                    { opacity: 1, y: 0, duration: 0.5, ease: 'power2.out' }
                );
            }
        }
    });

    on(input, 'input', () => {
        if (error) error.textContent = '';
        input.removeAttribute('aria-invalid');
    });
}
