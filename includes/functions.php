<?php
/**
 * -----------------------------------------------------------------------------
 *  CORTILE — Helper functions
 * -----------------------------------------------------------------------------
 *  Small, dependency-free helpers used by the templates.
 *
 *  @package Cortile
 * -----------------------------------------------------------------------------
 */

declare(strict_types=1);

/**
 * Read a value from the site configuration using dot notation.
 * Example: site('contact.phone')
 */
function site(string $path, mixed $default = null): mixed
{
    static $config = null;

    if ($config === null) {
        $config = require __DIR__ . '/../config/site.php';
    }

    $value = $config;

    foreach (explode('.', $path) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

/**
 * Escape strings before printing them in HTML.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Build a public asset URL with a lightweight cache-busting query string.
 */
function asset(string $path): string
{
    $file = __DIR__ . '/../' . ltrim($path, '/');
    $version = is_file($file) ? (string) filemtime($file) : '1';

    return $path . '?v=' . $version;
}

/**
 * Responsive image markup.
 *
 * Variants are produced by tools/build-images.sh (480 / 800 / 1200 / 1800 px).
 * Passing width/height keeps the layout stable while the image loads.
 *
 * @param string $name  File stem inside assets/img (e.g. "hero")
 * @param array{
 *     alt?: string, class?: string, sizes?: string, width?: int, height?: int,
 *     priority?: bool, ratio?: string, caption?: bool
 * } $opts
 */
function img(string $name, array $opts = []): string
{
    // Variant widths are produced by tools/build-images.sh and listed in the
    // manifest, so small photographs are never upscaled.
    static $manifest = null;
    if ($manifest === null) {
        $file = __DIR__ . '/../assets/img/manifest.json';
        $manifest = is_file($file) ? (json_decode((string) file_get_contents($file), true) ?: []) : [];
    }

    $widths = $manifest[$name] ?? [480, 768, 1024];

    // Safety net: ignore variants that are not on disk (e.g. a new photo
    // added without running the build script).
    $widths = array_values(array_filter(
        $widths,
        static fn (int $w): bool => is_file(__DIR__ . '/../assets/img/' . $name . '-' . $w . '.jpg')
    ));
    if ($widths === []) {
        $widths = [480];
    }

    $alt      = $opts['alt'] ?? '';
    $class    = $opts['class'] ?? '';
    $sizes    = $opts['sizes'] ?? '(max-width: 900px) 100vw, 50vw';
    $width    = $opts['width'] ?? 1200;
    $height   = $opts['height'] ?? 1200;
    $priority = $opts['priority'] ?? false;

    // Default source: the smallest variant at least 700px wide, else the largest.
    $fallback = $widths[count($widths) - 1];
    foreach ($widths as $w) {
        if ($w >= 700) { $fallback = $w; break; }
    }

    $srcset = [];
    foreach ($widths as $w) {
        $srcset[] = 'assets/img/' . $name . '-' . $w . '.jpg ' . $w . 'w';
    }

    $attrs = [
        'src'         => asset('assets/img/' . $name . '-' . $fallback . '.jpg'),
        'srcset'      => implode(', ', $srcset),
        'sizes'       => $sizes,
        'alt'         => $alt,
        'width'       => (int) $width,
        'height'      => (int) $height,
        'loading'     => $priority ? 'eager' : 'lazy',
        'decoding'    => $priority ? 'sync' : 'async',
        'fetchpriority' => $priority ? 'high' : 'auto',
    ];

    if ($class !== '') {
        $attrs['class'] = $class;
    }

    $html = '<img';
    foreach ($attrs as $key => $value) {
        $html .= ' ' . $key . '="' . e((string) $value) . '"';
    }

    return $html . '>';
}

/**
 * Inline SVG icon from assets/icons.php (keeps HTML templates readable).
 */
function icon(string $name, string $class = ''): string
{
    static $icons = null;

    if ($icons === null) {
        $icons = require __DIR__ . '/icons.php';
    }

    if (!isset($icons[$name])) {
        return '';
    }

    $svg = $icons[$name];
    if ($class !== '') {
        $svg = str_replace('<svg ', '<svg class="' . e($class) . '" ', $svg);
    }

    return $svg;
}

/**
 * Render decorative stars for a rating out of five.
 */
function stars(int $rating): string
{
    $out = '<span class="stars" aria-label="' . $rating . ' out of 5">';
    for ($i = 1; $i <= 5; $i++) {
        $out .= '<svg class="star' . ($i <= $rating ? ' is-filled' : '') . '" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.6l2.9 6.1 6.7.9-4.9 4.6 1.2 6.6L12 17.6 6.1 20.8l1.2-6.6L2.4 9.6l6.7-.9z"/></svg>';
    }

    return $out . '</span>';
}

/**
 * Initials used for the testimonial medallions (no fake portraits).
 */
function initials(string $name): string
{
    $parts = preg_split('/\s+/', trim($name)) ?: [];
    $initials = '';

    foreach ($parts as $part) {
        if ($part === '' || mb_strtolower($part) === 'e') {
            continue;
        }
        $initials .= mb_strtoupper(mb_substr($part, 0, 1));
        if (mb_strlen($initials) === 2) {
            break;
        }
    }

    return $initials;
}

/**
 * Format a price the Italian way (comma decimals) without the currency sign.
 */
function price(float|int|string $value): string
{
    $number = (float) $value;

    return number_format($number, 2, ',', '.');
}
