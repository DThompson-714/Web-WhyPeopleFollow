<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$article = find_article($_GET['slug'] ?? '');
if (!$article) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$pillarTitles = array_column($pillars, 'title', 'key');
$related = array_slice(array_filter(all_articles(), fn($a) => $a['slug'] !== $article['slug']), 0, 2);

$page = [
    'title'       => $article['title'],
    'description' => $article['excerpt'],
    'body_class'  => 'page-article',
    'schema'      => [[
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => $article['title'],
        'description'   => $article['excerpt'],
        'datePublished' => $article['date'],
        'mainEntityOfPage' => abs_url('/resources/' . $article['slug']),
        'publisher'     => ['@type' => 'Organization', 'name' => $site['name']],
    ]],
];

include __DIR__ . '/includes/header.php';
?>

<div class="reading-progress" aria-hidden="true"><span data-reading-progress></span></div>

<article class="article">
    <header class="page-hero">
        <div class="container narrow">
            <p class="eyebrow"><a href="/resources">Resources</a> &middot; <?= e($pillarTitles[$article['pillar']] ?? '') ?></p>
            <h1><?= e($article['title']) ?></h1>
            <p class="article-meta"><time datetime="<?= e($article['date']) ?>"><?= e(date('F j, Y', strtotime($article['date']))) ?></time> &middot; <?= reading_time($article['body']) ?> min read</p>
        </div>
    </header>
    <div class="container narrow prose">
        <?= $article['body'] /* trusted HTML written by the site owner */ ?>

        <aside class="card article-cta">
            <h3>How do you score on <?= e($pillarTitles[$article['pillar']] ?? 'leadership') ?>?</h3>
            <p>Take the free 2-minute Leader Assessment and find your focus pillar.</p>
            <a class="btn btn-primary" href="/#assessment">Take the assessment <?= icon('arrow') ?></a>
        </aside>
    </div>
</article>

<?php if ($related): ?>
<section class="section">
    <div class="container">
        <h2 class="center">Keep reading</h2>
        <div class="article-grid two">
            <?php foreach ($related as $a): ?>
            <article class="article-card">
                <a href="/resources/<?= e($a['slug']) ?>">
                    <span class="article-meta"><?= e($pillarTitles[$a['pillar']] ?? '') ?> &middot; <?= reading_time($a['body']) ?> min read</span>
                    <h3><?= e($a['title']) ?></h3>
                    <p><?= e($a['excerpt']) ?></p>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
