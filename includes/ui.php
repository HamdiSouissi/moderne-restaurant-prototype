<?php
/**
 * UI layer: loader, cursor, cart drawer, lightbox, modal, toast.
 * Kept at the end of the document so the main content paints first.
 */
$modes = site('order.modes');
?>
<!-- Loading screen -->
<div class="loader" id="loader">
    <div class="loader__inner">
        <div class="loader__brand">
            <svg class="loader__mark" viewBox="0 0 40 40" fill="none" aria-hidden="true">
                <path d="M9 34V16a11 11 0 0 1 22 0v18" stroke="currentColor" stroke-width="1"/>
                <path d="M4 34h32" stroke="currentColor" stroke-width="1"/>
            </svg>
            <span class="loader__name">Cortile</span>
        </div>
        <div class="loader__line"><span class="loader__bar" data-loader-bar></span></div>
        <div class="loader__meta">
            <span>Parma · Emilia-Romagna</span>
            <span class="loader__count" data-loader-count>00</span>
        </div>
    </div>
</div>

<!-- Custom cursor (desktop only) -->
<div class="cursor" data-cursor aria-hidden="true">
    <span class="cursor__dot"></span>
    <span class="cursor__ring"><span class="cursor__label" data-cursor-label></span></span>
</div>

<!-- Order drawer -->
<div class="scrim" data-scrim hidden></div>
<aside class="cart" id="cartDrawer" role="dialog" aria-modal="true" aria-labelledby="cartTitle" aria-hidden="true" hidden>
    <div class="cart__head">
        <div>
            <p class="eyebrow">A casa</p>
            <h2 class="cart__title" id="cartTitle">Your order</h2>
        </div>
        <button class="round-btn cart__close" type="button" data-cart-close aria-label="Close your order">
            <?= icon('close') ?>
        </button>
    </div>

    <div class="cart__mode" data-cart-mode>
        <?php foreach ($modes as $key => $mode): ?>
            <button class="cart__mode-btn<?= $key === 'delivery' ? ' is-active' : '' ?>" type="button" data-mode="<?= e($key) ?>">
                <?= e($mode['label']) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="cart__body" data-cart-body></div>

    <div class="cart__foot">
        <div class="cart__totals">
            <div class="cart__row"><span>Subtotal</span><span data-cart-subtotal>€ 0,00</span></div>
            <div class="cart__row"><span data-cart-fee-label>Delivery</span><span data-cart-fee>€ 4,90</span></div>
            <div class="cart__row cart__row--total"><span>Total</span><span data-cart-total>€ 0,00</span></div>
        </div>
        <button class="btn btn--primary btn--full" type="button" data-checkout>
            <span>Checkout</span>
            <?= icon('arrow-up-right') ?>
        </button>
        <p class="cart__note">Front-end demonstration — no order is actually placed.</p>
    </div>
</aside>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Gallery viewer" aria-hidden="true" hidden>
    <div class="lightbox__head">
        <span class="lightbox__caption" data-lightbox-caption></span>
        <span class="lightbox__count" data-lightbox-counter></span>
        <button class="round-btn" type="button" data-lightbox-close aria-label="Close gallery">
            <?= icon('close') ?>
        </button>
    </div>

    <div class="lightbox__stage">
        <button class="lightbox__nav lightbox__nav--prev" type="button" data-lightbox-prev aria-label="Previous image">
            <?= icon('arrow-left') ?>
        </button>
        <figure class="lightbox__figure">
            <img class="lightbox__img" data-lightbox-img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="" width="1800" height="1200">
        </figure>
        <button class="lightbox__nav lightbox__nav--next" type="button" data-lightbox-next aria-label="Next image">
            <?= icon('arrow-right') ?>
        </button>
    </div>

    <p class="lightbox__hint">Use ← → to browse · Esc to close · click the image to zoom</p>
</div>

<!-- Reservation confirmation modal -->
<div class="modal" id="reserveModal" role="dialog" aria-modal="true" aria-labelledby="reserveModalTitle" aria-hidden="true" hidden>
    <div class="modal__box">
        <button class="round-btn modal__close" type="button" data-modal-close aria-label="Close">
            <?= icon('close') ?>
        </button>

        <div class="modal__icon" aria-hidden="true">
            <svg viewBox="0 0 64 64" fill="none">
                <circle cx="32" cy="32" r="31" stroke="currentColor" stroke-width="1"/>
                <path d="M20 33l8 8 16-18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <p class="eyebrow eyebrow--center">Prenotazione confermata</p>
        <h2 class="modal__title" id="reserveModalTitle">Grazie, <span data-modal-name>ospite</span>.</h2>
        <p class="modal__text">Your table is held. A confirmation is on its way to <span data-modal-email>your inbox</span>.</p>

        <dl class="modal__details">
            <div><dt>Date</dt><dd data-modal-date>—</dd></div>
            <div><dt>Time</dt><dd data-modal-time>—</dd></div>
            <div><dt>Guests</dt><dd data-modal-guests>—</dd></div>
            <div><dt>Room</dt><dd data-modal-room>—</dd></div>
        </dl>

        <p class="modal__note">
            <?= icon('pin') ?>
            <?= e(site('contact.street')) ?>, <?= e(site('contact.city')) ?> — we look forward to it.
        </p>

        <button class="btn btn--primary btn--full" type="button" data-modal-close>Close</button>
    </div>
</div>

<!-- Order confirmation modal -->
<div class="modal modal--order" id="orderModal" role="dialog" aria-modal="true" aria-labelledby="orderModalTitle" aria-hidden="true" hidden>
    <div class="modal__box">
        <button class="round-btn modal__close" type="button" data-modal-close aria-label="Close">
            <?= icon('close') ?>
        </button>

        <div class="modal__icon" aria-hidden="true">
            <?= icon('check') ?>
        </div>

        <p class="eyebrow eyebrow--center">Ordine ricevuto</p>
        <h2 class="modal__title" id="orderModalTitle">In the kitchen.</h2>
        <p class="modal__text">
            Order <strong data-order-number>#C-0000</strong> is being prepared.
            <span data-order-eta>Your courier will arrive in 30 minutes.</span>
        </p>

        <dl class="modal__details">
            <div><dt>Mode</dt><dd data-order-mode>Delivery</dd></div>
            <div><dt>Total</dt><dd data-order-total>€ 0,00</dd></div>
        </dl>

        <p class="modal__note"><?= icon('phone') ?> We will call you if the kitchen needs anything.</p>
        <button class="btn btn--primary btn--full" type="button" data-modal-close>Back to the table</button>
    </div>
</div>

<!-- Toast -->
<div class="toast" data-toast role="status" aria-live="polite">
    <span class="toast__icon" aria-hidden="true"><?= icon('check') ?></span>
    <span class="toast__text" data-toast-text></span>
</div>
