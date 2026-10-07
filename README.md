# Why People Follow

The personal leadership site of David Thompson, built with hand-editable PHP and JavaScript for [whypeoplefollow.com](https://www.whypeoplefollow.com).
No WordPress, no database, no build step. Every page is a plain file you can open and edit.

> You can't make someone follow you. But you can become someone worth following.

## Run it locally

```bash
php -S localhost:8000 router.php
```

Then open http://localhost:8000. (`router.php` copies the clean-URL rules from `.htaccess` for PHP's built-in server.)

## Deploy

Upload everything to any Apache host running PHP 8.0 or newer (most shared hosting works). `.htaccess` handles
clean URLs, blocks the private folders, and sets up caching and compression.

1. Make sure the `data/` folder is writable by the web server (`chmod 775 data`).
2. Once SSL is on, uncomment the HTTPS/www redirect at the top of `.htaccess`.
3. Submit `https://www.whypeoplefollow.com/sitemap.xml` in Google Search Console.

## Pages

| Address | File | What it is |
|---|---|---|
| `/` | `index.php` | Home: hero sign-up, "Hello, pull up a chair", Manager → Leader switch, latest articles |
| `/start-here` | `start-here.php` | Welcome, the three questions, the "Would you follow you?" quiz, the reading path |
| `/articles` | `articles.php` | All articles, with Stories / Perspectives filters |
| `/articles/...` | `article.php` | A single article (content comes from `content/articles/`) |
| `/newsletter` | `newsletter.php` | The Worth Following newsletter page |
| `/about` | `about.php` | David's story, "The road here" timeline, why the site exists |
| `/contact` | `contact.php` | "Write to David" form (linked in the footer) |
| `/privacy` | `privacy.php` | Privacy policy |

## Where to edit things

| What you want to change | Where |
|---|---|
| Email address, social links, Google Analytics | `includes/config.php` → `$site` |
| Your name, title, short bio, photo | `includes/config.php` → `$author` |
| Newsletter name, cadence, provider and API key | `includes/config.php` → `$newsletter` |
| Menu and header button | `includes/config.php` → `$nav`, `$cta` |
| Start Here reading-path order | `includes/config.php` → `$reading_path` |
| Quiz statements and themes | `includes/config.php` → `$quiz_questions`, `$quiz_themes` |
| Manager → Leader switch lines | `index.php` → `$shifts` |
| About timeline | `about.php` → `$timeline` |
| Colors and fonts | `assets/css/style.css` → `:root` at the top |
| Your photo | replace `assets/img/david-thompson.jpg` and `.webp` (square, 800×800) plus `david-thompson-sm.jpg` (160×160) |

### Writing a new article

1. Copy any file in `content/articles/` and rename it. The file name becomes the address, so use a few lowercase words
   people might search for, separated by hyphens: `content/articles/giving-honest-feedback.php` → `/articles/giving-honest-feedback`.
2. Edit the title, excerpt, date, category (`stories` or `perspectives`) and body. Articles with a future date stay hidden until that day.
3. The article shows up on the Articles page and in the sitemap automatically.

Formatting helpers you can use in an article body:

```html
<p class="beat">A short line that should stand on its own.</p>
<p class="aside">An aside to the reader, shown in italics.</p>
<blockquote class="pull-quote"><p>A line worth highlighting.</p></blockquote>
<div class="takeaway"><p>The lesson, in a highlighted box.</p></div>
```

## The Worth Following newsletter

Every sign-up form posts to `subscribe.php`, which **always** saves the email to `data/subscribers.csv`
(along with where the person signed up: home, quiz, a specific article, and so on).

To connect a newsletter service, edit `$newsletter` in `includes/config.php`:

- **Kit (ConvertKit):** set `'provider' => 'kit'`, your v4 API key and your form ID.
- **MailerLite:** set `'provider' => 'mailerlite'`, your API token and (optionally) a group ID.

Test one sign-up after connecting. If the service rejects a sign-up, the email is still saved and also logged to
`data/provider-errors.csv` so you can import it later. Import any existing `subscribers.csv` rows into the service once you connect.

Draft newsletter content lives in `docs/newsletter/` (not public):
- `welcome-sequence.md`: three automatic welcome emails
- `field-guide-draft.md`: a free "Worst Manager Ever's Field Guide" download for new subscribers

## Marketing assets

Saved in `docs/social/` (not public):
- `facebook-launch-post.md`: the Facebook launch post text (personal and short versions) with posting tips
- `facebook-square-1080.png`: the square Facebook image that goes with it
- `facebook-link-1200x630.png`: a wide alternate version

## SEO built in

- Keyword-focused addresses (e.g. `/articles/manager-vs-leader`), with your own titles kept on the page
- Unique search titles and descriptions, canonical URLs, Open Graph and Twitter share cards
- Structured data: WebSite, Person (About), Blog, BlogPosting (articles), FAQPage (Newsletter)
- An automatic `sitemap.xml`, plus `robots.txt`

## Before launch checklist

- [ ] Set your real email address in `includes/config.php` (currently `hello@whypeoplefollow.com`)
- [ ] Add your LinkedIn (and any other) profile links
- [ ] Choose a newsletter service and connect it
- [ ] Load the welcome sequence into your newsletter service
- [ ] Have `privacy.php` reviewed, and name your newsletter service in it
- [ ] Add your Google Analytics ID (optional)
