<?php
require_once __DIR__ . '/includes/functions.php';

$page = [
    'title'       => 'About',
    'description' => 'Why People Follow helps new managers become leaders their teams choose to follow. Here is the story and the beliefs behind it.',
    'body_class'  => 'page-about',
];

/*
 * FOUNDER — replace the placeholders below with your real name, photo and story.
 * Put your photo at /assets/img/founder.jpg (square, at least 800x800).
 */
$founder = [
    'name'  => '[Your Name]',
    'title' => 'Founder, Why People Follow',
    'photo' => '/assets/img/founder.jpg',
    'bio'   => [
        '[Placeholder] Tell your story here: when you first became a manager, what you got wrong, and the moment you realized managing and leading are not the same thing.',
        '[Placeholder] Share the experience and credentials that make you the right guide for new managers — years leading teams, industries, certifications, people you have coached.',
    ],
];

$beliefs = [
    ['title' => 'Leaders are made, not born.', 'body' => 'Leadership is a set of learnable habits. Anyone willing to practice can get dramatically better at it.'],
    ['title' => 'Followership is a choice.', 'body' => 'Your title earns compliance. Only your character and behavior earn commitment.'],
    ['title' => 'Small moments matter most.', 'body' => 'Teams are won or lost in one-on-ones, hallway conversations and how you react to bad news — not in big speeches.'],
    ['title' => 'The goal is more leaders.', 'body' => 'Great leaders don\'t create followers. They create more leaders.'],
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">About</p>
        <h1 class="reveal">Nobody follows a job title.</h1>
        <p class="lead reveal">Why People Follow was created for the millions of people who get promoted into management every year and are expected to figure out leadership on their own.</p>
    </div>
</section>

<section class="section">
    <div class="container story-grid">
        <div class="founder-photo reveal">
            <img src="<?= e($founder['photo']) ?>" alt="<?= e($founder['name']) ?>" width="480" height="480" loading="lazy" onerror="this.parentNode.classList.add('no-photo');this.remove()">
            <span class="founder-initials" aria-hidden="true">WPF</span>
        </div>
        <div class="reveal">
            <p class="eyebrow">Meet the founder</p>
            <h2><?= e($founder['name']) ?></h2>
            <p class="program-type"><?= e($founder['title']) ?></p>
            <?php foreach ($founder['bio'] as $para): ?>
            <p><?= e($para) ?></p>
            <?php endforeach; ?>
            <a class="btn btn-primary" href="/contact">Get in touch</a>
        </div>
    </div>
</section>

<section class="section beliefs-section">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">What we believe</p>
            <h2>Four beliefs behind everything we teach</h2>
        </div>
        <div class="beliefs">
            <?php foreach ($beliefs as $i => $b): ?>
            <div class="belief reveal" style="--d: <?= $i * 80 ?>ms">
                <span class="pillar-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                <h3><?= e($b['title']) ?></h3>
                <p><?= e($b['body']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
