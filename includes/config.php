<?php
/**
 * Why People Follow — site configuration.
 *
 * This is the main file to edit. Site-wide settings, navigation, the
 * newsletter and reusable content (quotes, the quiz) live here.
 * Page copy lives in the page files (index.php, start-here.php, about.php, ...).
 * Articles live in /content/articles/.
 */

$site = [
    'name'        => 'Why People Follow',
    'tagline'     => 'You can’t make someone follow you. But you can become someone worth following.',
    'url'         => 'https://www.whypeoplefollow.com',   // no trailing slash
    'description' => 'Honest leadership stories and lessons from David Thompson, who spent 25 years proudly being the worst manager ever, and choosing to lead instead.',
    'email'       => 'hello@whypeoplefollow.com',          // contact form messages are sent here
    'og_image'    => '/assets/img/og-image.png',           // 1200x630 social share image

    // Optional: Google Analytics 4 measurement ID (e.g. 'G-XXXXXXX'). Blank = disabled.
    'ga4_id' => '',

    // Social profiles. Leave blank to hide an icon.
    'social' => [
        'linkedin'  => '',
        'youtube'   => '',
        'instagram' => '',
        'x'         => '',
    ],
];

$author = [
    'name'   => 'David Thompson',
    'title'  => 'Founder, WhyPeopleFollow.com',
    'years'  => 25,
    'photo'  => '/assets/img/david-thompson.jpg',
    'photo_webp' => '/assets/img/david-thompson.webp',
    'photo_sm'   => '/assets/img/david-thompson-sm.jpg',
    'short_bio'  => 'David spent 25 years leading IT teams, mostly in Higher Education, and proudly told anyone who would listen that he was the worst manager ever. This is where he shares what he learned.',
];

/*
 * The "Worth Following" newsletter.
 *
 * provider:
 *   'file'       — save sign-ups to /data/subscribers.csv (default, works with no account)
 *   'kit'        — send to Kit (ConvertKit). Set api_key (v4 API key) and form_id.
 *   'mailerlite' — send to MailerLite. Set api_key and group_id.
 * Sign-ups are ALWAYS also saved to /data/subscribers.csv as a backup.
 */
$newsletter = [
    'name'      => 'Worth Following',
    'pitch'     => 'A newsletter worth following, about becoming someone worth following.',
    'cadence'   => 'every other Tuesday',
    'provider'  => 'file',
    'api_key'   => '',
    'form_id'   => '',   // Kit form ID
    'group_id'  => '',   // MailerLite group ID
];

// Main navigation: label => path
$nav = [
    'Home'       => '/',
    'Start Here' => '/start-here',
    'Articles'   => '/articles',
    'Newsletter' => '/newsletter',
    'About'      => '/about',
];

// Header button
$cta = [
    'label' => 'Subscribe',
    'href'  => '/newsletter',
];

// Article categories: key => label
$categories = [
    'stories'      => 'Stories',
    'perspectives' => 'Perspectives',
];

// The recommended reading order on the Start Here page (article file names).
$reading_path = [
    'manager-vs-leader',
    'firing-an-employee-with-compassion',
    'trusting-high-performers-story-of-gary',
    'top-down-management-forced-retirement',
];

// Quotes that rotate through the site. Quotes by someone other than David
// include their author as 'Quote text' => 'Author'.
$quotes = [
    'Leadership is not a license to do less; it is a responsibility to do more.' => 'Simon Sinek',
    'The world has enough managers. What it needs are more leaders.',
    'Process without emotional intelligence is just procedure.',
    'Nobody should ever leave a room feeling like less of a person than when they walked in.',
    'I never called a former manager who wasn’t also a leader. Have you?',
];

/*
 * The "Would you follow you?" quiz, used on the Start Here page.
 * Three themes, built on the three Start Here questions. Each theme points
 * readers to the article that speaks to it most.
 */
$quiz_themes = [
    'remembered' => [
        'title'   => 'Remembered',
        'question'=> 'How do you want to be remembered?',
        'body'    => 'People remember the horrible managers, and not fondly. They remember the great leaders forever. The difference is almost always how you treated them on their hardest days.',
        'article' => 'firing-an-employee-with-compassion',
    ],
    'ego' => [
        'title'   => 'Ego',
        'question'=> 'Do you feel superior?',
        'body'    => 'If you are the most important person on your team, why have a team at all? Leaders take the blame, share the credit, and surround themselves with people smarter than they are.',
        'article' => 'manager-vs-leader',
    ],
    'trust' => [
        'title'   => 'Trust',
        'question'=> 'Greatness, or just the mediocre?',
        'body'    => 'Teams without trust do exactly what they are asked, out of fear. Teams with trust make your plans better, faster and more secure than you ever could alone.',
        'article' => 'trusting-high-performers-story-of-gary',
    ],
];

$quiz_questions = [
    ['theme' => 'remembered', 'text' => 'When I deliver hard news, I think about how the person will feel walking out of the room, not just what the policy requires.'],
    ['theme' => 'ego',        'text' => 'When my team misses the mark, I tell upper management “this is on me,” even if someone else made the mistake.'],
    ['theme' => 'trust',      'text' => 'My team openly challenges what I ask them to do, without fear.'],
    ['theme' => 'remembered', 'text' => 'If my team members moved on tomorrow, I believe they would still call me for advice.'],
    ['theme' => 'ego',        'text' => 'I have changed course in front of my team because someone had a better idea than mine.'],
    ['theme' => 'trust',      'text' => 'When the goal is clear, I let people do the work without hovering or scheduling check-ins for the sake of it.'],
    ['theme' => 'remembered', 'text' => 'I know what the people on my team care about outside of the work itself.'],
    ['theme' => 'ego',        'text' => 'I try to hire people who are smarter than me in their area.'],
    ['theme' => 'trust',      'text' => 'My team takes calculated risks, because they know a mistake won’t be held against them.'],
];
