<?php
/**
 * GALLERY — magazine grid + lightbox trigger.
 * Each shot is a <button> so it is reachable by keyboard.
 */
$gallery = site('gallery');
?>
<section class="gallery section" id="gallery">
    <div class="container">

        <div class="gallery__head">
            <div>
                <p class="eyebrow" data-reveal><?= e($gallery['eyebrow']) ?></p>
                <h2 class="section-title" data-reveal><?= $gallery['title'] ?></h2>
            </div>
            <p class="gallery__hint" data-reveal>
                <span class="gallery__hint-icon" aria-hidden="true"><?= icon('plus') ?></span>
                Click any image to open the gallery
            </p>
        </div>

        <div class="gallery__grid" data-gallery>
            <?php foreach ($gallery['items'] as $index => $item): ?>
                <button class="shot shot--<?= e($item['shape']) ?>"
                        type="button"
                        data-lightbox="<?= $index ?>"
                        data-caption="<?= e($item['caption']) ?>"
                        aria-label="Open image: <?= e($item['caption']) ?>">
                    <span class="shot__media">
                        <?= img($item['src'], [
                            'alt'    => $item['alt'],
                            'sizes'  => '(max-width: 900px) 90vw, (max-width: 1200px) 50vw, 34vw',
                            'width'  => 1254,
                            'height' => 1254,
                        ]) ?>
                    </span>
                    <span class="shot__overlay" aria-hidden="true">
                        <span class="shot__zoom"><?= icon('plus') ?></span>
                    </span>
                    <span class="shot__caption">
                        <span class="shot__index"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        <?= e($item['caption']) ?>
                    </span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
