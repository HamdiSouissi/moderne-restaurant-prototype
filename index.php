<?php
/**
 * =============================================================================
 *  CORTILE — Ristorante, Parma
 *  One-page restaurant website · PHP native, no database
 * =============================================================================
 *
 *  Structure
 *  ├── config/site.php        All content (identity, menu, hours, FAQ…)
 *  ├── includes/functions.php Template helpers (escape, assets, images, icons)
 *  ├── includes/sections/     One file per section, easy to reorder or remove
 *  ├── assets/css/            base / components / sections / responsive
 *  └── assets/js/             Vanilla JS modules + GSAP, Lenis, Swiper
 *
 *  Every interactive feature (reservation, order, newsletter) is simulated
 *  on the front end: no database, no admin, no authentication.
 *
 *  @package Cortile
 *  @version 1.0.0
 * =============================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <?php require __DIR__ . '/includes/head.php'; ?>
</head>

<body>
    <?php require __DIR__ . '/includes/header.php'; ?>

    <main id="main">

        <?php
        /**
         * Sections — order defines the narrative of the page.
         */
        require __DIR__ . '/includes/sections/hero.php';
        require __DIR__ . '/includes/sections/story.php';
        require __DIR__ . '/includes/sections/menu.php';
        require __DIR__ . '/includes/sections/chef.php';
        require __DIR__ . '/includes/sections/signature.php';
        require __DIR__ . '/includes/sections/gallery.php';
        require __DIR__ . '/includes/sections/reservation.php';
        require __DIR__ . '/includes/sections/order.php';
        require __DIR__ . '/includes/sections/testimonials.php';
        require __DIR__ . '/includes/sections/faq.php';
        require __DIR__ . '/includes/sections/contact.php';
        ?>
    </main>

    <?php require __DIR__ . '/includes/footer.php'; ?>
    <?php require __DIR__ . '/includes/ui.php'; ?>

    <!-- Vendors (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.20/dist/lenis.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <!-- Application -->
    <script src="<?= e(asset('assets/js/app.js')) ?>" type="module"></script>
</body>
</html>
