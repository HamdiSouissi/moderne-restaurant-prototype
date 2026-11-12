<?php
/**
 * CHEF — portrait, story and signature.
 */
$chef = site('chef');
?>
<section class="chef section" id="chef">
    <div class="container chef__grid">

        <div class="chef__media">
            <figure class="chef__portrait" data-parallax="0.06">
                <div class="frame frame--arch frame--gold">
                    <?= img($chef['portrait'], [
                        'alt'    => 'Portrait of chef Luca Marchesi in the kitchen at Cortile',
                        'sizes'  => '(max-width: 900px) 84vw, 40vw',
                        'width'  => 1024,
                        'height' => 1536,
                    ]) ?>
                </div>
            </figure>

            <span class="chef__frame-line" aria-hidden="true"></span>

            <p class="figcaption chef__caption">
                <span class="figcaption__line" aria-hidden="true"></span>
                <?= e($chef['caption']) ?>
            </p>

            <div class="chef__badge" aria-hidden="true">
                <span class="chef__badge-number">36</span>
                <span class="chef__badge-label">mesi di<br>Parmigiano</span>
            </div>
        </div>

        <div class="chef__body">
            <p class="eyebrow" data-reveal><?= e($chef['eyebrow']) ?></p>

            <h2 class="chef__name" data-reveal><?= e($chef['name']) ?></h2>
            <p class="chef__role" data-reveal><?= e($chef['role']) ?></p>

            <div class="chef__text">
                <?php foreach ($chef['body'] as $paragraph): ?>
                    <p class="body-text" data-reveal><?= e($paragraph) ?></p>
                <?php endforeach; ?>
            </div>

            <blockquote class="chef__quote" data-reveal>
                “<?= e($chef['quote']) ?>”
            </blockquote>

            <div class="chef__sign" data-reveal>
                <span class="chef__sign-name"><?= e($chef['signature']) ?></span>
                <svg class="chef__sign-flourish" viewBox="0 0 260 46" fill="none" aria-hidden="true">
                    <path d="M4 32c22-10 44-15 66-14 20 1 26 9 14 13-12 4-27-2-18-10 12-11 42-13 68-15 30-2 58-5 84-2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </div>
</section>
