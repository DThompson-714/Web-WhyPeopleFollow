<?php
/**
 * Simple file-based articles. To publish a new article, copy any file in
 * /content/articles/, rename it (the file name becomes the URL, so use a few
 * lowercase words separated by hyphens) and edit it.
 * Articles with a future 'date' stay hidden until that day.
 */

function all_articles(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $articles = [];
    foreach (glob(dirname(__DIR__) . '/content/articles/*.php') as $file) {
        $a = include $file;
        if (!is_array($a) || strtotime($a['date']) > time()) {
            continue;
        }
        $a['slug'] = basename($file, '.php');
        $a += ['order' => 0, 'category' => 'perspectives', 'short_title' => $a['title'], 'seo_title' => $a['title']];
        $articles[] = $a;
    }
    // Newest first; 'order' breaks ties between articles published the same day.
    usort($articles, fn($x, $y) => [$y['date'], $y['order']] <=> [$x['date'], $x['order']]);
    return $cache = $articles;
}

function find_article(string $slug): ?array
{
    foreach (all_articles() as $a) {
        if ($a['slug'] === $slug) {
            return $a;
        }
    }
    return null;
}

function article_url(array $a): string
{
    return '/articles/' . $a['slug'];
}

/** Estimated reading time in minutes. */
function reading_time(string $html): int
{
    return max(1, (int) round(word_count($html) / 230));
}

function word_count(string $html): int
{
    return count(preg_split('/\s+/u', trim(strip_tags($html)), -1, PREG_SPLIT_NO_EMPTY));
}

/** Article card used on the home, articles and article pages. */
function article_card(array $a, string $headingTag = 'h3'): string
{
    global $categories;
    $cat = $categories[$a['category']] ?? '';
    return '<article class="article-card reveal" data-category="' . e($a['category']) . '">'
        . '<a href="' . e(article_url($a)) . '">'
        . '<span class="article-meta"><span class="tag tag-' . e($a['category']) . '">' . e($cat) . '</span> ' . reading_time($a['body']) . ' min read</span>'
        . '<' . $headingTag . '>' . e($a['short_title']) . '</' . $headingTag . '>'
        . '<p>' . e($a['excerpt']) . '</p>'
        . '<span class="link-arrow">Read the ' . ($a['category'] === 'stories' ? 'story' : 'article') . ' ' . icon('arrow') . '</span>'
        . '</a></article>';
}
