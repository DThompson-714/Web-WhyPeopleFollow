<?php
require_once __DIR__ . '/includes/functions.php';
$page = ['title' => 'Privacy Policy', 'description' => 'How Why People Follow collects and uses your information.', 'body_class' => 'page-privacy'];
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow">The fine print</p>
        <h1>Privacy Policy</h1>
    </div>
</section>
<section class="section">
    <div class="container narrow prose">
        <p><em>[Placeholder] Have this page reviewed for your situation before launch, and name your newsletter service once you choose one.</em></p>
        <h2>What I collect</h2>
        <p>When you subscribe to <?= e($newsletter['name']) ?> or write to me, I collect the email address (and, for messages, the name) you provide, along with what you write.</p>
        <p>The “Would you follow you?” reflection runs entirely in your browser. Your answers are never sent to me or stored anywhere.</p>
        <h2>How I use it</h2>
        <p>Only to send you the newsletter you asked for and to reply to your messages. Newsletter emails are delivered by an email service provider on my behalf. I will never sell or share your information.</p>
        <h2>Your choices</h2>
        <p>Every newsletter includes a one-click unsubscribe link. You can also email <a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a> to have your information deleted.</p>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
