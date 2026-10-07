<?php
require_once __DIR__ . '/includes/functions.php';

$page = [
    'title'       => '',  // empty = use "Why People Follow — tagline"
    'description' => $site['description'],
    'body_class'  => 'page-home',
];

/*
 * Leader Assessment statements. Each one maps to a pillar key from config.php.
 * Two statements per pillar keeps the results balanced.
 */
$assessment = [
    ['pillar' => 'trust',   'text' => 'When I make a mistake, I tell my team about it before they find out on their own.'],
    ['pillar' => 'trust',   'text' => 'My team would say I always do what I say I will do.'],
    ['pillar' => 'purpose', 'text' => 'Everyone on my team can explain why their work matters to our customers or mission.'],
    ['pillar' => 'purpose', 'text' => 'When I hand out work, I explain the "why" — not just the "what" and "when".'],
    ['pillar' => 'care',    'text' => 'I know at least one personal goal for every person on my team.'],
    ['pillar' => 'care',    'text' => 'I hold regular one-on-ones that are about the person, not just status updates.'],
    ['pillar' => 'clarity', 'text' => 'My team knows exactly what the top three priorities are this month.'],
    ['pillar' => 'clarity', 'text' => 'I tell people what success looks like and let them decide how to get there.'],
    ['pillar' => 'growth',  'text' => 'I give specific, useful feedback at least once a week.'],
    ['pillar' => 'growth',  'text' => 'I deliberately hand off work that would help someone else grow — even when I could do it faster myself.'],
];

$pillarData = array_map(fn($p) => ['key' => $p['key'], 'title' => $p['title'], 'line' => $p['line'], 'body' => $p['body']], $pillars);

include __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg" aria-hidden="true">
        <canvas data-constellation></canvas>
    </div>
    <div class="container hero-inner">
        <p class="eyebrow reveal">For new managers who want more than a title</p>
        <h1 class="hero-title reveal">
            Don't just <span class="word-swap" data-word-swap='["manage.","supervise.","delegate.","direct."]'><span>manage.</span></span>
            <br><em>Lead.</em>
        </h1>
        <p class="hero-sub reveal">You were promoted to manage a team. Now they're waiting to see if you can <strong>lead</strong> one. Learn why people choose to follow — and become the leader your team chooses.</p>
        <div class="hero-actions reveal">
            <a class="btn btn-primary btn-lg" href="#assessment">Take the 2-minute Leader Assessment <?= icon('arrow') ?></a>
            <a class="btn btn-ghost btn-lg" href="/approach">See the approach</a>
        </div>
        <ul class="hero-proof reveal">
            <li><?= icon('check') ?> Built for your first 1–3 years leading people</li>
            <li><?= icon('check') ?> Practical, not theoretical</li>
            <li><?= icon('check') ?> Habits you can use on Monday</li>
        </ul>
    </div>
    <a class="scroll-cue" href="#shift" aria-label="Scroll to next section"><span></span></a>
</section>

<!-- MANAGER VS LEADER -->
<section class="section shift" id="shift">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">The shift</p>
            <h2>People work for managers.<br>People <em>follow</em> leaders.</h2>
            <p>Nobody gets promoted and wakes up a leader. The skills that made you great at your old job aren't the ones that make a team want to follow you. Flip the switch to see the difference.</p>
        </div>

        <div class="shift-toggle reveal" data-shift>
            <div class="toggle-wrap">
                <span class="toggle-label" data-label="manager">Manager</span>
                <button class="toggle" role="switch" aria-checked="false" aria-label="Show the leader mindset" data-shift-toggle><span class="knob"></span></button>
                <span class="toggle-label" data-label="leader">Leader</span>
            </div>
            <ul class="shift-list">
                <?php foreach ($pillars as $p): ?>
                <li>
                    <span class="shift-icon"><?= icon($p['key']) ?></span>
                    <span class="shift-text">
                        <span class="from"><?= e($p['shift']['from']) ?></span>
                        <span class="to"><?= e($p['shift']['to']) ?></span>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- PILLARS -->
