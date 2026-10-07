<?php
/**
 * Simple file-based articles. To publish a new article, copy any file in
 * /content/articles/, rename it (the file name becomes the URL slug) and edit it.
 * Articles with a future 'date' are hidden until that day.
 */

function all_articles(): array
{
    $articles = [];
    foreach (glob(dirname(__DIR__) . '/content/articles/*.php') as $file) {
        $a = include $file;
        if (!is_array($a) || strtotime($a['date']) > time()) {
            continue;
        }
        $a['slug'] = basename($file, '.php');
        $articles[] = $a;
    }
    usort($articles, fn($x, $y) => strcmp($y['date'], $x['date']));
    return $articles;
}

function find_article(string $slug): ?array
{
    if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
        return null;
    }
    foreach (all_articles() as $a) {
        if ($a['slug'] === $slug) {
            return $a;
        }
    }
    return null;
}

/** Estimated reading time in minutes. */
function reading_time(string $html): int
{
    return max(1, (int) round(str_word_count(strip_tags($html)) / 220));
}
