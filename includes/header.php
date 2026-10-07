<?php
/**
 * Page header. Before including, a page may set:
 *   $page = [
 *     'title'       => 'Page title',          // shown as "Title | Why People Follow"
 *     'description' => 'Meta description',    // ~150 characters
 *     'schema'      => [ ... ],               // optional extra JSON-LD objects
 *     'body_class'  => 'page-about',
 *   ];
 */
require_once __DIR__ . '/functions.php';

$page = $page ?? [];
$pageTitle = !empty($page['title'])
    ? $page['title'] . ' | ' . $site['name']
    : $site['name'] . ' — ' . $site['tagline'];
$pageDesc  = $page['description'] ?? $site['description'];
$canonical = abs_url(current_path());
$ogImage   = abs_url($site['og_image']);

$schema = [
    [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => $site['name'],
        'url'      => $site['url'],
        'logo'     => abs_url('/assets/img/logo.svg'),
        'sameAs'   => array_values(array_filter($site['social'])),
        'slogan'   => $site['tagline'],
    ],
    [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => $site['name'],
        'url'      => $site['url'],
    ],
];
if (!empty($page['schema'])) {
    $schema = array_merge($schema, $page['schema']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">
<meta name="theme-color" content="#0f1b2d">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($site['name']) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDesc) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDesc) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">

<?php foreach ($schema as $s): ?>
<script type="application/ld+json"><?= json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endforeach; ?>

<?php if (!empty($site['ga4_id'])): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($site['ga4_id']) ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= e($site['ga4_id']) ?>');</script>
<?php endif; ?>
</head>
<body class="<?= e($page['body_class'] ?? '') ?>">
<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header" data-header>
    <div class="container header-inner">
        <a class="logo" href="/" aria-label="<?= e($site['name']) ?> home">
            <span class="logo-mark" aria-hidden="true">
                <svg viewBox="0 0 32 32"><circle cx="9" cy="20" r="3"/><circle cx="16" cy="20" r="3"/><circle cx="23" cy="20" r="3"/><circle cx="16" cy="9" r="4" class="logo-lead"/></svg>
            </span>
            <span class="logo-text">Why People <strong>Follow</strong></span>
        </a>

        <button class="nav-toggle" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
            <span class="sr-only">Menu</span><span class="bar"></span><span class="bar"></span><span class="bar"></span>
        </button>

        <nav class="site-nav" id="site-nav" data-nav>
            <ul>
                <?php foreach ($nav as $label => $path): ?>
                <li><a href="<?= e($path) ?>"<?= is_active($path) ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
                <?php endforeach; ?>
            </ul>
            <a class="btn btn-primary btn-sm" href="<?= e($cta['href']) ?>"><?= e($cta['label']) ?></a>
        </nav>
    </div>
</header>

<main id="main">
