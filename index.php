<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$page = [
    'title'       => '',   // empty = "Why People Follow: Leadership Lessons from the Worst Manager Ever"
    'description' => $site['description'],
    'body_class'  => 'page-home',
];

// The Manager → Leader switch. Each line comes from David's stories.
$shifts = [
    ['from' => 'Assign tasks and drive the staff',          'to' => 'Inspire, empower and encourage'],
    ['from' => '“Get this done or it’s your problem.”',     'to' => '“I’m sorry. This is on me.”'],
    ['from' => 'Formal check-ins in my office',             'to' => 'Honest talks at the picnic table'],
    ['from' => 'Follow the process',                         'to' => 'Protect people’s dignity'],
    ['from' => 'Be the smartest person in the room',         'to' => 'Hire people smarter than you'],
];

$latest = array_slice(all_articles(), 0, 3);

include __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg" aria-hidden="true"><canvas data-constellation></canvas></div>
    <div class="container hero-inner">
        <p class="eyebrow reveal">Leadership stories from the worst manager ever</p>
        <h1 class="hero-title reveal">You can’t make someone follow you.<br><em>But you can become someone worth following.</em></h1>
        <p class="hero-sub reveal">The world has enough managers. What it needs are more leaders, and that’s exactly what we’re going to talk about.</p>
        <div class="hero-signup reveal">
            <?= newsletter_form('home-hero', 'Get ' . $newsletter['name']) ?>
            <p class="hero-note">Join <strong><?= e($newsletter['name']) ?></strong>: one honest leadership story, <?= e($newsletter['cadence']) ?>. No spam, ever.</p>
        </div>
        <a class="hero-start reveal" href="/start-here">First time here? Start here <?= icon('arrow') ?></a>
    </div>
    <a class="scroll-cue" href="#hello" aria-label="Scroll to next section"><span></span></a>
</section>

<!-- HELLO -->
<section class="section hello" id="hello">
    <div class="container hello-grid">
        <div class="hello-photo reveal">
            <?= author_photo('photo-frame', 480) ?>
            <p class="photo-caption">David Thompson<br><span>25 years leading IT teams</span></p>
        </div>
        <div class="hello-text reveal">
            <p class="eyebrow">Hello, pull up a chair</p>
            <h2>I might be the worst manager ever. <em>And you should be too!</em></h2>
            <p>My name is David Thompson. I spent 25 years leading IT teams, mostly in Higher Education, and for most of that time I proudly told anyone who would listen that I was the worst manager ever.</p>
            <p>I meant it and I was proud of it. I was an accidental manager. The job was offered to me, I took it for the raise, and I had no idea what I was doing. Then a senior leader told me they saw a lot of Emotional Intelligence in me. I said thank you, then went back to my desk and googled it.</p>
            <p>That moment, and the Leadership Academy that followed, set me on a different path. I stopped trying to be a good manager and started trying to be a leader. My teams were productive, creative and committed to each other, and former team members still call me for advice.</p>
            <p class="lede-question">I still call the leaders from my past when I need guidance. I never called a former manager who wasn’t also a leader. <strong>Have you?</strong></p>
            <div class="hello-actions">
                <a class="btn btn-outline" href="/about">Read my story</a>
                <a class="link-arrow" href="/start-here">Start here <?= icon('arrow') ?></a>
            </div>
        </div>
    </div>
</section>

<!-- MANAGER VS LEADER -->
<section class="section shift">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">The difference</p>
            <h2>People work for managers.<br>People <em>follow</em> leaders.</h2>
            <p>Most of us become the kind of manager we’ve seen. Flip the switch to see what changes when you choose to lead instead.</p>
        </div>
        <div class="shift-toggle reveal" data-shift>
            <div class="toggle-wrap">
                <span class="toggle-label" data-label="manager">Manager</span>
                <button class="toggle" role="switch" aria-checked="false" aria-label="Show the leader version" data-shift-toggle><span class="knob"></span></button>
                <span class="toggle-label" data-label="leader">Leader</span>
            </div>
            <ul class="shift-list">
                <?php foreach ($shifts as $i => $s): ?>
                <li>
                    <span class="shift-num"><?= $i + 1 ?></span>
                    <span class="shift-text">
                        <span class="from"><?= e($s['from']) ?></span>
                        <span class="to"><?= e($s['to']) ?></span>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- QUOTE -->
<section class="quote-band">
    <div class="container narrow reveal">
        <blockquote>
            <p>Leadership is not a license to do less; it is a responsibility to do more.</p>
            <footer><cite class="quote-cite">Simon Sinek</cite></footer>
        </blockquote>
    </div>
</section>

<!-- LATEST -->
<?php if ($latest): ?>
<section class="section latest">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">From the blog</p>
            <h2>Stories and perspectives</h2>
            <p>The wins, the failures and the uncomfortable truths from 25 years in the room where it happens.</p>
        </div>
        <div class="article-grid">
            <?php foreach ($latest as $a) echo article_card($a); ?>
        </div>
        <p class="center reveal"><a class="btn btn-outline" href="/articles">See all articles</a></p>
    </div>
</section>
<?php endif; ?>

<!-- QUIZ TEASER -->
<section class="section quiz-teaser">
    <div class="container">
        <div class="teaser-card reveal">
            <div>
                <p class="eyebrow">Two-minute reflection</p>
                <h2>Would <em>you</em> follow you?</h2>
                <p>Nine honest questions about how you want to be remembered, how you handle your ego, and how much you trust your team. You’ll see where you stand, and which story to read first.</p>
            </div>
            <a class="btn btn-primary btn-lg" href="/start-here#quiz">Take the reflection <?= icon('arrow') ?></a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
