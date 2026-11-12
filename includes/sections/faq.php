<?php
/**
 * FAQ — accessible accordion (buttons + aria-expanded).
 */
$faq = site('faq');
?>
<section class="faq section" id="faq">
    <div class="container faq__grid">

        <div class="faq__aside">
            <p class="eyebrow" data-reveal><?= e($faq['eyebrow']) ?></p>
            <h2 class="section-title" data-reveal><?= $faq['title'] ?></h2>
            <p class="body-text" data-reveal><?= e($faq['lead']) ?></p>

            <a class="faq__call" href="tel:<?= e(site('contact.phone_href')) ?>" data-reveal>
                <span class="round-btn"><?= icon('phone') ?></span>
                <span>
                    <span class="label">Call the restaurant</span>
                    <span class="faq__phone"><?= e(site('contact.phone')) ?></span>
                </span>
            </a>
        </div>

        <div class="accordion" data-accordion>
            <?php foreach ($faq['items'] as $index => $item): ?>
                <div class="accordion__item">
                    <h3 class="accordion__heading">
                        <button class="accordion__trigger" type="button"
                                aria-expanded="false"
                                aria-controls="faq-panel-<?= $index ?>"
                                id="faq-trigger-<?= $index ?>">
                            <span class="accordion__index"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                            <span class="accordion__question"><?= e($item['q']) ?></span>
                            <span class="accordion__icon" aria-hidden="true">
                                <span></span><span></span>
                            </span>
                        </button>
                    </h3>
                    <div class="accordion__panel" id="faq-panel-<?= $index ?>"
                         role="region" aria-labelledby="faq-trigger-<?= $index ?>">
                        <div class="accordion__inner">
                            <p><?= e($item['a']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
