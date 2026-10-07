<?php
require_once __DIR__ . '/includes/functions.php';

$page = [
    'title'       => 'About David Thompson',
    'description' => 'David Thompson spent 25 years leading IT teams in Higher Education and proudly called himself the worst manager ever. This is his story, and why he built Why People Follow.',
    'body_class'  => 'page-about',
    'og_type'     => 'profile',
    'schema'      => [[
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        'name'        => $author['name'],
        'jobTitle'    => $author['title'],
        'image'       => abs_url($author['photo']),
        'url'         => abs_url('/about'),
        'description' => $author['short_bio'],
        'sameAs'      => array_values(array_filter($site['social'])),
    ]],
];

// "The road here" timeline. Edit freely.
$timeline = [
    ['when' => 'Late 1990s',  'title' => 'Laid off, more than once', 'body' => 'Large tech companies taught me that you were useful only until you weren’t. No loyalty, no security.'],
    ['when' => 'The detour',  'title' => 'A “temporary” job',        'body' => 'A friend offered me a job at a local community college. I took it because the bills were stacking up, and I planned to leave soon.'],
    ['when' => 'The turn',    'title' => 'The Leadership Academy',   'body' => 'A senior leader saw Emotional Intelligence in me (I googled it). The Academy drew a clear line between managing and leading, and I knew which side I wanted to be on.'],
    ['when' => '25 years',    'title' => 'Teams worth following',    'body' => 'Software development, infrastructure, cloud architecture and more. People I believed in, fought for, and trusted to be smarter than me.'],
    ['when' => '2025',        'title' => 'An early retirement',      'body' => 'Leadership fell out of favor and top-down management took over. I chose to stay who I was. <a href="/articles/top-down-management-forced-retirement">Read the full story</a>.'],
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero about-hero">
    <div class="container about-hero-grid">
        <div>
            <p class="eyebrow reveal">About</p>
            <h1 class="reveal">I might be the worst manager ever.<br><em>And you should be too!</em></h1>
        </div>
        <div class="about-card reveal">
            <?= author_photo('about-photo', 320, false) ?>
            <h2>David Thompson</h2>
            <p><?= e($author['title']) ?></p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container narrow prose about-prose">
        <p class="hello-line">Hello, I’m David Thompson.</p>

        <p>I spent 25 years in Information Technology management, mostly in Higher Education, and for most of that time I proudly told anyone who would listen that I was the worst manager ever.</p>

        <p class="beat">I meant it and I was proud of it.</p>

        <p>You see, I was never trying to be a manager. It was offered to me early in my career and I accepted it, mostly because the salary increase was hard to argue with. I had no formal training, no real role model to follow, and honestly no idea what I was doing. What I did have was a very clear memory of every workplace experience I had ever been through: the layoffs, the indifferent bosses, the environments where you were useful until you weren’t. And a very strong feeling that there had to be a better way to treat people.</p>

        <p class="beat">It turns out there was. I just needed someone to show it to me.</p>

        <p>Early in my time at a local community college, a senior leader pulled me aside and told me they saw something in me. Emotional Intelligence, they called it. I smiled, said thank you, and immediately googled it when I got back to my desk. What followed was an invitation to the college’s Leadership Academy, and honestly, it changed everything. For the first time in my career someone was drawing a clear and deliberate line between management and leadership, and I realized instantly which side of that line I wanted to be on.</p>

        <blockquote class="pull-quote"><p>Being a manager never sounded like fun to me. Being a leader? I couldn’t wait to get started.</p></blockquote>

        <p>Over the next 25 years I led software development teams, infrastructure teams, cloud architecture teams, and more. I hired people I believed in, fought for them when it mattered, and built environments where they felt safe enough to take risks, challenge ideas, and bring their best thinking to work every day. My teams were productive, creative, and genuinely committed to each other’s success. Former team members still call me for advice, which I find more validating than any performance review I ever received.</p>

        <p>It was not always easy and it did not always go smoothly. I made mistakes, misjudged situations, and had more than a few uncomfortable conversations along the way. I was called into HR. I was demoted. I was told I was too easy, too friendly, too lenient. I watched a management culture I had spent years building get systematically dismantled around me. And eventually, after 25 years, I retired earlier than I had planned, under circumstances I am still processing.</p>

        <p>But here is what I know for certain. The people who showed up to my retirement party were not there out of obligation. They were there because at some point during our time together, something had mattered. A conversation, a decision, a moment where I chose their dignity over my convenience. Those people are the proof of concept.</p>
    </div>
</section>

<section class="section road-section">
    <div class="container">
        <div class="section-head reveal">
            <p class="eyebrow">The road here</p>
            <h2>From accidental manager to someone worth following</h2>
        </div>
        <ol class="timeline">
            <?php foreach ($timeline as $t): ?>
            <li class="reveal">
                <span class="step"></span>
                <div>
                    <p class="when"><?= e($t['when']) ?></p>
                    <h3><?= e($t['title']) ?></h3>
                    <p><?= $t['body'] /* may contain a link */ ?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<section class="section">
    <div class="container narrow prose about-prose">
        <h2>Why I built this site</h2>

        <p>I built WhyPeopleFollow.com because I believe the conversation between management and leadership is one of the most important ones happening in any organization right now, and most people are having it wrong. Leadership is not a personality type or a management technique. It is a daily decision to put your ego aside, invest in the people around you, and trust that the returns will come. They always do, just not always on the timeline or in the form you expect.</p>

        <div class="not-box">
            <p class="not-label">What I’m not</p>
            <p>I am not a consultant, a theorist, or a keynote speaker with a ten-step framework. I am someone who spent 25 years in the room where it happens, making decisions in real time with real people and real consequences. Some of those decisions were good. Some were not. All of them taught me something.</p>
        </div>

        <p>This site is where I share all of it. The wins, the failures, the uncomfortable truths, and the philosophy I built one team at a time over a career I am genuinely proud of.</p>

        <p class="beat">You can’t make someone follow you. But you can become someone worth following.</p>

        <p>I hope something here helps you do exactly that.</p>

        <div class="sign-off">
            <span class="signature">David</span>
            <p><strong><?= e($author['name']) ?></strong><br><em><?= e($author['title']) ?></em></p>
        </div>

        <div class="about-actions">
            <a class="btn btn-primary" href="/start-here">Start here <?= icon('arrow') ?></a>
            <a class="btn btn-outline" href="/contact">Write to me</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
