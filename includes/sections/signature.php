<?php
/**
 * CHEF'S SIGNATURE — full-bleed dish with a floating plaque.
 */
$signature = site('signature');
?>
<section class="signature" id="signature" aria-labelledby="signature-title">
    <div class="signature__media" data-signature-media>
        <?= img($signature['image'], [
            'alt'    => $signature['alt'],
            'class'  => 'signature__img',
            'sizes'  => '100vw',
            'width'  => 1536,
            'height' => 1024,
        ]) ?>
        <span class="signature__shade" aria-hidden="true"></span>
    </div>

    <div class="container signature__content">
        <div class="signature__plaque" data-reveal>
            <p class="eyebrow"><?= e($signature['eyebrow']) ?></p>
            <p class="signature__kicker"><?= e($signature['kicker']) ?></p>
            <h2 class="signature__title" id="signature-title"><?= e($signature['name']) ?></h2>
            <p class="signature__text"><?= e($signature['body']) ?></p>

            <ul class="signature__meta">
                <?php foreach ($signature['meta'] as $meta): ?>
                    <li><?= e($meta) ?></li>
                <?php endforeach; ?>
            </ul>

            <a class="btn btn--primary js-magnetic" href="#reservation">
                <span>Reserve to taste</span>
                <?= icon('arrow-up-right') ?>
            </a>
        </div>
    </div>

    <span class="signature__scroll" aria-hidden="true">Il piatto · 04</span>
</section>
