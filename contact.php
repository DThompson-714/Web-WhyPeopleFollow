<?php
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$sent = false;
$values = ['name' => '', 'email' => '', 'interest' => $_GET['interest'] ?? 'general', 'message' => ''];
if (!isset($interests[$values['interest']])) {
    $values['interest'] = 'general';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $k => $_) {
        $values[$k] = trim((string) ($_POST[$k] ?? ''));
    }

    if (!csrf_check($_POST['csrf'] ?? null)) {
        $errors[] = 'Your session expired. Please try again.';
    }
    if (!empty($_POST['website'])) {            // honeypot field: bots fill it in
        $errors[] = 'Something went wrong.';
    }
    if ($values['name'] === '' || mb_strlen($values['name']) > 100) {
        $errors[] = 'Please enter your name.';
    }
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (!isset($interests[$values['interest']])) {
        $values['interest'] = 'general';
    }
    if (mb_strlen($values['message']) < 10 || mb_strlen($values['message']) > 5000) {
        $errors[] = 'Please write a message (at least 10 characters).';
    }

    if (!$errors) {
        $clean = fn($s) => str_replace(["\r", "\n"], ' ', $s);
        $subject = 'New enquiry: ' . $interests[$values['interest']];
        $body = "Name: {$values['name']}\nEmail: {$values['email']}\nInterest: {$interests[$values['interest']]}\n\n{$values['message']}\n";
        $headers = [
            'From'         => $site['name'] . ' <no-reply@' . parse_url($site['url'], PHP_URL_HOST) . '>',
            'Reply-To'     => $clean($values['email']),
            'Content-Type' => 'text/plain; charset=UTF-8',
        ];
        $sent = @mail($site['email'], $subject, $body, $headers);

        // Always keep a backup copy so no lead is lost if mail() isn't configured.
        if (append_csv('contact-messages.csv', [date('c'), $values['name'], $values['email'], $values['interest'], $values['message']])) {
            $sent = true;
        }
        if (!$sent) {
            $errors[] = 'Sorry, your message could not be sent. Please email us at ' . $site['email'] . '.';
        }
    }
}

$page = [
    'title'       => 'Contact',
    'description' => 'Questions about coaching, Leader Lab or training for your new managers? Get in touch with Why People Follow.',
    'body_class'  => 'page-contact',
];

include __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container narrow">
        <p class="eyebrow reveal">Contact</p>
        <h1 class="reveal">Let's talk about the leader you want to be.</h1>
        <p class="lead reveal">Tell us a little about where you are. We reply to every message within two business days.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <?php if ($sent && !$errors): ?>
        <div class="card success reveal">
            <h2>Thank you, <?= e($values['name']) ?>.</h2>
            <p>Your message is on its way. In the meantime, have you taken the <a href="/#assessment">Leader Assessment</a>?</p>
        </div>
        <?php else: ?>
        <form class="card contact-form reveal" method="post" action="/contact" novalidate>
            <?php if ($errors): ?>
            <div class="form-errors" role="alert"><ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
            <?php endif; ?>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="field-row">
                <div class="field">
                    <label for="name">Your name</label>
                    <input id="name" name="name" required maxlength="100" autocomplete="name" value="<?= e($values['name']) ?>">
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required autocomplete="email" value="<?= e($values['email']) ?>">
                </div>
            </div>
            <div class="field">
                <label for="interest">I'm interested in</label>
                <select id="interest" name="interest">
                    <?php foreach ($interests as $val => $label): ?>
                    <option value="<?= e($val) ?>"<?= $values['interest'] === $val ? ' selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="message">What's on your mind?</label>
                <textarea id="message" name="message" rows="6" required minlength="10" maxlength="5000" placeholder="e.g. I just took over a team of six and two of them applied for my role..."><?= e($values['message']) ?></textarea>
            </div>
            <button class="btn btn-primary btn-lg" type="submit">Send message <?= icon('arrow') ?></button>
        </form>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
