/**
 * CORTILE — order simulation.
 * One source of truth (state) drives the inline summary, the drawer, the
 * header badge and the confirmation modal. Persisted in localStorage.
 */

import {
    qs,
    qsa,
    on,
    formatEUR,
    openDialog,
    closeDialog,
    trapFocus,
    toast,
} from './utils.js';

const STORAGE_KEY = 'cortile.order.v1';
const DELIVERY_FEE = 4.9;
const FREE_DELIVERY_FROM = 45;

const ICONS = {
    bag: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5.5 8h13l-1 12h-11z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/></svg>',
    minus: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M5 12h14"/></svg>',
    plus: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>',
    check: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 12.5l5 5 10-11"/></svg>',
};

export function initCart() {
    const drawer = qs('#cartDrawer');
    const scrim = qs('[data-scrim]');
    if (!drawer) return;

    /* Catalogue from the DOM ------------------------------------------------ */
    const catalogue = {};
    qsa('[data-order-item]').forEach((el) => {
        const img = el.querySelector('img');
        const priceText = el.querySelector('.order-item__price')?.textContent || '0';
        catalogue[el.dataset.orderItem] = {
            id: el.dataset.orderItem,
            name: el.querySelector('h3')?.textContent.trim() || '',
            desc: el.querySelector('p')?.textContent.trim() || '',
            price: parseFloat(priceText.replace(/[^\d,.-]/g, '').replace(',', '.')) || 0,
            image: img?.getAttribute('src') || '',
            alt: img?.getAttribute('alt') || '',
        };
    });

    /* State ----------------------------------------------------------------- */
    const saved = readStorage();
    const state = {
        mode: saved?.mode === 'takeaway' ? 'takeaway' : 'delivery',
        lines: saved?.lines && typeof saved.lines === 'object' ? saved.lines : {},
    };

    const modeLabels = { delivery: 'Delivery', takeaway: 'Take away' };

    function readStorage() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null');
        } catch {
            return null;
        }
    }

    function persist() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        } catch {
            /* private mode — the order simply is not remembered */
        }
    }

    const entries = () =>
        Object.entries(state.lines)
            .filter(([id, qty]) => catalogue[id] && qty > 0)
            .map(([id, qty]) => ({ ...catalogue[id], qty }));

    const subtotal = () => entries().reduce((sum, line) => sum + line.price * line.qty, 0);

    const count = () => entries().reduce((sum, line) => sum + line.qty, 0);

    const deliveryFee = () => {
        if (state.mode !== 'delivery') return 0;
        const base = subtotal();
        if (!base) return 0;
        return base >= FREE_DELIVERY_FROM ? 0 : DELIVERY_FEE;
    };

    const total = () => subtotal() + deliveryFee();

    /* -----------------------------------------------------------------------
     * Rendering
     * -------------------------------------------------------------------- */
    const emptyMarkup = `
        <div class="cart__empty">
            <span class="cart__empty-icon">${ICONS.bag}</span>
            <p>Your bag is empty.<br>Add a dish from the menu to begin.</p>
        </div>`;

    function renderDrawer() {
        const body = qs('[data-cart-body]', drawer);
        if (!body) return;

        const lines = entries();

        body.innerHTML = lines.length
            ? lines
                  .map(
                      (line) => `
                <div class="cart-item" data-line="${line.id}">
                    <div class="cart-item__media">
                        <img src="${line.image}" alt="${line.alt}" width="62" height="62" loading="lazy">
                    </div>
                    <div>
                        <p class="cart-item__name">${line.name}</p>
                        <p class="cart-item__price">${formatEUR(line.price)} · each</p>
                    </div>
                    <div class="cart-item__side">
                        <div class="qty">
                            <button type="button" data-qty="-1" data-id="${line.id}" aria-label="One fewer ${line.name}">${ICONS.minus}</button>
                            <span class="qty__value">${line.qty}</span>
                            <button type="button" data-qty="1" data-id="${line.id}" aria-label="One more ${line.name}">${ICONS.plus}</button>
                        </div>
                        <button type="button" class="cart-item__remove" data-remove="${line.id}">Remove</button>
                    </div>
                </div>`
                  )
                  .join('')
            : emptyMarkup;

        qs('[data-cart-subtotal]', drawer).textContent = formatEUR(subtotal());
        qs('[data-cart-fee]', drawer).textContent = formatEUR(deliveryFee());
        qs('[data-cart-total]', drawer).textContent = formatEUR(total());
        qs('[data-cart-fee-label]', drawer).textContent =
            state.mode === 'delivery' ? 'Delivery' : 'Collection';

        qs('[data-checkout]', drawer).disabled = lines.length === 0;
    }

    function renderSummary() {
        const panel = qs('[data-summary]');
        if (!panel) return;

        const lines = entries();
        const container = qs('[data-summary-lines]', panel);

        container.innerHTML = lines.length
            ? lines
                  .map(
                      (line) => `
                <div class="summary-line">
                    <span>${line.qty} × ${line.name}</span>
                    <span>${formatEUR(line.price * line.qty)}</span>
                </div>`
                  )
                  .join('')
            : '<p class="summary__empty">Your bag is empty — add a dish to begin.</p>';

        qs('[data-summary-mode]', panel).textContent = modeLabels[state.mode];
        qs('[data-subtotal]', panel).textContent = formatEUR(subtotal());
        qs('[data-fee]', panel).textContent =
            state.mode === 'delivery' ? formatEUR(deliveryFee()) : 'Free';
        qs('[data-fee-label]', panel).textContent =
            state.mode === 'delivery' ? 'Delivery' : 'Collection';
        qs('[data-total]', panel).textContent = formatEUR(total());
        qs('[data-checkout]', panel).disabled = lines.length === 0;

        qs('[data-fee-note]', panel).textContent =
            state.mode === 'delivery'
                ? 'Free delivery over €45 · within Parma city only.'
                : 'No delivery fee · collect at Via Farini 12.';
    }

    function renderModeButtons() {
        qsa('[data-mode]').forEach((button) => {
            const active = button.dataset.mode === state.mode;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-selected', String(active));
        });
    }

    function renderBadge() {
        const badges = qsa('[data-cart-count]');
        const amount = count();

        badges.forEach((badge) => {
            badge.textContent = String(amount);
            badge.hidden = amount === 0;
            badge.classList.toggle('is-visible', amount > 0);
        });

        qsa('[data-cart-open]').forEach((button) => {
            button.setAttribute('aria-label', amount ? `Open your order (${amount} items)` : 'Open your order');
        });
    }

    function render() {
        renderDrawer();
        renderSummary();
        renderModeButtons();
        renderBadge();
        persist();
    }

    /* -----------------------------------------------------------------------
     * Actions
     * -------------------------------------------------------------------- */
    function setMode(mode) {
        if (!modeLabels[mode]) return;
        state.mode = mode;
        render();
    }

    function add(id) {
        if (!catalogue[id]) return;
        state.lines[id] = (state.lines[id] || 0) + 1;
        render();

        const row = qs(`[data-order-item="${id}"]`);
        if (row) {
            row.classList.add('is-added');
            setTimeout(() => row.classList.remove('is-added'), 1000);
        }

        openDrawer();
        toast(`${catalogue[id].name} added to your order`);
    }

    function changeQty(id, delta) {
        const next = (state.lines[id] || 0) + delta;

        if (next <= 0) {
            delete state.lines[id];
        } else {
            state.lines[id] = next;
        }

        render();
    }

    function remove(id) {
        delete state.lines[id];
        render();
        toast('Item removed');
    }

    function openDrawer() {
        if (scrim) {
            scrim.hidden = false;
            requestAnimationFrame(() => scrim.classList.add('is-visible'));
        }
        openDialog(drawer);
        releaseDrawerFocus = trapFocus(drawer);
    }

    let releaseDrawerFocus = null;

    function closeDrawer() {
        closeDialog(drawer);
        releaseDrawerFocus?.();
        releaseDrawerFocus = null;

        if (scrim) {
            scrim.classList.remove('is-visible');
            setTimeout(() => { scrim.hidden = true; }, 450);
        }
    }

    function checkout() {
        if (!entries().length) return;

        const buttons = qsa('[data-checkout]');
        buttons.forEach((button) => {
            button.disabled = true;
            const label = button.querySelector('span');
            if (label) label.dataset.original = label.textContent;
            if (label) label.textContent = 'Sending…';
        });

        const orderTotal = total();
        const orderMode = modeLabels[state.mode];

        setTimeout(() => {
            buttons.forEach((button) => {
                button.disabled = false;
                const label = button.querySelector('span');
                if (label && label.dataset.original) label.textContent = label.dataset.original;
            });

            const modal = qs('#orderModal');
            if (modal) {
                qs('[data-order-number]', modal).textContent = `#C-${Math.floor(1000 + Math.random() * 8999)}`;
                qs('[data-order-mode]', modal).textContent = orderMode;
                qs('[data-order-total]', modal).textContent = formatEUR(orderTotal);
                qs('[data-order-eta]', modal).textContent =
                    state.mode === 'delivery'
                        ? 'Your courier will arrive in about 30 minutes.'
                        : 'Ready for collection in about 20 minutes.';

                openDialog(modal);
            }

            state.lines = {};
            render();
            closeDrawer();
        }, 900);
    }

    /* -----------------------------------------------------------------------
     * Events
     * -------------------------------------------------------------------- */
    qsa('[data-add]').forEach((button) => {
        on(button, 'click', () => add(button.dataset.add));
    });

    qsa('[data-cart-open]').forEach((button) => on(button, 'click', openDrawer));
    qsa('[data-cart-close]', drawer).forEach((button) => on(button, 'click', closeDrawer));
    on(scrim, 'click', closeDrawer);

    // Mode switches (section + drawer)
    qsa('[data-mode]').forEach((button) => {
        on(button, 'click', () => setMode(button.dataset.mode));
    });

    // Quantity and removal use event delegation so re-renders stay simple
    on(drawer, 'click', (event) => {
        const qtyButton = event.target.closest('[data-qty]');
        if (qtyButton) {
            changeQty(qtyButton.dataset.id, Number(qtyButton.dataset.qty));
            return;
        }

        const removeButton = event.target.closest('[data-remove]');
        if (removeButton) remove(removeButton.dataset.remove);
    });

    qsa('[data-checkout]').forEach((button) => on(button, 'click', checkout));

    // Confirmation modal
    const orderModal = qs('#orderModal');
    if (orderModal) {
        qsa('[data-modal-close]', orderModal).forEach((button) =>
            on(button, 'click', () => closeDialog(orderModal))
        );
        on(orderModal, 'click', (event) => {
            if (event.target === orderModal) closeDialog(orderModal);
        });
        on(document, 'keydown', (event) => {
            if (event.key === 'Escape' && orderModal.classList.contains('is-open')) {
                closeDialog(orderModal);
            }
        });
    }

    on(document, 'keydown', (event) => {
        if (event.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeDrawer();
        }
    });

    // Keep several tabs in sync (nice detail, no backend needed)
    on(window, 'storage', (event) => {
        if (event.key !== STORAGE_KEY) return;
        const next = readStorage();
        if (!next) return;
        state.mode = next.mode === 'takeaway' ? 'takeaway' : 'delivery';
        state.lines = next.lines || {};
        render();
    });

    render();
}
