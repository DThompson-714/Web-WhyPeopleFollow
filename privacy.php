<?php
require_once __DIR__ . '/includes/functions.php';
$page = ['title' => 'Privacy Policy', 'description' => 'How Why People Follow collects and uses your information.', 'body_class' => 'page-privacy'];
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow">Legal</p>
        <h1>Privacy Policy</h1>
    </div>
</section>
<section class="section">
    <div class="container narrow prose">
        <p><em>[Placeholder] Have this page reviewed for your jurisdiction before launch.</em></p>
        <h2>What we collect</h2>
        <p>When you contact us or join the newsletter, we collect the name and email address you provide and the content of your message. The Leader Assessment runs entirely in your browser; your answers are not sent to us.</p>
        <h2>How we use it</h2>
        <p>We use your information only to reply to you and to send the newsletter you signed up for. We never sell your information.</p>
        <h2>Your choices</h2>
        <p>You can unsubscribe at any time, or email <a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a> to have your data deleted.</p>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
