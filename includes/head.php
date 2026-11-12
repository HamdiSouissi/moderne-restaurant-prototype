<?php
/**
 * <head> — meta, fonts, styles, structured data.
 */
$description = 'Cortile — contemporary Italian restaurant in the heart of Parma. Handmade pasta, wood-fired pizza and a courtyard bathed in light. Reserve a table.';
$ogImage = 'assets/img/hero-1024.jpg';
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cortile — Ristorante, Parma</title>
<meta name="description" content="<?= e($description) ?>">
<meta name="theme-color" content="#FAF8F5">
<meta name="author" content="Cortile">

<!-- Open Graph / social sharing -->
<meta property="og:type" content="restaurant">
<meta property="og:title" content="Cortile — Ristorante, Parma">
<meta property="og:description" content="<?= e($description) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:locale" content="en_GB">
<meta name="twitter:card" content="summary_large_image">

<!-- Favicon: a small arch, drawn inline so no extra request is needed -->
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%23FAF8F5'/%3E%3Cpath d='M9 26V15a7 7 0 0 1 14 0v11' fill='none' stroke='%23B9925B' stroke-width='1.6'/%3E%3Cpath d='M6 26h20' stroke='%231F1F1F' stroke-width='1.2'/%3E%3C/svg%3E">

<!-- Typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Manrope:wght@300;400;500;600;700&display=swap">

<!-- Swiper (gallery / testimonials) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Site styles, split by concern -->
<link rel="stylesheet" href="<?= e(asset('assets/css/base.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/components.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/sections.css')) ?>">
<link rel="stylesheet" href="<?= e(asset('assets/css/responsive.css')) ?>">

<!-- The hero image is the LCP element: fetch it immediately -->
<link rel="preload" as="image" href="assets/img/hero-1024.jpg" imagesrcset="assets/img/hero-480.jpg 480w, assets/img/hero-768.jpg 768w, assets/img/hero-1024.jpg 1024w" imagesizes="100vw" fetchpriority="high">

<!-- Remove the no-js flag as early as possible (avoids FOUC of animated states) -->
<script>document.documentElement.classList.remove('no-js');document.documentElement.classList.add('js');</script>

<!-- Structured data: helps the restaurant appear correctly in search results -->
<script type="application/ld+json">
<?= json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'Restaurant',
    'name'            => 'Cortile',
    'servesCuisine'   => 'Italian',
    'priceRange'      => '€€€',
    'telephone'       => site('contact.phone'),
    'email'           => site('contact.email'),
    'address'         => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => site('contact.street'),
        'addressLocality' => site('contact.city'),
        'postalCode'      => site('contact.postcode'),
        'addressRegion'   => site('contact.region'),
        'addressCountry'  => 'IT',
    ],
    'openingHoursSpecification' => [
        ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Tuesday', 'Wednesday', 'Thursday'], 'opens' => '12:30', 'closes' => '23:00'],
        ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Friday', 'Saturday'], 'opens' => '12:30', 'closes' => '23:30'],
        ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => 'Sunday', 'opens' => '12:30', 'closes' => '15:30'],
    ],
    'image' => 'assets/img/hero-1024.jpg',
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>
