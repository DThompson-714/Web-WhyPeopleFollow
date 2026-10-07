/* Why People Follow — site interactions (no dependencies). */
(function () {
    'use strict';

    document.documentElement.classList.add('js');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var $ = function (sel, ctx) { return (ctx || document).querySelector(sel); };
    var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };

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
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(function (el) { io.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('is-visible'); });
    }

    /* ---------- Hero word swap: manage -> supervise -> delegate -> lead ---------- */
    $$('[data-word-swap]').forEach(function (el) {
        var words = JSON.parse(el.getAttribute('data-word-swap'));
        var i = 0;
        if (reduceMotion) return;
        function next() {
            var span = el.firstElementChild;
            span.classList.add('out');
            setTimeout(function () {
                i = (i + 1) % words.length;
                span.textContent = words[i];
                span.classList.remove('out');
                span.classList.add('in');
                requestAnimationFrame(function () { requestAnimationFrame(function () { span.classList.remove('in'); }); });
                setTimeout(next, 1700);
            }, 420);
        }
        setTimeout(next, 1800);
    });

    /* ---------- Hero canvas: followers drawn toward a leader ---------- */
    var canvas = $('[data-constellation]');
    if (canvas && canvas.getContext && !reduceMotion) {
        var ctx = canvas.getContext('2d');
        var dpr = Math.min(window.devicePixelRatio || 1, 2);
        var w, h, dots = [], leader = { x: 0, y: 0, tx: 0, ty: 0 }, pointer = null, t = 0, running = true;

        var resize = function () {
            w = canvas.offsetWidth; h = canvas.offsetHeight;
            canvas.width = w * dpr; canvas.height = h * dpr;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            var count = Math.round(Math.min(80, (w * h) / 16000));
            dots = [];
            for (var i = 0; i < count; i++) {
                dots.push({ x: Math.random() * w, y: Math.random() * h, vx: (Math.random() - .5) * .4, vy: (Math.random() - .5) * .4, r: Math.random() * 1.6 + .8 });
            }
            leader.x = w * .75; leader.y = h * .4;
        };
        resize();
        window.addEventListener('resize', resize);
        canvas.parentNode.parentNode.addEventListener('pointermove', function (e) {
            var rect = canvas.getBoundingClientRect();
            pointer = { x: e.clientX - rect.left, y: e.clientY - rect.top };
        });
        canvas.parentNode.parentNode.addEventListener('pointerleave', function () { pointer = null; });

        // Pause animation when hero is off-screen.
        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (en) {
                running = en[0].isIntersecting;
                if (running) requestAnimationFrame(frame);
            }).observe(canvas);
        }

        var frame = function () {
            if (!running) return;
            t += 0.004;
            // Leader wanders on a gentle path, or follows the pointer.
            leader.tx = pointer ? pointer.x : w * (.68 + Math.cos(t) * .16);
            leader.ty = pointer ? pointer.y : h * (.42 + Math.sin(t * 1.3) * .2);
            leader.x += (leader.tx - leader.x) * .03;
            leader.y += (leader.ty - leader.y) * .03;

            ctx.clearRect(0, 0, w, h);
            for (var i = 0; i < dots.length; i++) {
                var d = dots[i];
                var dx = leader.x - d.x, dy = leader.y - d.y, dist = Math.sqrt(dx * dx + dy * dy) || 1;
                if (dist < 260) {                     // within influence: drift toward the leader
                    d.vx += (dx / dist) * .012;
                    d.vy += (dy / dist) * .012;
                }
                if (dist < 40) { d.vx -= (dx / dist) * .08; d.vy -= (dy / dist) * .08; } // personal space
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
                    var e = dots[j], ex = d.x - e.x, ey = d.y - e.y, ed = ex * ex + ey * ey;
                    if (ed < 9000) {
                        ctx.strokeStyle = 'rgba(143,163,191,' + (0.12 * (1 - ed / 9000)) + ')';
                        ctx.beginPath(); ctx.moveTo(d.x, d.y); ctx.lineTo(e.x, e.y); ctx.stroke();
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
        requestAnimationFrame(frame);
    }

    /* ---------- Manager vs Leader toggle ---------- */
    $$('[data-shift]').forEach(function (wrap) {
        var btn = $('[data-shift-toggle]', wrap), touched = false;
        var set = function (on) {
            wrap.classList.toggle('is-leader', on);
            btn.setAttribute('aria-checked', String(on));
        };
        btn.addEventListener('click', function () { touched = true; set(!wrap.classList.contains('is-leader')); });
        $$('.toggle-label', wrap).forEach(function (l) {
            l.style.cursor = 'pointer';
            l.addEventListener('click', function () { touched = true; set(l.getAttribute('data-label') === 'leader'); });
        });
        // Flip automatically once when first seen, to invite interaction.
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

    /* ---------- Subtle 3D tilt on pillar cards ---------- */
    if (!reduceMotion && window.matchMedia('(hover: hover)').matches) {
        $$('[data-tilt]').forEach(function (card) {
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                var x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
                card.style.transform = 'perspective(800px) rotateY(' + (x * 8) + 'deg) rotateX(' + (-y * 8) + 'deg) translateY(-6px)';
            });
            card.addEventListener('pointerleave', function () { card.style.transform = ''; });
        });
    }

    /* ---------- Leader Assessment ---------- */
    var assess = $('[data-assessment]'), dataEl = $('#assessment-data');
    if (assess && dataEl) {
        var data = JSON.parse(dataEl.textContent);
        var qs = data.questions, answers = [], idx = 0;
        var steps = { intro: $('[data-step="intro"]', assess), questions: $('[data-step="questions"]', assess), results: $('[data-step="results"]', assess) };
        var progress = $('[data-progress]', assess), qText = $('[data-qtext]', assess), qNum = $('[data-qnum]', assess);
        var options = $$('.assess-scale button', assess), back = $('[data-back]', assess), locked = false;

        var show = function (name) {
            Object.keys(steps).forEach(function (k) { steps[k].hidden = k !== name; });
        };
        var render = function () {
            qText.textContent = qs[idx].text;
            qText.style.animation = 'none'; void qText.offsetWidth; qText.style.animation = '';
            qNum.textContent = idx + 1;
            progress.style.width = (idx / qs.length * 100) + '%';
            options.forEach(function (o) { o.setAttribute('aria-checked', String(Number(o.dataset.value) === answers[idx])); });
            back.style.visibility = idx === 0 ? 'hidden' : 'visible';
        };
        var results = function () {
            progress.style.width = '100%';
            var by = {};
            qs.forEach(function (q, i) { (by[q.pillar] = by[q.pillar] || []).push(answers[i]); });
            var scores = data.pillars.map(function (p) {
                var a = by[p.key] || [1];
                var avg = a.reduce(function (s, v) { return s + v; }, 0) / a.length;
                return { p: p, pct: Math.round((avg - 1) / 4 * 100) };
            });
            var total = Math.round(scores.reduce(function (s, x) { return s + x.pct; }, 0) / scores.length);
            var focus = scores.slice().sort(function (a, b) { return a.pct - b.pct; })[0];

            var tiers = [
                [80, 'People are already choosing to follow you.', 'You have strong leadership habits. The next step is turning your team into leaders too — and keeping your focus pillar from becoming a blind spot.'],
                [60, 'You\'re becoming a leader worth following.', 'Your team sees real leadership in you. Strengthening your focus pillar will move them from cooperating to fully committing.'],
                [40, 'You\'re managing well — leading is the next step.', 'You have a solid base, but your team may be following the title more than the person. Small, consistent habits will change that fast.'],
                [0, 'You\'re at the starting line — and that\'s a great place to be.', 'Most new managers are never taught any of this. The fact that you took this assessment says you\'re ready to lead differently.']
            ];
            var tier = tiers.filter(function (t) { return total >= t[0]; })[0];
            $('[data-result-title]', assess).textContent = tier[1];
            $('[data-result-body]', assess).textContent = tier[2];
            $('[data-focus-title]', assess).textContent = focus.p.title + ': ' + focus.p.line;
            $('[data-focus-body]', assess).textContent = focus.p.body;

            var bars = $('[data-bars]', assess);
            bars.innerHTML = '';
            scores.forEach(function (s) {
                var li = document.createElement('li');
                if (s === focus) li.className = 'is-focus';
                li.innerHTML = '<span></span><span class="track"><span class="fill"></span></span><span class="pct"></span>';
                li.children[0].textContent = s.p.title;
                li.children[2].textContent = s.pct + '%';
                bars.appendChild(li);
                setTimeout(function () { li.querySelector('.fill').style.width = s.pct + '%'; }, 200);
            });

            show('results');
            var ring = $('[data-ring]', assess), num = $('[data-score]', assess);
            setTimeout(function () { ring.style.strokeDashoffset = String(326.7 * (1 - total / 100)); }, 100);
            var start = null;
            var count = function (ts) {
                if (!start) start = ts;
                var k = Math.min(1, (ts - start) / 1400);
                num.textContent = Math.round(total * (1 - Math.pow(1 - k, 3)));
                if (k < 1) requestAnimationFrame(count);
            };
            requestAnimationFrame(count);
            assess.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });

            if (window.gtag) window.gtag('event', 'assessment_complete', { score: total, focus: focus.p.key });
        };

        $('[data-start]', assess).addEventListener('click', function () {
            answers = []; idx = 0; show('questions'); render(); options[0].focus();
        });
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
        // Number keys 1-5 answer the current question.
        assess.addEventListener('keydown', function (e) {
            if (!steps.questions.hidden && /^[1-5]$/.test(e.key)) options[Number(e.key) - 1].click();
        });
        back.addEventListener('click', function () { if (idx > 0) { idx--; render(); } });
        $('[data-restart]', assess).addEventListener('click', function () {
            $('[data-ring]', assess).style.strokeDashoffset = '';
            answers = []; idx = 0; show('questions'); render();
        });
    }

    /* ---------- Testimonial carousel ---------- */
    $$('[data-carousel]').forEach(function (car) {
        var track = $('.carousel-track', car), slides = $$('.quote', car), dotsWrap = $('.carousel-dots', car), cur = 0, timer;
        if (slides.length < 2) { dotsWrap.remove(); return; }
        var go = function (n) {
            cur = (n + slides.length) % slides.length;
            track.style.transform = 'translateX(' + (-cur * 100) + '%)';
            $$('button', dotsWrap).forEach(function (d, i) { d.setAttribute('aria-selected', String(i === cur)); });
        };
        slides.forEach(function (_, i) {
            var d = document.createElement('button');
            d.setAttribute('role', 'tab');
            d.setAttribute('aria-label', 'Testimonial ' + (i + 1));
            d.addEventListener('click', function () { go(i); restart(); });
            dotsWrap.appendChild(d);
        });
        var restart = function () { clearInterval(timer); if (!reduceMotion) timer = setInterval(function () { go(cur + 1); }, 7000); };
        car.addEventListener('mouseenter', function () { clearInterval(timer); });
        car.addEventListener('mouseleave', restart);
        // Swipe support
        var sx = null;
        car.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
        car.addEventListener('touchend', function (e) {
            if (sx === null) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 40) { go(cur + (dx < 0 ? 1 : -1)); restart(); }
            sx = null;
        });
        go(0); restart();
    });

    /* ---------- Accessible tabs (Approach page) ---------- */
    $$('[data-tabs]').forEach(function (wrap) {
        var tabs = $$('[role="tab"]', wrap);
        var select = function (tab) {
            tabs.forEach(function (t) {
                var on = t === tab;
                t.setAttribute('aria-selected', String(on));
                t.tabIndex = on ? 0 : -1;
                document.getElementById(t.getAttribute('aria-controls')).hidden = !on;
            });
            history.replaceState(null, '', '#' + tab.id.replace('tab-', ''));
        };
        tabs.forEach(function (t, i) {
            t.addEventListener('click', function () { select(t); });
            t.addEventListener('keydown', function (e) {
                var n = e.key === 'ArrowRight' ? i + 1 : e.key === 'ArrowLeft' ? i - 1 : null;
                if (n === null) return;
                var target = tabs[(n + tabs.length) % tabs.length];
                target.focus(); select(target);
            });
        });
        var fromHash = location.hash && document.getElementById('tab-' + location.hash.slice(1));
        if (fromHash) select(fromHash);
    });

    /* ---------- Resource filters ---------- */
    $$('[data-filters]').forEach(function (wrap) {
        var chips = $$('.chip', wrap), cards = $$('[data-pillar]');
        chips.forEach(function (c) {
            c.addEventListener('click', function () {
                var f = c.dataset.filter;
                chips.forEach(function (x) { x.classList.toggle('is-active', x === c); x.setAttribute('aria-pressed', String(x === c)); });
                cards.forEach(function (card) { card.classList.toggle('is-hidden', f !== 'all' && card.dataset.pillar !== f); });
            });
        });
    });

    /* ---------- AJAX newsletter form ---------- */
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
                    if (res.ok) { form.reset(); if (window.gtag) window.gtag('event', 'newsletter_signup'); }
                })
                .catch(function () { status.textContent = 'Something went wrong. Please try again.'; })
                .then(function () { btn.disabled = false; });
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
