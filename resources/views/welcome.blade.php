<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Quiz Application | CAU Imphal</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
<style>
  :root {
    --forest: #1a3a2a;
    --leaf: #2d6a4f;
    --mint: #52b788;
    --lime: #95d5b2;
    --cream: #f8f4ed;
    --sand: #e9e0ce;
    --gold: #c9a84c;
    --ink: #0f1f17;
    --white: #ffffff;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--ink);
    overflow-x: hidden;
  }

  /* ── NAV ── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 3rem;
    background: rgba(26,58,42,0.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(149,213,178,0.15);
  }
  .nav-brand { display: flex; align-items: center; gap: .75rem; text-decoration: none; }
  .nav-logo {
    width: 38px; height: 38px; border-radius: 50%;
    background: var(--gold);
    display: grid; place-items: center;
    font-family: 'Playfair Display', serif;
    font-weight: 900; font-size: 1rem; color: var(--forest);
  }
  .nav-title { font-size: .9rem; font-weight: 500; color: var(--lime); letter-spacing: .04em; }
  .nav-links { display: flex; gap: 2rem; list-style: none; }
  .nav-links a {
    text-decoration: none; color: rgba(255,255,255,.7);
    font-size: .85rem; font-weight: 400; letter-spacing: .03em;
    transition: color .2s;
  }
  .nav-links a:hover { color: var(--lime); }
  .nav-cta {
    background: var(--gold); color: var(--forest);
    border: none; padding: .5rem 1.4rem;
    border-radius: 2rem; font-weight: 500; font-size: .85rem;
    cursor: pointer; text-decoration: none;
    transition: opacity .2s, transform .2s;
  }
  .nav-cta:hover { opacity: .85; transform: translateY(-1px); }

  /* ── HERO ── */
  .hero {
    min-height: 100vh;
    background: var(--forest);
    position: relative; overflow: hidden;
    display: flex; align-items: center;
    padding: 8rem 3rem 5rem;
  }
  .hero-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
      radial-gradient(ellipse 60% 60% at 75% 50%, rgba(45,106,79,.55) 0%, transparent 70%),
      radial-gradient(ellipse 40% 40% at 20% 80%, rgba(82,183,136,.2) 0%, transparent 60%);
  }
  /* animated dots grid */
  .hero-grid {
    position: absolute; inset: 0; z-index: 0;
    background-image: radial-gradient(rgba(149,213,178,.18) 1px, transparent 1px);
    background-size: 36px 36px;
    animation: gridDrift 20s linear infinite;
  }
  @keyframes gridDrift { 0%{background-position:0 0} 100%{background-position:36px 36px} }

  .hero-content { position: relative; z-index: 1; max-width: 640px; }
  .hero-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(201,168,76,.15); border: 1px solid rgba(201,168,76,.4);
    color: var(--gold); padding: .35rem 1rem; border-radius: 2rem;
    font-size: .78rem; font-weight: 500; letter-spacing: .06em; text-transform: uppercase;
    margin-bottom: 1.5rem;
    animation: fadeUp .6s ease both;
  }
  .hero-badge::before { content: '●'; font-size: .5rem; animation: pulse 2s ease infinite; }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

  h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.6rem, 5vw, 4.2rem);
    font-weight: 900; line-height: 1.1;
    color: var(--white);
    margin-bottom: 1.4rem;
    animation: fadeUp .6s .1s ease both;
  }
  h1 em { color: var(--mint); font-style: normal; }

  .hero-sub {
    font-size: 1.05rem; font-weight: 300; line-height: 1.7;
    color: rgba(255,255,255,.65); max-width: 480px;
    margin-bottom: 2.4rem;
    animation: fadeUp .6s .2s ease both;
  }
  .hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; animation: fadeUp .6s .3s ease both; }
  .btn-primary {
    background: var(--gold); color: var(--forest);
    padding: .85rem 2.2rem; border-radius: 3rem; font-weight: 600;
    font-size: .95rem; text-decoration: none; border: none; cursor: pointer;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 4px 24px rgba(201,168,76,.4);
  }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(201,168,76,.5); }
  .btn-secondary {
    background: transparent; color: var(--white);
    padding: .85rem 2.2rem; border-radius: 3rem; font-weight: 400;
    font-size: .95rem; text-decoration: none; border: 1px solid rgba(255,255,255,.3);
    transition: background .2s, border-color .2s;
  }
  .btn-secondary:hover { background: rgba(255,255,255,.07); border-color: var(--lime); }

  /* floating card */
  .hero-visual {
    position: absolute; right: 5%; top: 50%; transform: translateY(-50%);
    z-index: 1; width: min(400px, 38vw);
    animation: float 5s ease-in-out infinite;
  }
  @keyframes float { 0%,100%{transform:translateY(-50%) translateY(0)} 50%{transform:translateY(-50%) translateY(-18px)} }
  .quiz-card {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(149,213,178,.2);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(18px);
  }
  .card-header { font-size: .7rem; color: var(--lime); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 1rem; }
  .card-question { font-size: .95rem; color: var(--white); font-weight: 400; line-height: 1.5; margin-bottom: 1.4rem; }
  .card-options { display: flex; flex-direction: column; gap: .6rem; }
  .card-opt {
    display: flex; align-items: center; gap: .75rem;
    padding: .65rem 1rem; border-radius: .75rem;
    font-size: .85rem; color: rgba(255,255,255,.7);
    border: 1px solid rgba(149,213,178,.15);
    background: rgba(255,255,255,.04);
    cursor: pointer; transition: all .2s;
  }
  .card-opt.active {
    background: rgba(82,183,136,.2);
    border-color: var(--mint);
    color: var(--white);
  }
  .card-opt span {
    width: 22px; height: 22px; border-radius: 50%;
    border: 1.5px solid rgba(149,213,178,.4);
    display: grid; place-items: center; font-size: .7rem; flex-shrink: 0;
  }
  .card-opt.active span { background: var(--mint); border-color: var(--mint); color: var(--forest); font-weight: 700; }
  .card-timer {
    margin-top: 1.4rem; display: flex; align-items: center; justify-content: space-between;
    padding-top: 1rem; border-top: 1px solid rgba(255,255,255,.08);
  }
  .timer-label { font-size: .75rem; color: rgba(255,255,255,.4); }
  .timer-value { font-size: 1.2rem; font-family: 'Playfair Display', serif; color: var(--gold); font-weight: 700; }

  @keyframes fadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }

  /* ── STATS ── */
  .stats {
    background: var(--ink);
    padding: 3rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 2rem;
    text-align: center;
    border-top: 1px solid rgba(82,183,136,.1);
  }
  .stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem; font-weight: 900;
    color: var(--mint); display: block; line-height: 1;
    margin-bottom: .3rem;
  }
  .stat-label { font-size: .78rem; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .08em; }

  /* ── FEATURES ── */
  .features {
    padding: 6rem 3rem;
    background: var(--cream);
  }
  .section-label {
    font-size: .75rem; text-transform: uppercase; letter-spacing: .12em;
    color: var(--leaf); font-weight: 600; margin-bottom: .75rem;
  }
  .section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 900;
    color: var(--forest); line-height: 1.2; margin-bottom: 1rem;
  }
  .section-sub { font-size: 1rem; color: #5a6e60; max-width: 480px; line-height: 1.7; margin-bottom: 3.5rem; }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
  }
  .feature-card {
    background: var(--white);
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid rgba(45,106,79,.1);
    transition: transform .25s, box-shadow .25s;
    position: relative; overflow: hidden;
  }
  .feature-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--leaf), var(--mint));
    opacity: 0; transition: opacity .25s;
  }
  .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(45,106,79,.12); }
  .feature-card:hover::before { opacity: 1; }
  .feature-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: linear-gradient(135deg, var(--forest), var(--leaf));
    display: grid; place-items: center; font-size: 1.3rem;
    margin-bottom: 1.2rem;
  }
  .feature-card h3 { font-size: 1.05rem; font-weight: 600; color: var(--forest); margin-bottom: .5rem; }
  .feature-card p { font-size: .88rem; color: #6a7d70; line-height: 1.6; }

  /* ── HOW IT WORKS ── */
  .how {
    padding: 6rem 3rem;
    background: var(--forest);
    position: relative; overflow: hidden;
  }
  .how::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 50% 70% at 80% 50%, rgba(82,183,136,.1) 0%, transparent 70%);
  }
  .how .section-label { color: var(--lime); }
  .how .section-title { color: var(--white); }
  .how .section-sub { color: rgba(255,255,255,.5); }
  .steps {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem; position: relative; z-index: 1;
  }
  .step { text-align: center; }
  .step-num {
    font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900;
    color: rgba(149,213,178,.15); line-height: 1; margin-bottom: .5rem;
  }
  .step-icon {
    font-size: 2rem; margin-bottom: 1rem;
    display: block;
  }
  .step h4 { font-size: 1rem; font-weight: 600; color: var(--white); margin-bottom: .5rem; }
  .step p { font-size: .85rem; color: rgba(255,255,255,.45); line-height: 1.6; }

  /* ── CTA ── */
  .cta-section {
    padding: 6rem 3rem; text-align: center;
    background: var(--sand);
    position: relative;
  }
  .cta-section::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(45,106,79,.06) 0%, transparent 70%);
  }
  .cta-section .section-title { color: var(--forest); }
  .cta-section p { color: #5a6e60; max-width: 460px; margin: 0 auto 2.5rem; line-height: 1.7; font-size: 1rem; }
  .cta-buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; position: relative; z-index:1; }
  .cta-section .section-title { position: relative; z-index: 1; }
  .cta-section p { position: relative; z-index: 1; }

  /* ── FOOTER ── */
  footer {
    background: var(--ink);
    padding: 2.5rem 3rem;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    border-top: 1px solid rgba(82,183,136,.1);
  }
  .footer-brand { font-family: 'Playfair Display', serif; color: var(--white); font-size: 1rem; }
  .footer-brand span { color: var(--mint); }
  .footer-copy { font-size: .78rem; color: rgba(255,255,255,.3); }
  .footer-links { display: flex; gap: 1.5rem; }
  .footer-links a { font-size: .78rem; color: rgba(255,255,255,.35); text-decoration: none; transition: color .2s; }
  .footer-links a:hover { color: var(--lime); }

  /* ── RESPONSIVE ── */
  @media (max-width: 768px) {
    nav { padding: 1rem 1.4rem; }
    .nav-links { display: none; }
    .hero { padding: 7rem 1.4rem 4rem; }
    .hero-visual { display: none; }
    .stats, .features, .how, .cta-section { padding: 4rem 1.4rem; }
    footer { padding: 2rem 1.4rem; flex-direction: column; text-align: center; }
    .footer-links { justify-content: center; }
  }

  /* ── AI SECTION ── */
  .ai-section {
    padding: 6rem 3rem;
    background: #0f1f17;
    position: relative; overflow: hidden;
  }
  .ai-section::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 40% 60% at 30% 50%, rgba(82,183,136,.08) 0%, transparent 60%),
                radial-gradient(ellipse 40% 60% at 70% 50%, rgba(201,168,76,.05) 0%, transparent 60%);
  }
  .ai-inner { position: relative; z-index: 1; max-width: 700px; }
  .ai-section .section-label { color: var(--gold); }
  .ai-section .section-title { color: var(--white); margin-bottom: 1rem; }
  .ai-section .section-sub { color: rgba(255,255,255,.45); margin-bottom: 2rem; }
  .ai-chat-box {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(149,213,178,.15);
    border-radius: 16px; padding: 1.5rem;
    backdrop-filter: blur(10px);
  }
  #ai-messages { display: flex; flex-direction: column; gap: .9rem; min-height: 80px; max-height: 260px; overflow-y: auto; margin-bottom: 1rem; }
  .msg { font-size: .88rem; line-height: 1.6; border-radius: 10px; padding: .7rem 1rem; max-width: 90%; }
  .msg-user { background: rgba(201,168,76,.15); color: var(--gold); align-self: flex-end; }
  .msg-ai { background: rgba(82,183,136,.1); color: rgba(255,255,255,.8); align-self: flex-start; }
  .msg-typing { color: rgba(255,255,255,.3); font-style: italic; font-size: .82rem; }
  .ai-input-row { display: flex; gap: .6rem; }
  #ai-input {
    flex: 1; background: rgba(255,255,255,.06); border: 1px solid rgba(149,213,178,.2);
    border-radius: 8px; padding: .7rem 1rem; color: var(--white);
    font-size: .88rem; font-family: 'DM Sans', sans-serif;
    outline: none; transition: border-color .2s;
  }
  #ai-input::placeholder { color: rgba(255,255,255,.25); }
  #ai-input:focus { border-color: var(--mint); }
  #ai-send {
    background: var(--mint); color: var(--forest);
    border: none; border-radius: 8px; padding: .7rem 1.3rem;
    font-weight: 600; font-size: .85rem; cursor: pointer;
    transition: opacity .2s;
  }
  #ai-send:hover { opacity: .85; }
  #ai-send:disabled { opacity: .4; cursor: not-allowed; }
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <a class="nav-brand" href="#">
    <div class="nav-logo">CAU</div>
    <span class="nav-title">Quiz Application · V2.1</span>
  </a>
  <ul class="nav-links">
    <li><a href="#">Home</a></li>
    <li><a href="https://cau.ac.in/university-profile/" target="_blank">About CAU</a></li>
    <li><a href="https://cauimphal.online/quizapp/public/files/user_manual.docx">User Manual</a></li>
    <li><a href="https://cau.ac.in/contacts-cau-imphal/" target="_blank">Contact</a></li>
  </ul>
  <a class="nav-cta" href="https://cauimphal.online/quizapp/public/login">Login</a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>
  <div class="hero-content">
    <div class="hero-badge">Central Agricultural University · Imphal</div>
    <h1>Smart Exams.<br/><em>Smarter</em> Learning.</h1>
    <p class="hero-sub">A modern quiz and examination platform built for CAU Imphal students. Take MCQ-based assessments anytime, anywhere — with auto-grading and real-time timers.</p>
    <div class="hero-actions">
      <a class="btn-primary" href="https://cauimphal.online/quizapp/public/register">Register Now</a>
      <a class="btn-secondary" href="https://cauimphal.online/quizapp/public/login">Sign In →</a>
    </div>
  </div>

  <!-- Floating Quiz Card -->
  <div class="hero-visual">
    <div class="quiz-card">
      <div class="card-header">📋 Sample Question · Agronomy 101</div>
      <div class="card-question">Which nutrient is most responsible for promoting root growth in crops?</div>
      <div class="card-options">
        <div class="card-opt"><span>A</span> Nitrogen (N)</div>
        <div class="card-opt active"><span>✓</span> Phosphorus (P)</div>
        <div class="card-opt"><span>C</span> Potassium (K)</div>
        <div class="card-opt"><span>D</span> Calcium (Ca)</div>
      </div>
      <div class="card-timer">
        <span class="timer-label">⏱ Time Remaining</span>
        <span class="timer-value" id="timer">14:32</span>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats">
  <div>
    <span class="stat-num">MCQ</span>
    <span class="stat-label">Question Format</span>
  </div>
  <div>
    <span class="stat-num">Auto</span>
    <span class="stat-label">Graded Results</span>
  </div>
  <div>
    <span class="stat-num">Live</span>
    <span class="stat-label">Countdown Timer</span>
  </div>
  <div>
    <span class="stat-num">Free</span>
    <span class="stat-label">Student Registration</span>
  </div>
