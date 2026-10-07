<?php
/**
 * Why People Follow — site configuration.
 *
 * This is the main file to edit. Site-wide settings, navigation, SEO
 * defaults and reusable content (testimonials, FAQs, programs) live here.
 * Page-specific copy lives in the page files themselves (index.php, about.php, ...).
 */

$site = [
    'name'        => 'Why People Follow',
    'tagline'     => "Don't just manage. Lead.",
    'url'         => 'https://www.whypeoplefollow.com',   // no trailing slash
    'description' => 'Leadership development for new managers who want more than a title. Learn why people follow — and become the leader your team chooses to follow.',
    'email'       => 'hello@whypeoplefollow.com',          // contact form messages are sent here
    'og_image'    => '/assets/img/og-image.png',           // 1200x630 social share image
    'year_founded'=> 2024,

    // Social profiles — leave blank to hide an icon.
    'social' => [
        'linkedin'  => 'https://www.linkedin.com/',
        'youtube'   => '',
        'instagram' => '',
        'x'         => '',
    ],

    // Optional: Google Analytics 4 measurement ID (e.g. 'G-XXXXXXX'). Blank = disabled.
    'ga4_id' => '',
];

// Main navigation: label => path
$nav = [
    'Home'       => '/',
    'Approach'   => '/approach',
    'Programs'   => '/programs',
    'Resources'  => '/resources',
    'About'      => '/about',
];

// Primary call-to-action shown in the header and across pages.
$cta = [
    'label' => 'Take the Leader Assessment',
    'href'  => '/#assessment',
];

/*
 * The five pillars — the core "why people follow" framework.
 * Used on the homepage and the Approach page.
 */
$pillars = [
    [
        'key'   => 'trust',
        'title' => 'Trust',
        'line'  => 'People follow leaders they can count on.',
        'body'  => 'Trust is built in small moments: keeping commitments, telling the truth when it is uncomfortable, and owning your mistakes before anyone else points them out.',
        'shift' => ['from' => 'Demanding respect', 'to' => 'Earning trust'],
    ],
    [
        'key'   => 'purpose',
        'title' => 'Purpose',
        'line'  => 'People follow leaders who give the work meaning.',
        'body'  => 'Managers assign tasks. Leaders connect those tasks to something bigger — the customer, the mission, the person each team member is becoming.',
        'shift' => ['from' => 'Assigning tasks', 'to' => 'Sharing the why'],
    ],
    [
        'key'   => 'care',
        'title' => 'Care',
        'line'  => 'People follow leaders who see them as people.',
        'body'  => 'Your team will not care how much you know until they know how much you care. Curiosity about their goals, strengths and lives outside work is not soft — it is strategic.',
        'shift' => ['from' => 'Managing resources', 'to' => 'Developing people'],
    ],
    [
        'key'   => 'clarity',
        'title' => 'Clarity',
        'line'  => 'People follow leaders who make the path clear.',
        'body'  => 'Confusion is exhausting. Great leaders make priorities, expectations and decisions unmistakable — and then get out of the way.',
        'shift' => ['from' => 'Controlling the how', 'to' => 'Clarifying the what'],
    ],
    [
        'key'   => 'growth',
        'title' => 'Growth',
        'line'  => 'People follow leaders who help them become more.',
        'body'  => 'The best leaders measure success by how many people they help grow. Feedback, stretch opportunities and genuine belief in your people turn a team into a movement.',
        'shift' => ['from' => 'Being the expert', 'to' => 'Building other leaders'],
    ],
];

/*
 * Programs / offers. Set 'featured' => true to highlight one card.
 * Replace the CTA links with your booking or checkout URLs.
 */
$programs = [
    [
        'name'     => 'The First 90 Days',
        'type'     => 'Self-paced course',
        'summary'  => 'A practical roadmap for your first three months as a manager — so you start with trust instead of trying to win it back later.',
        'features' => ['Weekly video lessons', 'One-on-one meeting templates', 'Team kickoff playbook', 'Lifetime access'],
        'cta'      => ['label' => 'Join the waitlist', 'href' => '/contact?interest=first-90-days'],
        'featured' => false,
    ],
    [
        'name'     => 'Leader Lab',
        'type'     => 'Group coaching cohort',
        'summary'  => 'Eight weeks with a small cohort of new managers. Real situations, honest feedback and the habits that turn a manager into a leader.',
        'features' => ['8 live group sessions', 'Peer accountability circle', 'Leader Assessment debrief', 'All course materials included'],
        'cta'      => ['label' => 'Apply for the next cohort', 'href' => '/contact?interest=leader-lab'],
        'featured' => true,
    ],
    [
        'name'     => '1:1 Leadership Coaching',
        'type'     => 'Private coaching',
        'summary'  => 'Focused, confidential coaching for managers facing a big moment: a new team, a tough conversation or a first leadership role.',
        'features' => ['Bi-weekly private sessions', 'Personal leadership plan', 'Messaging support between sessions', 'Customized to your goals'],
        'cta'      => ['label' => 'Book a discovery call', 'href' => '/contact?interest=coaching'],
        'featured' => false,
    ],
];

/*
 * Testimonials — REPLACE these placeholders with real quotes (with permission).
 * Leave the array empty ([]) to hide the testimonials section entirely.
 */
$testimonials = [
    [
        'quote' => '[Placeholder] Add a real quote from a client about how their leadership changed.',
        'name'  => 'Client Name',
        'role'  => 'New Manager, Company',
    ],
    [
        'quote' => '[Placeholder] Add a second testimonial — ideally one that mentions a specific result.',
        'name'  => 'Client Name',
        'role'  => 'Team Lead, Company',
    ],
    [
        'quote' => '[Placeholder] Add a third testimonial, for example from a manager or HR leader who sponsored a program.',
        'name'  => 'Client Name',
        'role'  => 'Director, Company',
    ],
];

// FAQs — shown on the Programs page and output as FAQ structured data for SEO.
$faqs = [
    [
        'q' => 'Who is Why People Follow for?',
        'a' => 'New and aspiring managers — usually in their first one to three years of leading people — who want to inspire their team, not just supervise it.',
    ],
    [
        'q' => 'I was promoted because I was great at my job. Why is managing so hard?',
        'a' => 'Because the skills that made you a great individual contributor are not the skills that make people follow you. Leadership is a new job, and it can be learned like any other.',
    ],
    [
        'q' => 'What is the difference between a manager and a leader?',
        'a' => 'A manager is given authority by a title. A leader is given trust by the team. You can be both — and the best managers are — but only one of them makes people want to follow.',
    ],
    [
        'q' => 'Can my company sponsor me or my team?',
        'a' => 'Yes. Leader Lab and coaching can be run privately for teams of new managers. Get in touch and we will put together a proposal.',
    ],
];

// Contact form "interest" options: value => label
$interests = [
    'general'        => 'General question',
    'first-90-days'  => 'The First 90 Days course',
    'leader-lab'     => 'Leader Lab cohort',
    'coaching'       => '1:1 Leadership Coaching',
    'team'           => 'Training for my company',
    'speaking'       => 'Speaking / workshops',
];
