<?php
/**
 * Shared helpers. You normally don't need to edit this file.
 */

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
}

/** Escape a value for safe HTML output. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Absolute URL for a site path (used for canonical links and social tags). */
function abs_url(string $path = '/'): string
{
    global $site;
    return rtrim($site['url'], '/') . '/' . ltrim($path, '/');
}

/** Current request path without query string or trailing slash. */
function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = preg_replace('#\.php$#', '', $path);
    $path = preg_replace('#/index$#', '/', $path);
    return $path === '/' ? '/' : rtrim($path, '/');
}

/** True when the given nav path matches the current page (or a page below it). */
function is_active(string $path): bool
{
    $current = current_path();
    return $current === $path || ($path !== '/' && str_starts_with($current, $path . '/'));
}

/** Cache-busting asset URL, e.g. asset('css/style.css'). */
function asset(string $file): string
{
    $full = dirname(__DIR__) . '/assets/' . $file;
    $v = is_file($full) ? filemtime($full) : '1';
    return '/assets/' . $file . '?v=' . $v;
}

/** CSRF token for forms. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_check(?string $token): bool
{
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

/** David's photo as a <picture> element (WebP with JPEG fallback). */
function author_photo(string $class = '', int $size = 480, bool $lazy = true): string
{
    global $author;
    return '<picture class="' . e($class) . '">'
        . '<source srcset="' . e($author['photo_webp']) . '" type="image/webp">'
        . '<img src="' . e($author['photo']) . '" alt="' . e($author['name']) . '" width="' . $size . '" height="' . $size . '"' . ($lazy ? ' loading="lazy"' : '') . '>'
        . '</picture>';
}

/**
 * The "Worth Following" sign-up form.
 * $source records where people signed up (shows in the CSV and as a tag in Kit/MailerLite).
 */
function newsletter_form(string $source, string $button = 'Subscribe', string $class = ''): string
{
    static $n = 0;
    $n++;
    $id = 'nl-email-' . $n;
    return '<form class="newsletter ' . e($class) . '" action="/subscribe" method="post" data-ajax-form>'
        . '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">'
        . '<input type="hidden" name="source" value="' . e($source) . '">'
        . '<label class="sr-only" for="' . $id . '">Email address</label>'
        . '<input id="' . $id . '" type="email" name="email" placeholder="Your email address" required autocomplete="email">'
        . '<input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">'
        . '<button class="btn btn-primary" type="submit">' . e($button) . '</button>'
        . '<p class="form-status" role="status" aria-live="polite"></p>'
        . '</form>';
}

/** Append a row to a CSV in /data, neutralising spreadsheet formulas. */
function append_csv(string $file, array $row): bool
{
    $dir = dirname(__DIR__) . '/data';
    if (!is_dir($dir) || !is_writable($dir)) {
        return false;
    }
    $row = array_map(fn($v) => preg_match('/^[=+\-@\t\r]/', (string) $v) ? "'" . $v : $v, $row);
    $fh = fopen($dir . '/' . $file, 'a');
    flock($fh, LOCK_EX);
    fputcsv($fh, $row);
    flock($fh, LOCK_UN);
    fclose($fh);
    return true;
}

/** Inline SVG icons used across the site. */
function icon(string $name): string
{
    $icons = [
        'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'check'    => '<path d="M5 12l5 5L20 7"/>',
        'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'book'     => '<path d="M4 5a2 2 0 012-2h13v16H6a2 2 0 00-2 2V5z"/><path d="M4 19a2 2 0 012-2h13"/>',
        'chair'    => '<path d="M7 3v9M17 3v9M5 12h14v3H5zM7 15v6M17 15v6"/>',
        'link'     => '<path d="M10 14a4 4 0 005.7 0l3-3a4 4 0 00-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 00-5.7 0l-3 3a4 4 0 005.7 5.7l1-1"/>',
        'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 014 0v4M12 10v7"/>',
        'youtube'  => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="M10 9l5 3-5 3z"/>',
        'instagram'=> '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5v.01"/>',
        'x'        => '<path d="M4 4l16 16M20 4L4 20"/>',
        'remembered' => '<path d="M12 20s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 10c0 5.6-7 10-7 10z"/>',
        'ego'      => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/>',
        'trust'    => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
    ];
    $paths = $icons[$name] ?? '';
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $paths . '</svg>';
}
