<?php
/**
 * Newsletter sign-up endpoint (used by the footer form).
 * Stores emails in /data/subscribers.csv. To use Mailchimp, ConvertKit, etc.,
 * replace the "save" block below with a call to their API or embed their form instead.
 */
require_once __DIR__ . '/includes/functions.php';

$isAjax = ($_SERVER['HTTP_ACCEPT'] ?? '') === 'application/json';

function respond(bool $ok, string $msg, bool $isAjax): void
{
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code($ok ? 200 : 422);
        echo json_encode(['ok' => $ok, 'message' => $msg]);
    } else {
        header('Location: /?subscribed=' . ($ok ? '1' : '0'));
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request.', $isAjax);
}
if (!csrf_check($_POST['csrf'] ?? null) || !empty($_POST['website'])) {
    respond(false, 'Please refresh the page and try again.', $isAjax);
}

$email = trim((string) ($_POST['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.', $isAjax);
}

// --- save ---
if (!append_csv('subscribers.csv', [date('c'), $email])) {
    respond(false, 'Sign-up is temporarily unavailable. Please try again later.', $isAjax);
}

respond(true, "You're in. Your first leadership idea arrives this week.", $isAjax);
