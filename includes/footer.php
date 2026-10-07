</main>

<?php if (empty($page['hide_footer_cta'])): ?>
<section class="cta-band">
    <div class="container cta-band-inner reveal">
        <div>
            <p class="eyebrow">The <?= e($newsletter['name']) ?> newsletter</p>
            <h2>A newsletter <em>worth following,</em> about becoming someone <em>worth following.</em></h2>
            <p>One honest story or lesson from 25 years of leading people, <?= e($newsletter['cadence']) ?>. Short enough to read with your coffee.</p>
        </div>
        <?= newsletter_form('footer', 'Get ' . $newsletter['name']) ?>
    </div>
</section>
<?php endif; ?>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <a class="logo" href="/">
                <span class="logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32"><circle cx="9" cy="20" r="3"/><circle cx="16" cy="20" r="3"/><circle cx="23" cy="20" r="3"/><circle cx="16" cy="9" r="4" class="logo-lead"/></svg>
                </span>
                <span class="logo-text">Why People <strong>Follow</strong></span>
            </a>
            <div class="footer-author">
                <img src="<?= e($author['photo_sm']) ?>" alt="" width="56" height="56" loading="lazy">
                <p><?= e($author['short_bio']) ?></p>
            </div>
        </div>
        <div>
            <h3>Read</h3>
            <ul>
                <?php foreach ($nav as $label => $path): ?>
                <li><a href="<?= e($path) ?>"><?= e($label) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h3>Say hello</h3>
            <ul>
                <li><a href="/contact">Write to David</a></li>
                <li><a href="/newsletter"><?= e($newsletter['name']) ?> newsletter</a></li>
                <?php foreach ($site['social'] as $network => $link): if (!$link) continue; ?>
                <li><a href="<?= e($link) ?>" target="_blank" rel="noopener"><?= e(ucfirst($network)) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= e($author['name']) ?> &middot; <?= e($site['name']) ?></p>
        <p><a href="/privacy">Privacy</a></p>
    </div>
</footer>

<script src="<?= asset('js/main.js') ?>" defer></script>
</body>
</html>
