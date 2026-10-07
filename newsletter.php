<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$faqs = [
    ['q' => 'How often will I hear from you?', 'a' => 'About ' . $newsletter['cadence'] . '. Short enough to read with your morning coffee, and never more than I have something worth saying.'],
    ['q' => 'Who is it for?', 'a' => 'New managers, experienced managers, and anyone who has worked for a bad boss and wants to be a better one. If you lead people, or hope to someday, it’s for you.'],
    ['q' => 'Can I reply?', 'a' => 'Please do. Every email comes from me, and I read every reply. Some of the best conversations I’ve had started that way.'],
    ['q' => 'What if it’s not for me?', 'a' => 'Every email has a one-click unsubscribe link. No hard feelings, and I will never share or sell your email address.'],
];

$page = [
    'title'       => 'Worth Following: The Leadership Newsletter',
    'description' => 'Worth Following is a free leadership newsletter from David Thompson: one honest story or lesson ' . $newsletter['cadence'] . ' about leading people instead of just managing them.',
    'body_class'  => 'page-newsletter',
    'hide_footer_cta' => true,
    'schema'      => [[
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type' => 'Question', 'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ]],
];

$recent = array_slice(all_articles(), 0, 3);

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero newsletter-hero">
    <div class="container narrow center">
        <p class="eyebrow reveal">The newsletter</p>
        <h1 class="reveal"><?= e($newsletter['name']) ?></h1>
        <p class="lead reveal"><?= e($newsletter['pitch']) ?></p>
        <?php if (isset($_GET['subscribed'])): ?>
        <p class="notice <?= $_GET['subscribed'] === '1' ? 'is-ok' : 'is-error' ?>" role="status"><?= $_GET['subscribed'] === '1' ? 'You’re in. Welcome to ' . e($newsletter['name']) . '!' : 'Something went wrong. Please try again.' ?></p>
        <?php endif; ?>
        <div class="hero-signup reveal">
            <?= newsletter_form('newsletter-page', 'Subscribe, it’s free') ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">What you’ll get</p>
            <h2>A note from me, <?= e($newsletter['cadence']) ?></h2>
            <p>No frameworks, no ten-step programs, no sales pitch. Just what 25 years in the room taught me, one story at a time.</p>
        </div>
        <div class="get-grid">
            <div class="get-card reveal" style="--d:0ms">
                <span class="get-icon"><?= icon('book') ?></span>
                <h3>One honest story or lesson</h3>
                <p>Real moments from leading real teams. The wins, the mistakes and what I would do differently.</p>
            </div>
            <div class="get-card reveal" style="--d:100ms">
                <span class="get-icon"><?= icon('chair') ?></span>
                <h3>One question to sit with</h3>
                <p>Something to think about before your next team meeting, one-on-one or hard conversation.</p>
            </div>
            <div class="get-card reveal" style="--d:200ms">
                <span class="get-icon"><?= icon('mail') ?></span>
                <h3>A real person on the other end</h3>
                <p>Hit reply and tell me what’s going on with your team. I read every message.</p>
            </div>
        </div>
    </div>
</section>

<section class="section letter-section">
    <div class="container narrow">
        <div class="letter reveal">
            <p>Here’s the thing.</p>
            <p>Most managers were never taught to lead. They were promoted for being good at their jobs, handed a team, and left to copy whatever their last boss did. I know, because that was me.</p>
            <p>It took a Leadership Academy, a few great mentors and a lot of mistakes to figure out the difference. <?= e($newsletter['name']) ?> is my way of passing it on, so you don’t have to learn it all the hard way.</p>
            <p>If you want to become the kind of leader people still call years after they’ve moved on, I’d love to have you along.</p>
            <div class="sign-off">
                <span class="signature">David</span>
            </div>
        </div>
    </div>
</section>

<?php if ($recent): ?>
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">A taste of what’s inside</p>
            <h2>Recent stories</h2>
        </div>
        <div class="article-grid">
            <?php foreach ($recent as $a) echo article_card($a); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section faq-section">
    <div class="container narrow">
        <div class="section-head reveal"><h2>Questions</h2></div>
        <div class="faq reveal">
            <?php foreach ($faqs as $f): ?>
            <details>
                <summary><?= e($f['q']) ?></summary>
                <p><?= e($f['a']) ?></p>
            </details>
            <?php endforeach; ?>
        </div>
        <div class="final-signup reveal">
            <h2>Ready to become someone worth following?</h2>
            <?= newsletter_form('newsletter-page-bottom', 'Subscribe') ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
