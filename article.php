<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$article = find_article((string) ($_GET['slug'] ?? ''));
if (!$article) {
    include __DIR__ . '/404.php';
    exit;
}

$url = abs_url(article_url($article));
$minutes = reading_time($article['body']);

// "Keep reading": the next article on the Start Here reading path, then the newest others.
$others = array_values(array_filter(all_articles(), fn($a) => $a['slug'] !== $article['slug']));
$pos = array_search($article['slug'], $reading_path, true);
$next = ($pos !== false && isset($reading_path[$pos + 1])) ? find_article($reading_path[$pos + 1]) : null;
$related = $next ? array_merge([$next], array_filter($others, fn($a) => $a['slug'] !== $next['slug'])) : $others;
$related = array_slice($related, 0, 2);

$page = [
    'title'       => $article['seo_title'],
    'description' => $article['excerpt'],
    'body_class'  => 'page-article',
    'og_type'     => 'article',
    'schema'      => [[
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'headline'         => $article['seo_title'],
        'description'      => $article['excerpt'],
        'datePublished'    => $article['date'],
        'dateModified'     => $article['updated'] ?? $article['date'],
        'mainEntityOfPage' => $url,
        'image'            => abs_url($site['og_image']),
        'wordCount'        => word_count($article['body']),
        'author'           => ['@type' => 'Person', 'name' => $author['name'], 'url' => abs_url('/about')],
        'publisher'        => ['@type' => 'Person', 'name' => $author['name']],
    ]],
];

include __DIR__ . '/includes/header.php';
?>

<div class="reading-progress" aria-hidden="true"><span data-reading-progress></span></div>

<article class="article">
    <header class="page-hero article-hero">
        <div class="container narrow">
            <p class="eyebrow"><a href="/articles">Articles</a> &middot; <?= e($categories[$article['category']] ?? '') ?></p>
            <h1><?= e($article['title']) ?></h1>
            <div class="byline">
                <img src="<?= e($author['photo_sm']) ?>" alt="" width="44" height="44">
                <p><strong><a href="/about"><?= e($author['name']) ?></a></strong><br>
                <time datetime="<?= e($article['date']) ?>"><?= e(date('F j, Y', strtotime($article['date']))) ?></time> &middot; <?= $minutes ?> min read</p>
            </div>
        </div>
    </header>

    <div class="container narrow prose">
        <?= $article['body'] /* trusted HTML written by the site owner */ ?>

        <div class="share" data-share>
            <span>Know a manager who needs to read this?</span>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= e(rawurlencode($url)) ?>" target="_blank" rel="noopener"><?= icon('linkedin') ?> LinkedIn</a>
            <a href="mailto:?subject=<?= e(rawurlencode($article['short_title'])) ?>&amp;body=<?= e(rawurlencode("I thought you'd like this: " . $url)) ?>"><?= icon('mail') ?> Email</a>
            <button type="button" data-copy="<?= e($url) ?>"><?= icon('link') ?> <span>Copy link</span></button>
        </div>

        <aside class="author-box">
            <img src="<?= e($author['photo_sm']) ?>" alt="" width="80" height="80" loading="lazy">
            <div>
                <p class="eyebrow">Written by</p>
                <h2><?= e($author['name']) ?></h2>
                <p><?= e($author['short_bio']) ?></p>
            </div>
        </aside>

        <aside class="article-signup">
            <h2><?= $article['category'] === 'stories' ? 'If this story meant something to you, there’s more where it came from.' : 'If this resonated with you, there’s more where it came from.' ?></h2>
            <p>Get <strong><?= e($newsletter['name']) ?></strong>, <?= e($newsletter['cadence']) ?>: one honest story or lesson about becoming someone worth following.</p>
            <?= newsletter_form('article:' . $article['slug'], 'Subscribe') ?>
        </aside>
    </div>
</article>

<?php if ($related): ?>
<section class="section keep-reading">
    <div class="container">
        <h2 class="center">Keep reading</h2>
        <div class="article-grid two">
            <?php foreach ($related as $a) echo article_card($a); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $page['hide_footer_cta'] = true; include __DIR__ . '/includes/footer.php'; ?>
