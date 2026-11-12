<?php
/**
 * Header + mobile navigation.
 * Transparent over the hero, frosted ivory after scrolling (see components.css).
 */
?>
<a class="skip-link" href="#main">Skip to content</a>

<!-- Scroll progress -->
<div class="progress" aria-hidden="true"><span class="progress__bar" data-progress></span></div>

<header class="header" data-header>
    <div class="header__inner container">

        <a class="brand" href="#home" aria-label="Cortile — back to top">
            <span class="brand__mark" aria-hidden="true">
                <svg viewBox="0 0 40 40" fill="none" aria-hidden="true">
                    <path d="M9 34V16a11 11 0 0 1 22 0v18" stroke="currentColor" stroke-width="1.1"/>
                    <path d="M4 34h32" stroke="currentColor" stroke-width="1.1"/>
                    <path d="M15 34V18a5 5 0 0 1 10 0v16" stroke="currentColor" stroke-width=".7" opacity=".55"/>
                </svg>
            </span>
            <span class="brand__text">
                <span class="brand__name">Cortile</span>
                <span class="brand__sub">Ristorante · Parma</span>
            </span>
        </a>

        <nav class="nav" aria-label="Primary">
            <ul class="nav__list">
                <?php foreach (site('nav') as $item): ?>
                    <li class="nav__item">
                        <a class="nav__link" href="<?= e($item['href']) ?>" data-nav="<?= e($item['id']) ?>">
                            <span data-text="<?= e($item['label']) ?>"><?= e($item['label']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="header__actions">
            <a class="btn btn--header magnetic js-magnetic" href="#reservation">
                <span>Reserve a table</span>
                <?= icon('arrow-up-right') ?>
            </a>

            <button class="header__cart" type="button" data-cart-open aria-label="Open your order">
                <?= icon('bag') ?>
                <span class="header__cart-count" data-cart-count hidden>0</span>
            </button>

            <button class="burger" type="button" data-menu-toggle aria-expanded="false" aria-controls="mobileNav" aria-label="Open menu">
                <span></span><span></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile / tablet navigation overlay -->
<div class="mobile-nav" id="mobileNav" aria-hidden="true">
    <div class="mobile-nav__inner">
        <p class="eyebrow mobile-nav__eyebrow">Menu</p>
        <nav aria-label="Mobile">
            <ul class="mobile-nav__list">
                <?php foreach (site('nav') as $i => $item): ?>
                    <li>
                        <a href="<?= e($item['href']) ?>" data-mobile-link>
                            <span class="mobile-nav__index"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                            <span><?= e($item['label']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="mobile-nav__foot">
            <a class="btn btn--primary btn--full" href="#reservation" data-mobile-link>
                <span>Reserve a table</span>
                <?= icon('arrow-up-right') ?>
            </a>

            <div class="mobile-nav__footer">
                <div>
                    <span class="label">Find us</span>
                    <p><?= e(site('contact.street')) ?><br><?= e(site('contact.postcode')) ?> <?= e(site('contact.city')) ?></p>
                </div>
                <div>
                    <span class="label">Call</span>
                    <p><a href="tel:<?= e(site('contact.phone_href')) ?>"><?= e(site('contact.phone')) ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