<section class="section pillars-section">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">The framework</p>
            <h2>Five reasons people follow</h2>
            <p>Every leader worth following gets these five things right. None of them require a bigger title — just better habits.</p>
        </div>
        <div class="pillars">
            <?php foreach ($pillars as $i => $p): ?>
            <article class="pillar-card reveal" style="--d: <?= $i * 80 ?>ms" data-tilt>
                <span class="pillar-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                <span class="pillar-icon"><?= icon($p['key']) ?></span>
                <h3><?= e($p['title']) ?></h3>
                <p class="pillar-line"><?= e($p['line']) ?></p>
                <p><?= e($p['body']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
        <p class="center reveal"><a class="link-arrow" href="/approach">Explore the full approach <?= icon('arrow') ?></a></p>
    </div>
</section>

<!-- ASSESSMENT -->
<section class="section assessment-section" id="assessment">
    <div class="container narrow">
        <div class="section-head reveal">
            <p class="eyebrow">Free Leader Assessment</p>
            <h2>Would <em>you</em> follow you?</h2>
            <p>Ten honest questions. Two minutes. Find out which of the five pillars is your strength — and which one is quietly costing you your team's trust.</p>
        </div>

        <div class="assessment card reveal" data-assessment>
            <div class="assess-progress"><span data-progress></span></div>

            <div class="assess-intro" data-step="intro">
                <p>For each statement, choose how often it's true for you <strong>today</strong> — not how you'd like it to be.</p>
                <button class="btn btn-primary btn-lg" data-start>Start the assessment <?= icon('arrow') ?></button>
            </div>

            <div class="assess-questions" data-step="questions" hidden>
                <p class="assess-count"><span data-qnum>1</span> of <?= count($assessment) ?></p>
                <p class="assess-q" data-qtext></p>
                <div class="assess-scale" role="radiogroup" aria-label="How often is this true?">
                    <?php foreach (['Rarely', 'Sometimes', 'Often', 'Usually', 'Always'] as $n => $label): ?>
                    <button type="button" role="radio" aria-checked="false" data-value="<?= $n + 1 ?>"><span class="dot"></span><?= e($label) ?></button>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn-text" data-back>&larr; Back</button>
            </div>

            <div class="assess-results" data-step="results" hidden>
                <div class="score-ring">
                    <svg viewBox="0 0 120 120"><circle cx="60" cy="60" r="52" class="track"/><circle cx="60" cy="60" r="52" class="bar" data-ring/></svg>
                    <div class="score-num"><span data-score>0</span><small>/100</small></div>
                </div>
                <h3 data-result-title></h3>
                <p data-result-body></p>
                <ul class="pillar-bars" data-bars></ul>
                <div class="focus-box">
                    <p class="eyebrow">Your focus pillar</p>
                    <h4 data-focus-title></h4>
                    <p data-focus-body></p>
                </div>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="/contact?interest=coaching">Talk through my results</a>
                    <button type="button" class="btn btn-ghost" data-restart>Retake</button>
                </div>
            </div>
        </div>
    </div>
    <script type="application/json" id="assessment-data"><?= json_encode(['questions' => $assessment, 'pillars' => $pillarData], JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?></script>
</section>

<!-- PROGRAMS PREVIEW -->
<section class="section programs-preview">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">Ways to grow</p>
            <h2>Pick the path that fits where you are</h2>
        </div>
        <div class="program-grid">
            <?php foreach ($programs as $i => $p): ?>
            <article class="program-card reveal<?= $p['featured'] ? ' featured' : '' ?>" style="--d: <?= $i * 100 ?>ms">
                <?php if ($p['featured']): ?><span class="badge">Most popular</span><?php endif; ?>
                <p class="program-type"><?= e($p['type']) ?></p>
                <h3><?= e($p['name']) ?></h3>
                <p><?= e($p['summary']) ?></p>
                <a class="link-arrow" href="/programs">Learn more <?= icon('arrow') ?></a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($testimonials)): ?>
<!-- TESTIMONIALS -->
<section class="section testimonials">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">From the people who followed through</p>
            <h2>Leaders in the making</h2>
        </div>
        <div class="carousel reveal" data-carousel>
            <div class="carousel-track">
                <?php foreach ($testimonials as $t): ?>
                <figure class="quote">
                    <blockquote>&ldquo;<?= e($t['quote']) ?>&rdquo;</blockquote>
                    <figcaption><strong><?= e($t['name']) ?></strong><span><?= e($t['role']) ?></span></figcaption>
                </figure>
                <?php endforeach; ?>
            </div>
            <div class="carousel-dots" role="tablist" aria-label="Choose testimonial"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- STORY TEASER -->
<section class="section story">
    <div class="container story-grid">
        <div class="story-quote reveal">
            <p>&ldquo;The question isn't whether your team <em>has</em> to listen to you.<br>It's whether they would <strong>choose</strong> to.&rdquo;</p>
        </div>
        <div class="reveal">
            <p class="eyebrow">Why this exists</p>
            <h2>Most new managers are promoted, then left alone.</h2>
            <p>They get a title, a team and a calendar full of meetings — but almost no one teaches them how to lead. So they fall back on what they know: doing the work themselves, checking on everything, and hoping respect comes with the role.</p>
            <p>Why People Follow exists to change that. We help new managers build the trust, clarity and care that make people <em>want</em> to follow — long before they ever have to.</p>
            <a class="link-arrow" href="/about">Read the story <?= icon('arrow') ?></a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