</div>

<!-- FEATURES -->
<section class="features">
  <div class="section-label">Platform Features</div>
  <h2 class="section-title">Everything you need<br/>to ace your exams.</h2>
  <p class="section-sub">Designed and developed by Er. S Govind Singh, System Analyst, CAU Imphal — for a seamless, fair, and modern examination experience.</p>
  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">📝</div>
      <h3>MCQ-Based Assessments</h3>
      <p>All quizzes follow Multiple Choice format — 2 or 4 options per question with one correct answer. Clear and structured for every subject.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">⏱</div>
      <h3>Countdown Timer</h3>
      <p>Each quiz has a dedicated time limit. When time expires, your answers are automatically submitted — no late entries.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🔐</div>
      <h3>Secure Accounts</h3>
      <p>Students register once and access all available quizzes through their personal account. Safe, private, and easy.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">🏫</div>
      <h3>University-Official</h3>
      <p>Officially deployed under CAU Imphal. Quizzes are posted by faculty and available as per academic schedule.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">📱</div>
      <h3>Device Friendly</h3>
      <p>Accessible on any device — mobile, tablet, or desktop. Attempt your exam from wherever you are on campus.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon">⚡</div>
      <h3>Instant & Automatic</h3>
      <p>Results are computed instantly after submission. No waiting, no manual correction — fair and fast for everyone.</p>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how">
  <div class="section-label">How It Works</div>
  <h2 class="section-title" style="margin-bottom:.75rem">Three steps to your next quiz.</h2>
  <p class="section-sub">Getting started takes under a minute. Here's what happens.</p>
  <div class="steps">
    <div class="step">
      <div class="step-num">01</div>
      <span class="step-icon">👤</span>
      <h4>Create Your Account</h4>
      <p>Register with your student details. One account for all quizzes and exams throughout your programme.</p>
    </div>
    <div class="step">
      <div class="step-num">02</div>
      <span class="step-icon">📚</span>
      <h4>Browse Available Quizzes</h4>
      <p>Log in to see quizzes opened by your faculty. Pick one and begin when you're ready — before the deadline.</p>
    </div>
    <div class="step">
      <div class="step-num">03</div>
      <span class="step-icon">✅</span>
      <h4>Attempt & Submit</h4>
      <p>Answer MCQs carefully, mark answers, and submit. The timer auto-closes the quiz when time is up.</p>
    </div>
    <div class="step">
      <div class="step-num">04</div>
      <span class="step-icon">🏆</span>
      <h4>View Your Result</h4>
      <p>Get your score instantly after submission. Track your performance over time and improve each attempt.</p>
    </div>
  </div>
