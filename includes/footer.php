</main>

<section class="cta-band">
    <div class="container cta-band-inner reveal">
        <div>
            <h2>Your team is deciding right now whether to follow you.</h2>
            <p>Get one practical leadership idea every week — written for new managers, readable in five minutes.</p>
        </div>
        <form class="newsletter" action="/subscribe" method="post" data-ajax-form>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <label class="sr-only" for="nl-email">Email address</label>
            <input id="nl-email" type="email" name="email" placeholder="you@company.com" required autocomplete="email">
            <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
            <button class="btn btn-primary" type="submit">Send me the weekly idea</button>
            <p class="form-status" role="status" aria-live="polite"></p>
        </form>
    </div>
</section>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <a class="logo" href="/">
                <span class="logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32"><circle cx="9" cy="20" r="3"/><circle cx="16" cy="20" r="3"/><circle cx="23" cy="20" r="3"/><circle cx="16" cy="9" r="4" class="logo-lead"/></svg>
                </span>
                <span class="logo-text">Why People <strong>Follow</strong></span>
            </a>
            <p><?= e($site['tagline']) ?> Leadership development for new managers who want to inspire, not just supervise.</p>
            <div class="social">
                <?php foreach ($site['social'] as $network => $link): if (!$link) continue; ?>
                <a href="<?= e($link) ?>" target="_blank" rel="noopener" aria-label="<?= e(ucfirst($network)) ?>"><?= icon($network) ?></a>
                <?php endforeach; ?>
                <a href="mailto:<?= e($site['email']) ?>" aria-label="Email"><?= icon('mail') ?></a>
            </div>
        </div>
        <div>
            <h3>Explore</h3>
            <ul>
                <?php foreach ($nav as $label => $path): ?>
                <li><a href="<?= e($path) ?>"><?= e($label) ?></a></li>
                <?php endforeach; ?>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
        <div>
            <h3>Programs</h3>
            <ul>
                <?php foreach ($programs as $p): ?>
                <li><a href="/programs"><?= e($p['name']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= e($site['name']) ?>. All rights reserved.</p>
        <p><a href="/privacy">Privacy</a></p>
    </div>
</footer>

<script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
