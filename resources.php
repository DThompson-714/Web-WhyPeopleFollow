<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$articles = all_articles();
$pillarTitles = array_column($pillars, 'title', 'key');

$page = [
    'title'       => 'Leadership Resources for New Managers',
    'description' => 'Practical articles and tools for new managers: one-on-ones, delegation, feedback, trust and leading with purpose.',
    'body_class'  => 'page-resources',
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">Resources</p>
        <h1 class="reveal">Leadership you can use <em>on Monday.</em></h1>
        <p class="lead reveal">Short, practical reads for managers who'd rather practice leadership than read about theory.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filters reveal" data-filters role="group" aria-label="Filter by pillar">
            <button class="chip is-active" data-filter="all" aria-pressed="true">All</button>
            <?php foreach ($pillars as $p): ?>
            <button class="chip" data-filter="<?= e($p['key']) ?>" aria-pressed="false"><?= e($p['title']) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="article-grid">
            <?php foreach ($articles as $a): ?>
            <article class="article-card reveal" data-pillar="<?= e($a['pillar']) ?>">
                <a href="/resources/<?= e($a['slug']) ?>">
                    <span class="article-art pillar-<?= e($a['pillar']) ?>"><?= icon($a['pillar']) ?></span>
                    <span class="article-meta"><?= e($pillarTitles[$a['pillar']] ?? '') ?> &middot; <?= reading_time($a['body']) ?> min read</span>
                    <h2><?= e($a['title']) ?></h2>
                    <p><?= e($a['excerpt']) ?></p>
                    <span class="link-arrow">Read article <?= icon('arrow') ?></span>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php if (!$articles): ?><p class="center">New articles are on the way.</p><?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
