/* Why People Follow — site interactions (no dependencies). */
(function () {
    'use strict';

    document.documentElement.classList.add('js');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
    var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };
    var track = function (name, params) { if (window.gtag) window.gtag('event', name, params || {}); };

    /* ---------- Header: solid background after scrolling ---------- */
    var header = $('[data-header]');
    function onScroll() { if (header) header.classList.toggle('is-scrolled', window.scrollY > 40); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ---------- Mobile navigation ---------- */
    var toggle = $('[data-nav-toggle]'), nav = $('[data-nav]');
    if (toggle && nav) {
        var setNav = function (open) {
            toggle.setAttribute('aria-expanded', String(open));
            nav.classList.toggle('is-open', open);
            document.body.classList.toggle('nav-open', open);
        };
        toggle.addEventListener('click', function () { setNav(toggle.getAttribute('aria-expanded') !== 'true'); });
        $$('a', nav).forEach(function (a) { a.addEventListener('click', function () { setNav(false); }); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setNav(false); });
    }

    /* ---------- Scroll reveal ---------- */
    var reveals = $$('.reveal');
    if ('IntersectionObserver' in window && !reduceMotion) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(function (el) { io.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('is-visible'); });
    }

    /* ---------- Hero canvas: followers drawn toward a leader ---------- */
    var canvas = $('[data-constellation]');
    if (canvas && canvas.getContext && !reduceMotion) {
        var ctx = canvas.getContext('2d');
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        var w, h, dots = [], leader = { x: 0, y: 0 }, pointer = null, t = 0, running = true;
        var hero = canvas.closest('.hero') || canvas.parentNode;

        var resize = function () {
            w = canvas.offsetWidth; h = canvas.offsetHeight;
            canvas.width = w * dpr; canvas.height = h * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            var count = Math.round(Math.min(80, (w * h) / 16000));
            dots = [];
            for (var i = 0; i < count; i++) {
                dots.push({ x: Math.random() * w, y: Math.random() * h, vx: (Math.random() - .5) * .4, vy: (Math.random() - .5) * .4, r: Math.random() * 1.6 + .8 });
            }
            leader.x = w * .78; leader.y = h * .4;
        };
        resize();
        window.addEventListener('resize', resize);
        hero.addEventListener('pointermove', function (e) {
            if (e.target.closest('form, a, button')) { pointer = null; return; }
            var rect = canvas.getBoundingClientRect();
            pointer = { x: e.clientX - rect.left, y: e.clientY - rect.top };
        });
        hero.addEventListener('pointerleave', function () { pointer = null; });

        var frame = function () {
            if (!running) return;
            t += 0.004;
            // The leader wanders on a gentle path, or follows the pointer.
            var tx = pointer ? pointer.x : w * (.74 + Math.cos(t) * .14);
            var ty = pointer ? pointer.y : h * (.42 + Math.sin(t * 1.3) * .2);
            leader.x += (tx - leader.x) * .03;
            leader.y += (ty - leader.y) * .03;

            ctx.clearRect(0, 0, w, h);
            for (var i = 0; i < dots.length; i++) {
                var d = dots[i];
                var dx = leader.x - d.x, dy = leader.y - d.y, dist = Math.sqrt(dx * dx + dy * dy) || 1;
                if (dist < 260) { d.vx += (dx / dist) * .012; d.vy += (dy / dist) * .012; }  // drawn toward the leader
                if (dist < 40)  { d.vx -= (dx / dist) * .08;  d.vy -= (dy / dist) * .08; }   // but given space
                d.vx *= .985; d.vy *= .985;
                d.x += d.vx; d.y += d.vy;
                if (d.x < 0 || d.x > w) d.vx *= -1;
                if (d.y < 0 || d.y > h) d.vy *= -1;

                if (dist < 220) {
                    ctx.strokeStyle = 'rgba(245,165,36,' + (0.28 * (1 - dist / 220)) + ')';
                    ctx.lineWidth = 1;
                    ctx.beginPath(); ctx.moveTo(d.x, d.y); ctx.lineTo(leader.x, leader.y); ctx.stroke();
                }
                for (var j = i + 1; j < dots.length; j++) {
                    var e2 = dots[j], ex = d.x - e2.x, ey = d.y - e2.y, ed = ex * ex + ey * ey;
                    if (ed < 9000) {
                        ctx.strokeStyle = 'rgba(143,163,191,' + (0.12 * (1 - ed / 9000)) + ')';
                        ctx.beginPath(); ctx.moveTo(d.x, d.y); ctx.lineTo(e2.x, e2.y); ctx.stroke();
                    }
                }
                ctx.fillStyle = dist < 220 ? 'rgba(255,214,140,.9)' : 'rgba(143,163,191,.55)';
                ctx.beginPath(); ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2); ctx.fill();
            }
            var g = ctx.createRadialGradient(leader.x, leader.y, 0, leader.x, leader.y, 46);
            g.addColorStop(0, 'rgba(245,165,36,.55)'); g.addColorStop(1, 'rgba(245,165,36,0)');
            ctx.fillStyle = g; ctx.beginPath(); ctx.arc(leader.x, leader.y, 46, 0, Math.PI * 2); ctx.fill();
            ctx.fillStyle = '#f5a524'; ctx.beginPath(); ctx.arc(leader.x, leader.y, 5, 0, Math.PI * 2); ctx.fill();
            requestAnimationFrame(frame);
        };

        // Pause the animation while the hero is off-screen.
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (en) {
                var was = running;
                running = en[0].isIntersecting;
                if (running && !was) requestAnimationFrame(frame);
            }).observe(canvas);
        }
        requestAnimationFrame(frame);
    }

    /* ---------- Manager vs Leader switch ---------- */
    $$('[data-shift]').forEach(function (wrap) {
        var btn = $('[data-shift-toggle]', wrap), touched = false;
        var set = function (on) {
            wrap.classList.toggle('is-leader', on);
            btn.setAttribute('aria-checked', String(on));
        };
        btn.addEventListener('click', function () { touched = true; set(!wrap.classList.contains('is-leader')); });
        $$('.toggle-label', wrap).forEach(function (l) {
            l.addEventListener('click', function () { touched = true; set(l.getAttribute('data-label') === 'leader'); });
        });
        // Flip once automatically when first seen, to invite people to try it.
        if ('IntersectionObserver' in window) {
            var o = new IntersectionObserver(function (en) {
                if (en[0].isIntersecting) {
                    o.disconnect();
                    setTimeout(function () { if (!touched) set(true); }, 1400);
                }
            }, { threshold: 0.6 });
            o.observe(wrap);
        }
    });

    /* ---------- "Would you follow you?" reflection ---------- */
    var quiz = $('[data-quiz]'), dataEl = $('#quiz-data');
    if (quiz && dataEl) {
        var data = JSON.parse(dataEl.textContent);
        var qs = data.questions, answers = [], idx = 0, locked = false;
        var themes = {};
        data.themes.forEach(function (t) { themes[t.key] = t; });
        var steps = { intro: $('[data-step="intro"]', quiz), questions: $('[data-step="questions"]', quiz), results: $('[data-step="results"]', quiz) };
        var progress = $('[data-progress]', quiz), qText = $('[data-qtext]', quiz), qNum = $('[data-qnum]', quiz), themeLabel = $('[data-theme-label]', quiz);
        var options = $$('.quiz-scale button', quiz), back = $('[data-back]', quiz);

        var show = function (name) { Object.keys(steps).forEach(function (k) { steps[k].hidden = k !== name; }); };
        var render = function () {
            qText.textContent = qs[idx].text;
            qText.style.animation = 'none'; void qText.offsetWidth; qText.style.animation = '';
            qNum.textContent = idx + 1;
            themeLabel.textContent = themes[qs[idx].theme] ? themes[qs[idx].theme].title : '';
            progress.style.width = (idx / qs.length * 100) + '%';
            options.forEach(function (o) { o.setAttribute('aria-checked', String(Number(o.dataset.value) === answers[idx])); });
            back.style.visibility = idx === 0 ? 'hidden' : 'visible';
        };
        var tiers = [
            [80, 'Your team is lucky to have you.', 'Sounds like you might already be well on your way to becoming the worst manager ever. Keep going, and keep the people around you growing.'],
            [60, 'You’re becoming someone worth following.', 'Your team sees real leadership in you. Strengthen the area below and they’ll move from cooperating with you to truly following you.'],
            [40, 'You’re a good manager. That might be the problem.', 'You’ve got a solid base, but your team may be following the title more than the person. The good news? Leadership is a daily decision, and you can start making it tomorrow.'],
            [0,  'Honest answers. That’s where every leader starts.', 'Most managers are never taught any of this. The fact that you answered honestly says you’re ready to do it differently.']
        ];
        var results = function () {
            progress.style.width = '100%';
            var by = {};
            qs.forEach(function (q, i) { (by[q.theme] = by[q.theme] || []).push(answers[i]); });
            var scores = data.themes.map(function (t) {
                var a = by[t.key] || [1];
                var avg = a.reduce(function (s, v) { return s + v; }, 0) / a.length;
                return { t: t, pct: Math.round((avg - 1) / 4 * 100) };
            });
            var total = Math.round(scores.reduce(function (s, x) { return s + x.pct; }, 0) / scores.length);
            var focus = scores.slice().sort(function (a, b) { return a.pct - b.pct; })[0];
            var tier = tiers.filter(function (t) { return total >= t[0]; })[0];

            $('[data-result-title]', quiz).textContent = tier[1];
            $('[data-result-body]', quiz).textContent = tier[2];
            $('[data-focus-title]', quiz).textContent = focus.t.question;
            $('[data-focus-body]', quiz).textContent = focus.t.body;
            var link = $('[data-focus-link]', quiz);
            if (focus.t.article) {
                link.href = focus.t.article.url;
                link.textContent = 'Read: ' + focus.t.article.title;
                link.hidden = false;
            } else {
                link.hidden = true;
            }

            var bars = $('[data-bars]', quiz);
            bars.innerHTML = '';
            scores.forEach(function (s) {
                var li = document.createElement('li');
                if (s === focus) li.className = 'is-focus';
                li.innerHTML = '<span></span><span class="track"><span class="fill"></span></span><span class="pct"></span>';
                li.children[0].textContent = s.t.title;
                li.children[2].textContent = s.pct + '%';
                bars.appendChild(li);
                setTimeout(function () { li.querySelector('.fill').style.width = s.pct + '%'; }, 200);
            });

            show('results');
            var ring = $('[data-ring]', quiz), num = $('[data-score]', quiz);
            setTimeout(function () { ring.style.strokeDashoffset = String(326.7 * (1 - total / 100)); }, 100);
            var start = null;
            var count = function (ts) {
                if (!start) start = ts;
                var k = Math.min(1, (ts - start) / 1400);
                num.textContent = Math.round(total * (1 - Math.pow(1 - k, 3)));
                if (k < 1) requestAnimationFrame(count);
            };
            requestAnimationFrame(count);
            quiz.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
            track('quiz_complete', { score: total, focus: focus.t.key });
        };
        var begin = function () {
            answers = []; idx = 0;
            $('[data-ring]', quiz).style.strokeDashoffset = '';
            show('questions'); render(); options[0].focus();
        };

        $('[data-start]', quiz).addEventListener('click', begin);
        $('[data-restart]', quiz).addEventListener('click', begin);
        options.forEach(function (o) {
            o.addEventListener('click', function () {
                if (locked) return;
                locked = true;
                answers[idx] = Number(o.dataset.value);
                options.forEach(function (x) { x.setAttribute('aria-checked', String(x === o)); });
                setTimeout(function () {
                    locked = false;
                    if (idx < qs.length - 1) { idx++; render(); } else { results(); }
                }, 280);
            });
        });
        // Number keys 1-5 answer the current statement.
        quiz.addEventListener('keydown', function (e) {
            if (!steps.questions.hidden && /^[1-5]$/.test(e.key)) options[Number(e.key) - 1].click();
        });
        back.addEventListener('click', function () { if (idx > 0) { idx--; render(); } });
    }

    /* ---------- Article filters ---------- */
    $$('[data-filters]').forEach(function (wrap) {
        var chips = $$('.chip', wrap), cards = $$('[data-category]');
        chips.forEach(function (c) {
            c.addEventListener('click', function () {
                var f = c.dataset.filter;
                chips.forEach(function (x) { x.classList.toggle('is-active', x === c); x.setAttribute('aria-pressed', String(x === c)); });
                cards.forEach(function (card) { card.classList.toggle('is-hidden', f !== 'all' && card.dataset.category !== f); });
            });
        });
    });

    /* ---------- Newsletter forms (submit without leaving the page) ---------- */
    $$('[data-ajax-form]').forEach(function (form) {
        var status = $('.form-status', form);
        form.addEventListener('submit', function (e) {
            if (!window.fetch) return;
            e.preventDefault();
            var btn = $('button[type="submit"]', form);
            btn.disabled = true;
            fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    status.textContent = res.message;
                    status.classList.toggle('is-error', !res.ok);
                    if (res.ok) { form.reset(); track('newsletter_signup', { source: form.elements.source ? form.elements.source.value : '' }); }
                })
                .catch(function () { status.textContent = 'Something went wrong. Please try again.'; status.classList.add('is-error'); })
                .then(function () { btn.disabled = false; });
        });
    });

    /* ---------- Copy link button ---------- */
    $$('[data-copy]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var label = $('span', btn);
            var done = function () { label.textContent = 'Copied!'; setTimeout(function () { label.textContent = 'Copy link'; }, 2000); };
            if (navigator.clipboard) navigator.clipboard.writeText(btn.dataset.copy).then(done, function () { window.prompt('Copy this link:', btn.dataset.copy); });
            else window.prompt('Copy this link:', btn.dataset.copy);
            track('share', { method: 'copy' });
        });
    });

    /* ---------- Article reading progress ---------- */
    var bar = $('[data-reading-progress]');
    if (bar) {
        var upd = function () {
            var max = document.documentElement.scrollHeight - window.innerHeight;
            bar.style.width = (max > 0 ? window.scrollY / max * 100 : 0) + '%';
        };
        window.addEventListener('scroll', upd, { passive: true });
        upd();
    }
})();
