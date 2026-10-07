<?php
/**
 * Router for PHP's built-in dev server, mirroring the .htaccess rules:
 *   php -S localhost:8000 router.php
 * Not used on Apache hosting.
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#^/(includes|content|data|docs)/#', $path)) {
    http_response_code(403);
    exit('Forbidden');
}
if ($path !== '/' && is_file(__DIR__ . $path) && !str_ends_with($path, '.php')) {
    return false; // static asset
}
if (preg_match('#^/articles/([a-z0-9-]+)/?$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/article.php';
    return true;
}
if ($path === '/sitemap.xml') {
    require __DIR__ . '/sitemap.php';
    return true;
}
$name = trim(preg_replace('#\.php$#', '', $path), '/') ?: 'index';
if (preg_match('/^[a-z0-9-]+$/', $name) && is_file(__DIR__ . "/$name.php") && $name !== 'router') {
    require __DIR__ . "/$name.php";
    return true;
}
require __DIR__ . '/404.php';
return true;
