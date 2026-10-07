<?php
/**
 * "Worth Following" newsletter sign-up endpoint, used by every sign-up form.
 *
 * Every sign-up is saved to /data/subscribers.csv. If a provider is set in
 * includes/config.php ($newsletter['provider']), the subscriber is also sent there.
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
        header('Location: /newsletter?subscribed=' . ($ok ? '1' : '0'));
    }
    exit;
}

/** POST JSON to a provider API. Returns true on a 2xx response. */
function provider_post(string $url, array $data, array $headers): bool
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($data),
        CURLOPT_HTTPHEADER     => array_merge(['Content-Type: application/json', 'Accept: application/json'], $headers),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 10,
    ]);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $code >= 200 && $code < 300;
}

/** Send the subscriber to the configured provider. Returns true if sent (or no provider). */
function send_to_provider(string $email, string $source): bool
{
    global $newsletter;
    $key = $newsletter['api_key'];

    switch ($newsletter['provider']) {
        case 'kit':
            // Kit (ConvertKit) API v4: create (or update) the subscriber, then add them to your
            // form so Kit sends your welcome sequence.
            $auth = ['X-Kit-Api-Key: ' . $key];
            if (!provider_post('https://api.kit.com/v4/subscribers', ['email_address' => $email], $auth)) {
                return false;
            }
            return provider_post(
                'https://api.kit.com/v4/forms/' . rawurlencode($newsletter['form_id']) . '/subscribers',
                ['email_address' => $email, 'referrer' => abs_url('/') . '?source=' . rawurlencode($source)],
                $auth
            );
        case 'mailerlite':
            $data = ['email' => $email];
            if ($newsletter['group_id'] !== '') {
                $data['groups'] = [$newsletter['group_id']];
            }
            return provider_post('https://connect.mailerlite.com/api/subscribers', $data, ['Authorization: Bearer ' . $key]);
        default:
            return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request.', $isAjax);
}
if (!csrf_check($_POST['csrf'] ?? null) || !empty($_POST['website'])) {
    respond(false, 'Please refresh the page and try again.', $isAjax);
}

$email  = trim((string) ($_POST['email'] ?? ''));
$source = substr(preg_replace('/[^a-z0-9:_-]/i', '', (string) ($_POST['source'] ?? '')), 0, 80);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.', $isAjax);
}

$saved = append_csv('subscribers.csv', [date('c'), $email, $source]);
$sent  = send_to_provider($email, $source);

if (!$saved && !$sent) {
    respond(false, 'Sign-up is temporarily unavailable. Please try again later.', $isAjax);
}
if (!$sent) {
    // Saved locally but the provider call failed; log it so it can be imported later.
    append_csv('provider-errors.csv', [date('c'), $email, $source, $newsletter['provider']]);
}

respond(true, 'You’re in. Welcome to ' . $newsletter['name'] . '. Check your inbox soon.', $isAjax);
