/**
 * CORTILE — reservation form (front-end simulation).
 * Inline validation, a short "sending" state, then a premium confirmation.
 */

import { qs, qsa, on, openDialog, closeDialog, formatEUR } from './utils.js';

export function initReservation() {
    const form = qs('[data-reservation]');
    const modal = qs('#reserveModal');
    if (!form || !modal) return;

    /* Date limits: no past dates, no Mondays (the restaurant is closed) */
    const dateInput = qs('#res-date', form);
    const today = new Date();
    const iso = (date) =>
        `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

    if (dateInput) dateInput.min = iso(today);

    const fieldOf = (input) => input.closest('.field');

    const setError = (input, message) => {
        const field = fieldOf(input);
        const slot = field?.querySelector('[data-error]');
        field?.classList.toggle('is-invalid', Boolean(message));
        if (slot) slot.textContent = message || '';
        input.setAttribute('aria-invalid', message ? 'true' : 'false');
        return !message;
    };

    const validators = {
        name: (el) => el.value.trim().length >= 2 || 'Please tell us your name.',
        email: (el) =>
            /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(el.value.trim()) || 'A valid email is required.',
        phone: (el) => {
            const digits = el.value.replace(/\D/g, '');
            return digits.length >= 7 || 'A phone number helps us confirm.';
        },
        date: (el) => {
            if (!el.value) return 'Choose a date.';
            const chosen = new Date(`${el.value}T12:00:00`);
            if (chosen < new Date(new Date().setHours(0, 0, 0, 0))) return 'Please choose a future date.';
            if (chosen.getDay() === 1) return 'We are closed on Mondays — choose another day.';
            return true;
        },
    };

    // Clear errors as the guest types
    qsa('[data-validate]', form).forEach((input) => {
        on(input, 'input', () => setError(input, ''));
        on(input, 'change', () => setError(input, ''));
    });

    on(form, 'submit', (event) => {
        event.preventDefault();

        let valid = true;
        let firstInvalid = null;

        qsa('[data-validate]', form).forEach((input) => {
            const result = validators[input.dataset.validate]?.(input) ?? true;
            const ok = result === true ? true : setError(input, result);
            if (!ok) {
                valid = false;
                firstInvalid = firstInvalid || input;
            }
        });

        const timeSelect = qs('#res-time', form);
        if (timeSelect && !timeSelect.value) {
            setError(timeSelect, 'Choose a time.');
            valid = false;
            firstInvalid = firstInvalid || timeSelect;
        }

        if (!valid) {
            firstInvalid?.focus({ preventScroll: false });
            return;
        }

        const button = qs('button[type="submit"]', form);
        const label = button?.querySelector('span');
        const original = label?.textContent || 'Reserve now';

        if (label) label.textContent = 'Reserving…';
        if (button) button.disabled = true;

        // Simulated network round-trip
        setTimeout(() => {
            const data = new FormData(form);
            const chosenDate = new Date(`${data.get('date')}T12:00:00`);

            qs('[data-modal-name]', modal).textContent = String(data.get('name')).split(' ')[0];
            qs('[data-modal-email]', modal).textContent = String(data.get('email'));
            qs('[data-modal-date]', modal).textContent = chosenDate.toLocaleDateString('en-GB', {
                weekday: 'short',
                day: 'numeric',
                month: 'long',
            });
            qs('[data-modal-time]', modal).textContent = String(data.get('time'));
            qs('[data-modal-guests]', modal).textContent = `${data.get('guests')} ${
                Number(data.get('guests')) > 1 ? 'guests' : 'guest'
            }`;
            qs('[data-modal-room]', modal).textContent = String(data.get('room') || 'Cortile');

            openDialog(modal);

            if (window.gsap && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                window.gsap.fromTo(
                    '[data-modal-name], [data-modal-email]',
                    { opacity: 0, y: 8 },
                    { opacity: 1, y: 0, duration: 0.6, stagger: 0.08, delay: 0.25, ease: 'power2.out' }
                );
            }

            form.reset();
            if (dateInput) dateInput.min = iso(today);
            if (label) label.textContent = original;
            if (button) button.disabled = false;
        }, 850);
    });

    /* Close the confirmation */
    qsa('[data-modal-close]', modal).forEach((button) => on(button, 'click', () => closeDialog(modal)));
    on(modal, 'click', (event) => {
        if (event.target === modal) closeDialog(modal);
    });
    on(document, 'keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) closeDialog(modal);
    });
}
