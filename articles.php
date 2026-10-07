<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$articles = all_articles();

$page = [
    'title'       => 'Leadership Articles & Stories',
    'description' => 'Real stories and honest perspectives on leadership versus management, from 25 years of leading teams: taking the blame, trusting your people, and treating them with dignity.',
    'body_class'  => 'page-articles',
    'schema'      => [[
        '@context' => 'https://schema.org',
        '@type'    => 'Blog',
        'name'     => $site['name'],
        'url'      => abs_url('/articles'),
        'author'   => ['@type' => 'Person', 'name' => $author['name']],
        'blogPost' => array_map(fn($a) => [
            '@type'         => 'BlogPosting',
            'headline'      => $a['seo_title'],
            'url'           => abs_url(article_url($a)),
            'datePublished' => $a['date'],
        ], $articles),
    ]],
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">Articles</p>
        <h1 class="reveal">The wins, the failures and the <em>uncomfortable truths.</em></h1>
        <p class="lead reveal"><strong>Stories</strong> are real moments from 25 years of leading people. <strong>Perspectives</strong> are what I learned from them.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filters reveal" data-filters role="group" aria-label="Filter articles">
            <button class="chip is-active" data-filter="all" aria-pressed="true">All</button>
            <?php foreach ($categories as $key => $label): ?>
            <button class="chip" data-filter="<?= e($key) ?>" aria-pressed="false"><?= e($label) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="article-grid">
            <?php foreach ($articles as $a) echo article_card($a, 'h2'); ?>
        </div>
        <?php if (!$articles): ?><p class="center">New articles are on the way.</p><?php endif; ?>

        <p class="center more-coming reveal">More stories are on the way. <a href="/newsletter">Subscribe to <?= e($newsletter['name']) ?></a> and you’ll get them first.</p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
