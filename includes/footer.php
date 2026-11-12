<?php
/**
 * FOOTER — newsletter, navigation, socials, legal line.
 */
$footer = site('footer');
?>
<footer class="footer">
    <div class="container">

        <!-- Newsletter -->
        <div class="footer__news">
            <div class="footer__news-head">
                <p class="eyebrow">Lettera</p>
                <h2 class="footer__news-title"><?= e($footer['newsletter_title']) ?></h2>
                <p class="footer__news-text"><?= e($footer['newsletter_text']) ?></p>
            </div>

            <form class="newsletter" data-newsletter novalidate>
                <div class="newsletter__field">
                    <label class="sr-only" for="newsletter-email">Email address</label>
                    <input class="newsletter__input" id="newsletter-email" type="email" name="email"
                           placeholder="Your email address" autocomplete="email" required>
                    <button class="newsletter__submit js-magnetic" type="submit" aria-label="Subscribe to the newsletter">
                        <?= icon('arrow-right') ?>
                    </button>
                </div>
                <span class="newsletter__error" data-newsletter-error></span>
                <p class="newsletter__success" data-newsletter-success hidden>
                    <?= icon('check') ?> Grazie — your first letter arrives with the new menu.
                </p>
                <p class="newsletter__legal">Four letters a year. No noise, unsubscribe anytime.</p>
            </form>
        </div>

        <!-- Columns -->
        <div class="footer__main">
            <div class="footer__brand">
                <a class="brand brand--footer" href="#home" aria-label="Cortile — back to top">
                    <span class="brand__name">Cortile</span>
                    <span class="brand__sub">Ristorante · Parma · dal 2019</span>
                </a>
                <p class="footer__address">
                    <?= e(site('contact.street')) ?><br>
                    <?= e(site('contact.postcode')) ?> <?= e(site('contact.city')) ?>, Italia
                </p>
                <div class="footer__socials">
                    <a href="<?= e(site('contact.instagram')) ?>" target="_blank" rel="noopener" aria-label="Cortile on Instagram"><?= icon('instagram') ?></a>
                    <a href="<?= e(site('contact.facebook')) ?>" target="_blank" rel="noopener" aria-label="Cortile on Facebook"><?= icon('facebook') ?></a>
                    <a href="<?= e(site('contact.pinterest')) ?>" target="_blank" rel="noopener" aria-label="Cortile on Pinterest"><?= icon('pinterest') ?></a>
                </div>
            </div>

            <nav class="footer__nav" aria-label="Footer">
                <?php foreach ($footer['columns'] as $column): ?>
                    <div class="footer__col">
                        <span class="label"><?= e($column['title']) ?></span>
                        <ul>
                            <?php foreach ($column['links'] as $link): ?>
                                <li><a href="<?= e($link['href']) ?>"><?= e($link['label']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </nav>

            <div class="footer__contact">
                <span class="label">Write / call</span>
                <a class="footer__phone" href="tel:<?= e(site('contact.phone_href')) ?>"><?= e(site('contact.phone')) ?></a>
                <a href="mailto:<?= e(site('contact.email')) ?>"><?= e(site('contact.email')) ?></a>
                <a class="link-arrow link-arrow--small" href="#reservation">
                    <span>Reserve a table</span>
                    <?= icon('arrow-right') ?>
                </a>
            </div>
        </div>

        <!-- Giant wordmark -->
        <div class="footer__wordmark" aria-hidden="true">Cortile</div>

        <!-- Legal -->
        <div class="footer__legal">
            <p>© <?= date('Y') ?> <?= e(site('brand.legal_name')) ?> — <?= e(site('brand.vat')) ?></p>
            <p class="footer__credits"><?= e($footer['credits']) ?></p>
            <a class="footer__top" href="#home">
                <span>Back to top</span>
                <span class="footer__top-icon"><?= icon('arrow-up-right') ?></span>
            </a>
        </div>
    </div>
</footer>
