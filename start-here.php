<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/articles.php';

$page = [
    'title'       => 'Start Here',
    'description' => 'New to Why People Follow? Start with three honest questions, a two-minute leadership reflection, and the four stories that explain what this site is about.',
    'body_class'  => 'page-start',
];

$pathArticles = array_values(array_filter(array_map('find_article', $reading_path)));

// Give the quiz what it needs: questions, themes and the recommended article for each theme.
$themeData = [];
foreach ($quiz_themes as $key => $t) {
    $a = find_article($t['article']);
    $themeData[] = [
        'key'   => $key,
        'title' => $t['title'],
        'question' => $t['question'],
        'body'  => $t['body'],
        'article' => $a ? ['title' => $a['short_title'], 'url' => article_url($a)] : null,
    ];
}

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">Start here</p>
        <h1 class="reveal">Welcome. If this is your first time here, <em>thank you.</em></h1>
        <p class="lead reveal">I’m David Thompson, and I built this site to share what I learned about Transformational Leadership versus Top-Down Management. I spent 25 years trying to become the best leader I could be, and the worst manager in the process.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow prose-intro">
        <p class="reveal">My goal is simple: to get managers, young and old, to think about which style works best for them.</p>
        <p class="reveal">Leadership isn’t taught the way management is. You can see it in the number of books written about management but not leadership, and the number of degrees offered in management but not leadership. If I can change one person from striving to be the best possible manager into proudly becoming the worst by choosing to lead instead, the time I spent building this site will have been worth it.</p>
        <p class="lede-question reveal"><strong>Are you the next great leader in your organization?</strong> Start with three questions.</p>
    </div>
</section>

<!-- THE THREE QUESTIONS -->
<section class="section questions-section">
    <div class="container">
        <div class="question-cards">
            <article class="question-card reveal" style="--d:0ms">
                <span class="q-num">1</span>
                <h2>How do you want to be remembered?</h2>
                <p>I have worked for a lot of managers over the years. Some were pretty good, and I remember a few of their names. Some were absolutely horrible, and I definitely remember their names, not fondly. And then there were the great leaders. I will never forget them. I still reach out to them from time to time, because I respect them.</p>
            </article>
            <article class="question-card reveal" style="--d:100ms">
                <span class="q-num">2</span>
                <h2>Do you feel superior?</h2>
                <p>If you believe you are the most important person on your team, thank you again for being here. If you think you can change that mindset, please stay. If not, this site may not be for you, because the reality is you’re not. If you were, why have a team at all? It’s the synergy, the difference of opinions and the collaboration of a diverse team that make us great. Much more than any one person, including you.</p>
            </article>
            <article class="question-card reveal" style="--d:200ms">
                <span class="q-num">3</span>
                <h2>Do you want a team that strives for greatness, or one that just gets by?</h2>
                <p>I’ve seen it firsthand. When a team has no trust, faith or respect for its manager, it does exactly what it’s asked, out of fear or to avoid conflict. I would rather surround myself with people smarter than me, who know I trust them to take my plan and make it better, faster and more secure than I ever could. That’s where greatness happens. Not from one person, but from a team that feels empowered.</p>
            </article>
        </div>
    </div>
</section>

<!-- QUIZ -->
<section class="section quiz-section" id="quiz">
    <div class="container narrow">
        <div class="section-head reveal">
            <p class="eyebrow">Two-minute reflection</p>
            <h2>Would <em>you</em> follow you?</h2>
            <p>Nine statements based on those three questions. Answer for how things are <strong>today</strong>, not how you’d like them to be. Nobody sees your answers but you.</p>
        </div>

        <div class="quiz card reveal" data-quiz>
            <div class="quiz-progress"><span data-progress></span></div>

            <div class="quiz-intro" data-step="intro">
                <div class="quiz-themes">
                    <?php foreach ($quiz_themes as $key => $t): ?>
                    <span><?= icon($key) ?><?= e($t['title']) ?></span>
                    <?php endforeach; ?>
                </div>
                <button class="btn btn-primary btn-lg" data-start>Begin <?= icon('arrow') ?></button>
            </div>

            <div class="quiz-questions" data-step="questions" hidden>
                <p class="quiz-count"><span data-theme-label></span> &middot; <span data-qnum>1</span> of <?= count($quiz_questions) ?></p>
                <p class="quiz-q" data-qtext></p>
                <div class="quiz-scale" role="radiogroup" aria-label="How often is this true for you?">
                    <?php foreach (['Rarely', 'Sometimes', 'Often', 'Usually', 'Always'] as $n => $label): ?>
                    <button type="button" role="radio" aria-checked="false" data-value="<?= $n + 1 ?>"><span class="dot"></span><?= e($label) ?></button>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn-text" data-back>&larr; Back</button>
            </div>

            <div class="quiz-results" data-step="results" hidden>
                <div class="score-ring">
                    <svg viewBox="0 0 120 120"><circle cx="60" cy="60" r="52" class="track"/><circle cx="60" cy="60" r="52" class="bar" data-ring/></svg>
                    <div class="score-num"><span data-score>0</span><small>/100</small></div>
                </div>
                <h3 data-result-title></h3>
                <p data-result-body></p>
                <ul class="theme-bars" data-bars></ul>
                <div class="focus-box">
                    <p class="eyebrow">Where to start</p>
                    <h4 data-focus-title></h4>
                    <p data-focus-body></p>
                    <a class="btn btn-primary" data-focus-link href="/articles">Read the story</a>
                </div>
                <div class="quiz-signup">
                    <p><strong>Want more like this?</strong> Get <?= e($newsletter['name']) ?>, <?= e($newsletter['cadence']) ?>.</p>
                    <?= newsletter_form('quiz', 'Subscribe') ?>
                </div>
                <button type="button" class="btn-text" data-restart>Retake the reflection</button>
            </div>
        </div>
    </div>
    <script type="application/json" id="quiz-data"><?= json_encode(['questions' => $quiz_questions, 'themes' => $themeData], JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</section>

<!-- READING PATH -->
<section class="section reading-path-section">
    <div class="container narrow">
        <div class="section-head reveal">
            <p class="eyebrow">Your reading path</p>
            <h2>Start with these four</h2>
            <p>If any of this resonates with you, even slightly, I hope you’ll keep reading. Here’s the order I’d read them in.</p>
        </div>
        <ol class="reading-path">
            <?php foreach ($pathArticles as $i => $a): ?>
            <li class="reveal">
                <a href="<?= e(article_url($a)) ?>">
                    <span class="step"><?= $i + 1 ?></span>
                    <span class="path-text">
                        <span class="article-meta"><span class="tag tag-<?= e($a['category']) ?>"><?= e($categories[$a['category']] ?? '') ?></span> <?= reading_time($a['body']) ?> min read</span>
                        <strong><?= e($a['short_title']) ?></strong>
                        <span><?= e($a['excerpt']) ?></span>
                    </span>
                    <?= icon('arrow') ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ol>
        <p class="center closing-line reveal">I truly believe the world has enough managers. What it needs are more leaders, and that’s exactly what we’re going to talk about.</p>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
