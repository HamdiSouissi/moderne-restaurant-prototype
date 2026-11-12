<?php
/**
 * HERO — full-screen opening scene.
 */
?>
<section class="hero" id="home" aria-label="Cortile, ristorante in Parma">
    <div class="hero__media" data-hero-media>
        <?= img('hero', [
            'alt'      => 'The light-filled dining room of Cortile in Parma, with travertine arches and linen-set tables',
            'class'    => 'hero__img',
            'sizes'    => '100vw',
            'width'    => 1402,
            'height'   => 1122,
            'priority' => true,
        ]) ?>
        <span class="hero__veil" aria-hidden="true"></span>
        <span class="hero__grain" aria-hidden="true"></span>
    </div>

    <div class="hero__content container">
        <p class="eyebrow" data-hero="eyebrow">
            <span class="eyebrow__dot" aria-hidden="true"></span>
            Ristorante · Parma · dal 2019
        </p>

        <h1 class="hero__title">
            <span class="line"><span class="line__inner" data-hero-line>La luce</span></span>
            <span class="line"><span class="line__inner" data-hero-line><em>ha un sapore.</em></span></span>
        </h1>

        <p class="hero__text" data-hero="text">
            Contemporary Italian cooking in a sunlit courtyard in the heart of Parma.
            Handmade pasta, wood-fired pizza, and a table that is yours for the evening.
        </p>

        <div class="hero__actions" data-hero="actions">
            <a class="btn btn--primary js-magnetic" href="#reservation">
                <span>Reserve a table</span>
                <?= icon('arrow-up-right') ?>
            </a>
            <a class="btn btn--outline" href="#menu">
                <span>Explore the menu</span>
                <span class="btn__circle"><?= icon('arrow-right') ?></span>
            </a>
        </div>
    </div>

    <!-- Rotating seal + vertical caption -->
    <div class="hero__side" aria-hidden="true">
        <span class="hero__caption">Via Farini 12 — Parma</span>
        <div class="seal">
            <svg viewBox="0 0 120 120" class="seal__svg">
                <defs>
                    <path id="sealPath" d="M60,60 m-44,0 a44,44 0 1,1 88,0 a44,44 0 1,1 -88,0"/>
                </defs>
                <text class="seal__text">
                    <textPath href="#sealPath" startOffset="0">Cucina d’autore · Parma · dal 2019 · Cortile · </textPath>
                </text>
            </svg>
            <span class="seal__center">
                <svg viewBox="0 0 40 40" fill="none" aria-hidden="true">
                    <path d="M11 32V17a9 9 0 0 1 18 0v15" stroke="currentColor" stroke-width="1"/>
                    <path d="M6 32h28" stroke="currentColor" stroke-width="1"/>
                </svg>
            </span>
        </div>
    </div>

    <!-- Bottom information strip -->
    <div class="hero__foot container" data-hero="foot">
        <div class="hero__foot-item">
            <?= icon('clock') ?>
            <span><?= e(site('hours_short')) ?></span>
        </div>
        <div class="hero__foot-item hero__foot-item--center">
            <span class="hero__scroll" aria-hidden="true"><span class="hero__scroll-line"></span>Scroll</span>
        </div>
        <div class="hero__foot-item hero__foot-item--end">
            <?= stars(5) ?>
            <span>4.9 — 428 reviews</span>
        </div>
    </div>
</section>

<!-- Editorial marquee -->
<div class="marquee" aria-hidden="true">
    <div class="marquee__track" data-marquee>
        <?php
        $words = ['Pasta fatta a mano', 'Forno a legna', 'Produttori emiliani', 'Cortile di luce', 'Vini del territorio', 'Dolce vita'];
        // Duplicated twice for a seamless loop.
        for ($pass = 0; $pass < 2; $pass++):
            foreach ($words as $word): ?>
                <span class="marquee__word"><?= e($word) ?></span>
                <span class="marquee__sep"><?= icon('sparkle') ?></span>
            <?php endforeach;
        endfor; ?>
    </div>
</div>
