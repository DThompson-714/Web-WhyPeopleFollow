<?php
require_once __DIR__ . '/includes/functions.php';

$faqSchema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn($f) => [
        '@type'          => 'Question',
        'name'           => $f['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ], $faqs),
];

$page = [
    'title'       => 'Leadership Programs for New Managers',
    'description' => 'Courses, group coaching and 1:1 coaching that help new managers build trust, lead with purpose and inspire their teams.',
    'body_class'  => 'page-programs',
    'schema'      => [$faqSchema],
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">Programs</p>
        <h1 class="reveal">Become the leader you <em>wish</em> you'd had.</h1>
        <p class="lead reveal">Whether you're two weeks or two years into managing, there's a path here built for exactly where you are.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="program-grid detailed">
            <?php foreach ($programs as $i => $p): ?>
            <article class="program-card reveal<?= $p['featured'] ? ' featured' : '' ?>" style="--d: <?= $i * 100 ?>ms">
                <?php if ($p['featured']): ?><span class="badge">Most popular</span><?php endif; ?>
                <p class="program-type"><?= e($p['type']) ?></p>
                <h2><?= e($p['name']) ?></h2>
                <p><?= e($p['summary']) ?></p>
                <ul class="checklist">
                    <?php foreach ($p['features'] as $f): ?>
                    <li><?= icon('check') ?><?= e($f) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a class="btn <?= $p['featured'] ? 'btn-primary' : 'btn-outline' ?>" href="<?= e($p['cta']['href']) ?>"><?= e($p['cta']['label']) ?></a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section teams">
    <div class="container teams-inner reveal">
        <div>
            <p class="eyebrow">For organizations</p>
            <h2>Promoting new managers this year?</h2>
            <p>Most companies promote their best performers and hope for the best. We help you give them a real start: private Leader Lab cohorts, workshops and coaching for your whole management bench.</p>
        </div>
        <a class="btn btn-primary btn-lg" href="/contact?interest=team">Talk about your team <?= icon('arrow') ?></a>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <div class="section-head reveal">
            <p class="eyebrow">Questions</p>
            <h2>Frequently asked</h2>
        </div>
        <div class="faq reveal">
            <?php foreach ($faqs as $f): ?>
            <details>
                <summary><?= e($f['q']) ?></summary>
                <p><?= e($f['a']) ?></p>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
