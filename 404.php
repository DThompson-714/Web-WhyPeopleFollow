<?php
require_once __DIR__ . '/includes/functions.php';
http_response_code(404);
$page = ['title' => 'Page not found', 'description' => 'This page could not be found.', 'body_class' => 'page-404'];
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container narrow center">
        <p class="eyebrow">404</p>
        <h1>Even great leaders take a wrong turn.</h1>
        <p class="lead">The page you're looking for isn't here. Let's get you back on track.</p>
        <div class="hero-actions" style="justify-content:center">
            <a class="btn btn-primary" href="/">Go home</a>
            <a class="btn btn-ghost" href="/resources">Browse resources</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