</section>

<!-- AI ASSISTANT SECTION -->
<section class="ai-section">
  <div class="ai-inner">
    <div class="section-label">AI Study Assistant</div>
    <h2 class="section-title">Ask anything about<br/>your exam preparation.</h2>
    <p class="section-sub">Have a question about how the platform works, or need a quick subject question explained? Chat with our AI assistant below.</p>
    <div class="ai-chat-box">
      <div id="ai-messages">
        <div class="msg msg-ai">👋 Hello! I'm your CAU Imphal Quiz Assistant. Ask me anything about the platform, exam tips, or agricultural science topics!</div>
      </div>
      <div class="ai-input-row">
        <input id="ai-input" type="text" placeholder="E.g. How do I register? What is photosynthesis?" />
        <button id="ai-send">Ask →</button>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="section-label">Get Started Today</div>
  <h2 class="section-title">Ready to take your exam?</h2>
  <p>Join students across CAU Imphal on the official digital examination platform. Registration is free and takes only moments.</p>
  <div class="cta-buttons">
    <a class="btn-primary" href="https://cauimphal.online/quizapp/public/register">Create Free Account</a>
    <a class="btn-secondary" style="background:transparent;color:var(--forest);border:1px solid rgba(26,58,42,.3)" href="https://cauimphal.online/quizapp/public/login">Already registered? Login</a>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-brand">CAU <span>Imphal</span> · Quiz Application</div>
  <div class="footer-copy">© 2023–2026 All Rights Reserved · Designed by Er. S Govind Singh, System Analyst</div>
  <div class="footer-links">
    <a href="https://cau.ac.in/university-profile/" target="_blank">About CAU</a>
    <a href="https://cauimphal.online/quizapp/public/files/user_manual.docx">User Manual</a>
    <a href="https://cau.ac.in/contacts-cau-imphal/" target="_blank">Contact</a>
  </div>
