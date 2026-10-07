<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

header('Content-Type: application/xml; charset=utf-8');

$urls = [];
foreach (array_values($nav) as $path) {
    $urls[] = ['loc' => abs_url($path), 'lastmod' => null];
}
foreach (all_articles() as $a) {
    $urls[] = ['loc' => abs_url(article_url($a)), 'lastmod' => $a['date']];
}

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', "\n";
foreach ($urls as $u) {
    echo '  <url><loc>', e($u['loc']), '</loc>', $u['lastmod'] ? '<lastmod>' . e($u['lastmod']) . '</lastmod>' : '', "</url>\n";
}
echo '</urlset>', "\n";
