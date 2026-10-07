# Why People Follow — website

A hand-editable PHP + JavaScript site for [whypeoplefollow.com](https://www.whypeoplefollow.com).
No WordPress, no database, no build step. Every page is a plain PHP file you can open and edit.

## Run it locally

```bash
php -S localhost:8000 router.php
```

Then open http://localhost:8000. (`router.php` copies the clean-URL rules from `.htaccess` for PHP's built-in server.)

## Deploy

Upload everything to any Apache host with PHP 8.0+ (most shared hosting works). `.htaccess` takes care of
clean URLs, blocking private folders, caching and compression.

1. Make sure the `data/` folder is writable by the web server (`chmod 775 data`).
2. When SSL is on, uncomment the HTTPS/www redirect at the top of `.htaccess`.
3. Submit `https://www.whypeoplefollow.com/sitemap.xml` in Google Search Console.

## Where to edit things

| What you want to change | File |
|---|---|
| Site name, email, social links, Google Analytics ID | `includes/config.php` → `$site` |
| Navigation menu & header button | `includes/config.php` → `$nav`, `$cta` |
| The five pillars (Trust, Purpose, Care, Clarity, Growth) | `includes/config.php` → `$pillars` |
| Programs / offers and their buttons | `includes/config.php` → `$programs` |
| Testimonials (**replace the placeholders**) | `includes/config.php` → `$testimonials` |
| FAQs | `includes/config.php` → `$faqs` |
| Homepage copy & assessment questions | `index.php` |
| Weekly habits per pillar | `approach.php` → `$habits` |
| Your name, photo and story (**replace placeholders**) | `about.php` → `$founder` |
| Colors and fonts | `assets/css/style.css` → `:root` at the top |
| Animations and interactive features | `assets/js/main.js` |

### Writing a new article

Copy any file in `content/articles/`, rename it (the file name becomes the URL, e.g.
`content/articles/giving-feedback.php` → `/resources/giving-feedback`) and edit the title, date, pillar and body.
It appears on the Resources page and in the sitemap automatically. Articles with a future date stay hidden until that day.

## Forms

- **Contact form** (`contact.php`) emails `$site['email']` using PHP `mail()` and also saves a copy to
  `data/contact-messages.csv`, so no message is lost if your host's mail isn't set up.
- **Newsletter** (`subscribe.php`) saves emails to `data/subscribers.csv`. To use Mailchimp, ConvertKit, etc.,
  replace the save block in `subscribe.php` with their API call.

Both forms have CSRF protection and a spam honeypot. `data/` is blocked from the web and ignored by git.

## What's on the site

- **Hero** with an animated "follower" network: dots are drawn toward a glowing leader that follows your cursor.
- **Manager → Leader switch** that shows the five mindset shifts.
- **Free Leader Assessment**: 10 questions, an animated score, a breakdown by pillar and a personal "focus pillar".
  It runs entirely in the browser, and if GA4 is set it records an `assessment_complete` event.
- Approach page with tabs, Programs page with FAQs, Resources with pillar filters, reading progress bar on articles.
- SEO: unique titles and descriptions, canonical URLs, Open Graph/Twitter cards, JSON-LD (Organization, WebSite,
  Article, FAQPage), auto-generated `sitemap.xml`, `robots.txt`, clean URLs.
- Accessibility: keyboard-friendly, skip link, ARIA on interactive widgets, respects reduced-motion settings.

## Before launch checklist

- [ ] Replace placeholder testimonials in `includes/config.php` (or set `$testimonials = [];` to hide the section)
- [ ] Add your name, story and `assets/img/founder.jpg` in `about.php`
- [ ] Confirm the contact email and social links in `includes/config.php`
- [ ] Point program buttons to your real booking or checkout links
- [ ] Have the privacy policy (`privacy.php`) reviewed
- [ ] Move any existing WordPress posts into `content/articles/`, and add 301 redirects in `.htaccess` for old URLs
