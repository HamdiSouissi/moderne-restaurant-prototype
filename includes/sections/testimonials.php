<?php
/**
 * TESTIMONIALS — Swiper carousel with monogram medallions.
 */
$testimonials = site('testimonials');
?>
<section class="testimonials section" id="testimonials">
    <span class="testimonials__word" aria-hidden="true">Ospiti</span>

    <div class="container">
        <div class="testimonials__head">
            <div>
                <p class="eyebrow" data-reveal><?= e($testimonials['eyebrow']) ?></p>
                <h2 class="section-title" data-reveal><?= $testimonials['title'] ?></h2>
            </div>

            <div class="testimonials__controls" data-reveal>
                <div class="swiper-fraction">
                    <span data-swiper-current>01</span>
                    <span class="swiper-fraction__sep" aria-hidden="true"></span>
                    <span data-swiper-total><?= str_pad((string) count($testimonials['items']), 2, '0', STR_PAD_LEFT) ?></span>
                </div>
                <button class="round-btn" type="button" data-swiper-prev aria-label="Previous testimonial">
                    <?= icon('arrow-left') ?>
                </button>
                <button class="round-btn" type="button" data-swiper-next aria-label="Next testimonial">
                    <?= icon('arrow-right') ?>
                </button>
            </div>
        </div>
    </div>

    <div class="swiper testimonials__swiper">
        <div class="swiper-wrapper">
            <?php foreach ($testimonials['items'] as $item): ?>
                <article class="swiper-slide testimonial">
                    <div class="testimonial__quote-mark" aria-hidden="true"><?= icon('quote') ?></div>
                    <?= stars((int) $item['stars']) ?>
                    <blockquote class="testimonial__text"><?= e($item['quote']) ?></blockquote>
                    <footer class="testimonial__footer">
                        <span class="testimonial__avatar" aria-hidden="true"><?= e(initials($item['name'])) ?></span>
                        <div class="testimonial__person">
                            <span class="testimonial__name"><?= e($item['name']) ?></span>
                            <span class="testimonial__meta"><?= e($item['meta']) ?></span>
                        </div>
                        <span class="testimonial__source"><?= e($item['source']) ?></span>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container">
        <div class="testimonials__foot">
            <span class="testimonials__score">4.9<span>/5</span></span>
            <p>Four hundred and twenty-eight guests have left a note this year. These are a few of them.</p>
        </div>
    </div>
</section>
