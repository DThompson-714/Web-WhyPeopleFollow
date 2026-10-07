<?php
require_once __DIR__ . '/includes/functions.php';
http_response_code(404);
$page = ['title' => 'Page not found', 'description' => 'This page could not be found.', 'body_class' => 'page-404'];
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container narrow center">
        <p class="eyebrow">404</p>
        <h1>Well, this one’s on me.</h1>
        <p class="lead">The page you’re looking for isn’t here. A good leader owns the mistake and points you somewhere better.</p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="/start-here">Start here</a>
            <a class="btn btn-ghost" href="/articles">Read the articles</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
