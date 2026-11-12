<?php
/**
 * MENU — filterable gastronomic cards.
 */
$menu = site('menu');
$categories = $menu['categories'];

$total = 0;
foreach ($categories as $category) {
    $total += count($category['items']);
}
?>
<section class="menu section" id="menu">
    <div class="container">

        <div class="menu__head">
            <div class="menu__head-main">
                <p class="eyebrow" data-reveal>02 — Il menu</p>
                <h2 class="section-title" data-reveal>
                    Made by hand,<br>served with <em>light</em>.
                </h2>
            </div>
            <div class="menu__head-aside">
                <p class="body-text" data-reveal><?= e($menu['intro']) ?></p>
                <p class="menu__hint" data-reveal>
                    <span aria-hidden="true"><?= icon('leaf') ?></span>
                    Menu changed with the market — 6 courses, 42 seats.
                </p>
            </div>
        </div>

        <!-- Category filter -->
        <div class="filters" role="tablist" aria-label="Menu categories" data-filters>
            <button class="filter is-active" role="tab" aria-selected="true" data-filter="all" type="button">
                <span>All</span><span class="filter__count"><?= $total ?></span>
            </button>
            <?php foreach ($categories as $key => $category): ?>
                <button class="filter" role="tab" aria-selected="false" data-filter="<?= e($key) ?>" type="button">
                    <span><?= e($category['label']) ?></span>
                    <span class="filter__count"><?= count($category['items']) ?></span>
                </button>
            <?php endforeach; ?>
            <span class="filters__indicator" data-filter-indicator aria-hidden="true"></span>
        </div>

        <!-- Dishes -->
        <div class="menu__grid" data-menu-grid>
            <?php foreach ($categories as $key => $category): ?>
                <?php foreach ($category['items'] as $item):
                    $wide = count($category['items']) === 1; ?>
                    <article class="dish<?= $wide ? ' dish--wide' : '' ?>" data-dish data-category="<?= e($key) ?>">
                        <div class="dish__media">
                            <a class="dish__zoom" href="#" aria-hidden="true" tabindex="-1">
                                <?= img($item['image'], [
                                    'alt'    => $item['alt'],
                                    'sizes'  => '(max-width: 700px) 90vw, (max-width: 1200px) 45vw, 30vw',
                                    'width'  => 1254,
                                    'height' => 1254,
                                ]) ?>
                            </a>
                            <?php if (!empty($item['badge'])): ?>
                                <span class="badge"><?= e($item['badge']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="dish__body">
                            <span class="dish__category"><?= e($category['italian']) ?></span>
                            <div class="dish__row">
                                <h3 class="dish__name"><?= e($item['name']) ?></h3>
                                <span class="dish__price">€ <?= e($item['price']) ?></span>
                            </div>
                            <p class="dish__desc"><?= e($item['desc']) ?></p>

                            <div class="dish__footer">
                                <?php if (!empty($item['tags'])): ?>
                                    <span class="dish__tag"><?= e($item['tags'][0]) ?></span>
                                <?php else: ?>
                                    <span class="dish__tag dish__tag--muted">From the kitchen</span>
                                <?php endif; ?>

                                <?php if (!empty($item['order_id'])): ?>
                                    <button class="dish__add" type="button"
                                            data-add="<?= e($item['order_id']) ?>"
                                            aria-label="Add <?= e($item['name']) ?> to your order">
                                        <?= icon('plus') ?>
                                        <span>Add</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>

        <div class="menu__foot">
            <p class="menu__note">
                Prices in euros, VAT included. Please tell us about allergies — the kitchen will adapt.
            </p>
            <a class="link-arrow" href="#order">
                <span>Order at home</span>
                <?= icon('arrow-right') ?>
            </a>
        </div>
    </div>
</section>