</footer>

<script>
  // Live countdown in hero card
  let totalSecs = 14 * 60 + 32;
  setInterval(() => {
    totalSecs = Math.max(0, totalSecs - 1);
    const m = String(Math.floor(totalSecs / 60)).padStart(2, '0');
    const s = String(totalSecs % 60).padStart(2, '0');
    const el = document.getElementById('timer');
    if (el) el.textContent = m + ':' + s;
  }, 1000);

  // AI Chat
  const input = document.getElementById('ai-input');
  const sendBtn = document.getElementById('ai-send');
  const messages = document.getElementById('ai-messages');

  function appendMsg(text, type) {
    const d = document.createElement('div');
    d.className = 'msg msg-' + type;
    d.textContent = text;
    messages.appendChild(d);
    messages.scrollTop = messages.scrollHeight;
    return d;
  }

  async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;
    appendMsg(text, 'user');
    input.value = '';
    sendBtn.disabled = true;
    const typing = appendMsg('Thinking…', 'typing');

    try {
      const res = await fetch('https://api.anthropic.com/v1/messages', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          model: 'claude-sonnet-4-20250514',
          max_tokens: 1000,
          system: `You are a helpful AI assistant for the CAU Imphal Quiz Application — an online MCQ exam platform for Central Agricultural University, Imphal, India. 
You help students with:
- Questions about how the platform works (registration, login, taking quizzes, timers, MCQ format)
- Study tips for agricultural science subjects
- Brief, helpful explanations of agricultural concepts
Keep replies concise (2-4 sentences max), friendly, and focused. Respond in English.`,
          messages: [{ role: 'user', content: text }]
        })
      });
      const data = await res.json();
      const reply = data?.content?.[0]?.text || 'Sorry, I could not get a response right now. Please try again.';
      typing.remove();
      appendMsg(reply, 'ai');
    } catch (e) {
      typing.remove();
      appendMsg('Connection issue. Please try again shortly.', 'ai');
    } finally {
      sendBtn.disabled = false;
    }
  }

  sendBtn.addEventListener('click', sendMessage);
  input.addEventListener('keydown', e => { if (e.key === 'Enter') sendMessage(); });
</script>
</body>
</html>
