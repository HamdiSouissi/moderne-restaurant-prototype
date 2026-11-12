<?php
/**
 * STORY / EXPERIENCE — asymmetric editorial block with numbers.
 */
$story = site('story');
?>
<section class="story section" id="story">
    <div class="container">

        <div class="story__grid">

            <div class="story__media" data-story-media>
                <figure class="story__fig story__fig--one" data-parallax="0.10">
                    <div class="frame frame--arch">
                        <?= img($story['image_one']['src'], [
                            'alt'    => $story['image_one']['alt'],
                            'sizes'  => '(max-width: 900px) 80vw, 32vw',
                            'width'  => 1023,
                            'height' => 1537,
                        ]) ?>
                    </div>
                    <figcaption class="figcaption">
                        <span class="figcaption__line" aria-hidden="true"></span>
                        <?= e($story['image_one']['caption']) ?>
                    </figcaption>
                </figure>

                <figure class="story__fig story__fig--two" data-parallax="-0.14">
                    <div class="frame">
                        <?= img($story['image_two']['src'], [
                            'alt'    => $story['image_two']['alt'],
                            'sizes'  => '(max-width: 900px) 55vw, 20vw',
                            'width'  => 1254,
                            'height' => 1254,
                        ]) ?>
                    </div>
                    <figcaption class="figcaption">
                        <span class="figcaption__line" aria-hidden="true"></span>
                        <?= e($story['image_two']['caption']) ?>
                    </figcaption>
                </figure>

                <span class="story__ornament" aria-hidden="true">
                    <svg viewBox="0 0 200 200" fill="none">
                        <circle cx="100" cy="100" r="98" stroke="currentColor" stroke-width=".6" stroke-dasharray="2 5"/>
                        <circle cx="100" cy="100" r="76" stroke="currentColor" stroke-width=".6"/>
                    </svg>
                </span>
            </div>

            <div class="story__body">
                <p class="eyebrow" data-reveal><?= e($story['eyebrow']) ?></p>

                <h2 class="section-title" data-reveal>
                    <?= $story['title'] ?>
                </h2>

                <p class="lead" data-reveal><?= e($story['lead']) ?></p>

                <?php foreach ($story['body'] as $paragraph): ?>
                    <p class="body-text" data-reveal><?= e($paragraph) ?></p>
                <?php endforeach; ?>

                <blockquote class="pullquote" data-reveal>
                    <span class="pullquote__mark" aria-hidden="true">“</span>
                    <?= e($story['quote']) ?>
                </blockquote>

                <a class="link-arrow" href="#chef" data-reveal>
                    <span>Meet the chef</span>
                    <?= icon('arrow-right') ?>
                </a>
            </div>
        </div>

        <ul class="stats" data-stats>
            <?php foreach ($story['stats'] as $stat): ?>
                <li class="stat">
                    <span class="stat__value">
                        <span data-count="<?= e($stat['value']) ?>"><?= e($stat['value']) ?></span><?= e($stat['suffix']) ?>
                    </span>
                    <span class="stat__label"><?= e($stat['label']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
