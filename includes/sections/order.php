<?php
/**
 * ONLINE ORDER — delivery / take-away simulation, cart handled in JS.
 */
$order = site('order');
$modes = $order['modes'];
$firstMode = array_key_first($modes);
?>
<section class="order section" id="order">
    <div class="container">

        <div class="order__head">
            <div>
                <p class="eyebrow" data-reveal><?= e($order['eyebrow']) ?></p>
                <h2 class="section-title" data-reveal><?= $order['title'] ?></h2>
            </div>
            <p class="body-text order__lead" data-reveal><?= e($order['lead']) ?></p>
        </div>

        <div class="modes" role="tablist" aria-label="Order type" data-modes>
            <?php foreach ($modes as $key => $mode): ?>
                <button class="mode<?= $key === $firstMode ? ' is-active' : '' ?>"
                        type="button" role="tab"
                        aria-selected="<?= $key === $firstMode ? 'true' : 'false' ?>"
                        data-mode="<?= e($key) ?>">
                    <span class="mode__icon" aria-hidden="true"><?= icon($key === 'delivery' ? 'scooter' : 'bag') ?></span>
                    <span class="mode__text">
                        <span class="mode__label"><?= e($mode['label']) ?></span>
                        <span class="mode__note"><?= e($mode['note']) ?></span>
                    </span>
                    <span class="mode__check" aria-hidden="true"><?= icon('check') ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="order__layout">

            <div class="order__list">
                <?php foreach ($order['items'] as $item): ?>
                    <article class="order-item" data-order-item="<?= e($item['id']) ?>">
                        <div class="order-item__media">
                            <?= img($item['image'], [
                                'alt'    => $item['name'],
                                'sizes'  => '120px',
                                'width'  => 1254,
                                'height' => 1254,
                            ]) ?>
                        </div>
                        <div class="order-item__body">
                            <h3><?= e($item['name']) ?></h3>
                            <p><?= e($item['desc']) ?></p>
                        </div>
                        <span class="order-item__price">€ <?= e(price($item['price'])) ?></span>
                        <button class="order-item__add" type="button"
                                data-add="<?= e($item['id']) ?>"
                                aria-label="Add <?= e($item['name']) ?> to your order">
                            <?= icon('plus') ?>
                        </button>
                    </article>
                <?php endforeach; ?>

                <p class="order__allergens">
                    <?= icon('leaf') ?>
                    All dishes are prepared in a kitchen that handles gluten, eggs, dairy and nuts.
                </p>
            </div>

            <aside class="summary card" aria-label="Order summary" data-summary>
                <div class="summary__head">
                    <h3>Your order</h3>
                    <span class="summary__mode" data-summary-mode>Delivery</span>
                </div>

                <div class="summary__lines" data-summary-lines>
                    <p class="summary__empty">Your bag is empty — add a dish to begin.</p>
                </div>

                <div class="summary__totals">
                    <div class="summary__row">
                        <span>Subtotal</span>
                        <span data-subtotal>€ 0,00</span>
                    </div>
                    <div class="summary__row">
                        <span data-fee-label>Delivery</span>
                        <span data-fee>€ 4,90</span>
                    </div>
                    <div class="summary__row summary__row--total">
                        <span>Total</span>
                        <span data-total>€ 0,00</span>
                    </div>
                </div>

                <button class="btn btn--primary btn--full" type="button" data-checkout disabled>
                    <span>Checkout</span>
                    <?= icon('arrow-up-right') ?>
                </button>

                <p class="summary__note" data-fee-note>Free delivery over €45 · within Parma city only.</p>
            </aside>
        </div>
    </div>
</section>
