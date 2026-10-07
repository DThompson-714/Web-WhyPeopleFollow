<?php
require_once __DIR__ . '/includes/functions.php';

$page = [
    'title'       => 'The Approach: Five Reasons People Follow',
    'description' => 'Trust, Purpose, Care, Clarity and Growth: the five pillars that turn new managers into leaders people choose to follow.',
    'body_class'  => 'page-approach',
];

// Habits to practice for each pillar (keyed by pillar key).
$habits = [
    'trust'   => ['Say "I was wrong" out loud, early.', 'Keep a written list of every commitment you make, and close each one.', 'Give credit in public and take blame in private.'],
    'purpose' => ['Start every project kickoff with "here is why this matters".', 'Share customer stories with the team every week.', 'Ask each person what part of the work they find most meaningful.'],
    'care'    => ['Hold weekly one-on-ones and let them set half the agenda.', 'Learn what each person wants their next role to be.', 'Notice effort, not just results.'],
    'clarity' => ['Write down the top three priorities and repeat them until people are tired of hearing them.', 'Define "done" before work starts.', 'Make decisions quickly, and explain the reasoning behind them.'],
    'growth'  => ['Give one piece of specific feedback every day.', 'Delegate outcomes, not tasks.', 'Ask "what did you learn?" after every win and every miss.'],
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">The approach</p>
        <h1 class="reveal">Leadership isn't a position.<br>It's a <em>permission</em> your team gives you.</h1>
        <p class="lead reveal">Every day, your team decides how much of their energy, ideas and trust to give you. These five pillars are what they're looking for when they decide.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="tabs reveal" data-tabs>
            <div class="tab-list" role="tablist" aria-label="The five pillars">
                <?php foreach ($pillars as $i => $p): ?>
                <button role="tab" id="tab-<?= e($p['key']) ?>" aria-controls="panel-<?= e($p['key']) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" tabindex="<?= $i === 0 ? '0' : '-1' ?>">
                    <?= icon($p['key']) ?><span><?= e($p['title']) ?></span>
                </button>
                <?php endforeach; ?>
            </div>
            <?php foreach ($pillars as $i => $p): ?>
            <div class="tab-panel" role="tabpanel" id="panel-<?= e($p['key']) ?>" aria-labelledby="tab-<?= e($p['key']) ?>"<?= $i === 0 ? '' : ' hidden' ?>>
                <div class="tab-panel-grid">
                    <div>
                        <p class="pillar-num">Pillar <?= $i + 1 ?></p>
                        <h2><?= e($p['line']) ?></h2>
                        <p class="lead"><?= e($p['body']) ?></p>
                        <div class="shift-pill">
                            <span class="from"><?= e($p['shift']['from']) ?></span>
                            <?= icon('arrow') ?>
                            <span class="to"><?= e($p['shift']['to']) ?></span>
                        </div>
                    </div>
                    <div class="card habits">
                        <h3>Habits to practice this week</h3>
                        <ul class="checklist">
                            <?php foreach ($habits[$p['key']] ?? [] as $h): ?>
                            <li><?= icon('check') ?><?= e($h) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section journey">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">The journey</p>
            <h2>From promoted to followed</h2>
        </div>
        <ol class="timeline">
            <li class="reveal"><span class="step">1</span><div><h3>Awareness</h3><p>Take the Leader Assessment to see how your team experiences you today across the five pillars.</p></div></li>
            <li class="reveal"><span class="step">2</span><div><h3>Mindset</h3><p>Make the shift from doing the work to multiplying the people who do it. This is the hardest — and most important — part.</p></div></li>
            <li class="reveal"><span class="step">3</span><div><h3>Habits</h3><p>Turn each pillar into small, repeatable weekly practices. Leadership is built in ordinary moments, not big speeches.</p></div></li>
            <li class="reveal"><span class="step">4</span><div><h3>Momentum</h3><p>Your team starts bringing you ideas, owning outcomes and growing into leaders themselves. That's when you know they're following.</p></div></li>
        </ol>
        <p class="center reveal"><a class="btn btn-primary btn-lg" href="/#assessment">Start with the assessment <?= icon('arrow') ?></a></p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
