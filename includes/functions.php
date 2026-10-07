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

/** True when the given nav path matches the current page. */
function is_active(string $path): bool
{
    return current_path() === $path;
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

/** Inline SVG icons used across the site. */
function icon(string $name): string
{
    $icons = [
        'trust'    => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
        'purpose'  => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.5"/>',
        'care'     => '<path d="M12 20s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 10c0 5.6-7 10-7 10z"/>',
        'clarity'  => '<path d="M3 12h4l3-8 4 16 3-8h4"/>',
        'growth'   => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
        'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'check'    => '<path d="M5 12l5 5L20 7"/>',
        'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 014 0v4M12 10v7"/>',
        'youtube'  => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="M10 9l5 3-5 3z"/>',
        'instagram'=> '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5v.01"/>',
        'x'        => '<path d="M4 4l16 16M20 4L4 20"/>',
        'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
    ];
    $paths = $icons[$name] ?? '';
    return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $paths . '</svg>';
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
