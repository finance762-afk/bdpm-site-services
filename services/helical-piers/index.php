<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/helical-piers/ — Phase 4 service page (premium editorial structure, warm-human archetype).
 * No client photos exist yet, so the page is typographic; its signature section is a CSS depth diagram of a pier.
 * Sources (checked 2026-10-19):
 *   Frost line 48 in — 780 CMR 51.00 (10th ed.) Table R301.2(1), https://www.mass.gov/doc/10th-edition-residential-chapter-3-building-planning/download
 *   Helical piles as an engineered deep foundation — IBC 1810.3.1.5 / 780 CMR chapter 18 (base code)
 *   Torque-to-capacity correlation — standard helical pile practice (ICC-ES AC358)
 *   Soil and site conditions FAQ — build-plan research_brief.faqs
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$svc             = serviceBySlug('helical-piers');
$pageTitle       = 'Helical Pier Installation Plymouth MA | BDPM Site Services';
$pageDescription = 'Helical pier installation in Plymouth, MA for new foundations, additions, decks and porches, with far less digging than footings. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/services/helical-piers/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'helical-piers';
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/helical-piers/'],
];

$hpTel = formatPhone($phone, 'tel');

// FAQ — the soil question from research_brief.faqs (the question a pier job turns on)
$hpFaqs = [
    ['q' => 'What types of soil and site conditions do you deal with in Plymouth?',
     'a' => 'Plymouth sites vary widely, from sandy and gravelly soils to clay, old fill and exposed ledge. BDPM Site Services assesses each site during the estimate so the right equipment, drainage and disposal plan are in the quote before work begins. For a pier job, that visit also shows whether helical piers or a poured footing suits the ground better.'],
];

$schemaMarkup = array_merge(servicePageSchema($svc,
    'Helical pier installation in Plymouth, MA: steel piers turned down to load-bearing soil for new foundations, additions, decks and porches, with installation torque tracked on each pier.'),
    [generateFAQSchema($hpFaqs)]);

$hpReasons = [
    ['icon' => 'layers', 'title' => 'Loose sand or old fill', 'text' => 'A footing sits on whatever is at its depth. A pier passes through soft layers to the firm soil below.'],
    ['icon' => 'droplets', 'title' => 'High groundwater', 'text' => 'No open hole to pump out or keep from caving; the shaft goes down through the water table.'],
    ['icon' => 'fence', 'title' => 'Tight access', 'text' => 'Backyard decks and additions where a concrete truck cannot reach and there is no room to stockpile spoil.'],
    ['icon' => 'clock', 'title' => 'No cure time', 'text' => 'A pier can carry load once it is installed, so framing does not wait on concrete.'],
];

$hpLayers = [
    ['class' => 'hp-l1', 'name' => 'Topsoil and loam', 'note' => 'Stripped back around the pier location'],
    ['class' => 'hp-l2', 'name' => 'Loose sand or old fill', 'note' => 'Too soft to trust under a footing'],
    ['class' => 'hp-l3', 'name' => 'Firm bearing soil', 'note' => 'Torque climbs; the plates take the load here'],
];

$hpCompare = [
    ['Excavation', 'A small pilot area at most', 'A hole dug below the 48-inch frost line'],
    ['Spoil to move', 'Little to none', 'The soil from every hole'],
    ['Cure time', 'None; it can take load once installed', 'Concrete has to cure before loading'],
    ['Loose or wet soil', 'Passes through to firm soil below', 'May need over-digging, dewatering or a larger footing'],
    ['How capacity is checked', 'Installation torque on each pier', 'Assumed from the soil at the bottom of the hole'],
    ['Where it fits best', 'Soft or wet soil, tight access, additions and decks', 'Firm, dry soil with easy access, where a simple footing costs less'],
];

$hpSteps = [
    ['Site visit and plan review', 'We look at the soil, the access route and the engineer\'s pier layout, and note anything that changes the equipment or the count.'],
    ['Dig Safe and layout', 'Utility lines are marked through Dig Safe, then each pier location is staked from the plan.'],
    ['Drive to firm soil', 'Each pier is turned down with a hydraulic drive head while the torque is watched, and extensions are added until it reaches the target.'],
    ['Cut, cap and hand off', 'The shafts are cut to the plan elevation and capped, ready for the foundation, beam or framing crew.'],
];

$hpRelated = ['site-construction-excavation', 'sea-walls', 'septic-system-installation'];
$hpCards = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Helical Piers — page composition (tokens only).
   Motif: the thread. Diagonal thread lines in the hero, a vertical depth
   diagram as the signature, and a two-way compare table.
   ========================================================================== */
.hp { --hp-thread: color-mix(in srgb, var(--color-white) 6%, transparent); --hp-steel: color-mix(in srgb, var(--color-secondary) 70%, var(--color-white)); }
.hp h1, .hp h2, .hp h3 { text-wrap: balance; }
.hp p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + threads ---- */
.hp-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 45% 80% at 12% 100%, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 70%),
              linear-gradient(100deg, transparent 55%, color-mix(in srgb, var(--color-secondary) 18%, transparent));
}
.hp-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.hp-hero__threads { position: absolute; top: 0; bottom: 0; right: 4%; width: clamp(80px, 12vw, 180px); z-index: -1; pointer-events: none; background: repeating-linear-gradient(-28deg, transparent 0 14px, var(--hp-thread) 14px 18px); -webkit-mask: linear-gradient(90deg, transparent, var(--color-black) 30%, var(--color-black) 70%, transparent); mask: linear-gradient(90deg, transparent, var(--color-black) 30%, var(--color-black) 70%, transparent); }
.hp-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.hp-hero .breadcrumb a:hover { color: var(--color-white); }
.hp-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.hp-hero .text-accent { color: var(--color-accent-bright); }
.hp-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.hp-hero .link-call svg { color: var(--color-accent-bright); }
.hp-hero .link-call:hover { color: var(--color-white); }
.hp-hero .hero-form-open { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-white); }
.hp-hero .hero-form-open:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.hp-hero .hero-title { max-width: 17ch; }
.hp-hero .hero-chips li { background: var(--hp-thread); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.hp-hero .hero-chips svg { color: var(--color-accent-bright); }
.hp-hero .hero-form-card { box-shadow: var(--shadow-lg), 0 0 0 1px color-mix(in srgb, var(--color-accent) 40%, transparent); }
.hp-hero .hero-form .consent a { color: var(--color-primary); }
.hp-hero .hp-two { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); margin-top: var(--space-xs); }
.hp-hero .hp-two .form-row + .form-row { margin-top: 0; }

/* ---- Why piers: quote banner + offset cards ---- */
.hp-why { background: var(--color-surface); }
.hp-why__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.3fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.hp-why__intro { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.hp-why__intro .answer-block { margin: 0; }
.hp-quote { margin: var(--space-sm) 0 0; padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-card-tint-3); }
.hp-quote p { margin: 0; font-family: var(--font-heading); font-weight: 700; font-size: clamp(1.2rem, 1rem + .9vw, 1.6rem); line-height: 1.25; color: var(--color-ink); }
.hp-quote p + p { margin-top: var(--space-xs); color: var(--color-accent-dark); }
.hp-reasons { display: grid; gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.hp-reasons li { display: grid; grid-template-columns: 3.25rem minmax(0, 1fr); gap: var(--space-xs) var(--space-lg); align-items: start; padding: var(--space-lg) var(--space-xl); border-radius: var(--radius-lg); background: var(--color-paper); border: 1px solid var(--color-line); transition: transform var(--transition), box-shadow var(--transition); }
.hp-reasons li:nth-child(even) { margin-left: clamp(0rem, 4vw, var(--space-3xl)); }
.hp-reasons li:hover { transform: translateX(4px); box-shadow: var(--shadow); }
.hp-reasons__icon { grid-row: span 2; width: 3.25rem; height: 3.25rem; border-radius: var(--radius); display: grid; place-items: center; background: var(--color-dark); color: var(--color-accent-bright); }
.hp-reasons h3 { font-size: var(--font-size-lg); }
.hp-reasons p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Signature: depth diagram (dark band) ---- */
.hp-depth__grid { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.hp-depth .answer-block { background: var(--hp-thread); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.hp-depth__copy { display: grid; gap: var(--space-md); }
.hp-depth__copy p { margin: 0; }
.hp-figure { margin: 0; }
.hp-figure__col { position: relative; }
.hp-column { position: relative; display: grid; grid-template-rows: 3.5rem 9rem 1.5rem 8rem; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); margin: 0; padding: 0; list-style: none; }
.hp-column > li { position: relative; display: grid; align-content: center; padding: 0 var(--space-lg) 0 55%; }
.hp-column b { font-family: var(--font-accent); font-size: var(--font-size-lg); letter-spacing: .06em; text-transform: uppercase; line-height: 1.1; }
.hp-column span { font-size: var(--font-size-xs); line-height: 1.35; }
.hp-l1 { background: color-mix(in srgb, var(--color-accent) 25%, var(--color-ink) 55%); color: var(--color-white); }
.hp-l1 span, .hp-l3 span { color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.hp-l2 { background: color-mix(in srgb, var(--color-paper) 62%, var(--color-accent) 20%); color: var(--color-ink); background-image: radial-gradient(circle, color-mix(in srgb, var(--color-ink) 16%, transparent) 1px, transparent 1.6px); background-size: 8px 8px; }
.hp-l2 span { color: var(--color-ink-2); }
.hp-frost { background: var(--color-surface); color: var(--color-ink); border-block: 2px dashed var(--color-info); }
.hp-frost b { font-size: var(--font-size-xs); letter-spacing: .14em; color: var(--color-info); }
.hp-l3 { background: var(--color-dark-alt); color: var(--color-white); background-image: repeating-linear-gradient(0deg, transparent 0 14px, var(--hp-thread) 14px 15px); }
.hp-shaft { position: absolute; z-index: 2; top: 0; bottom: var(--space-xl); left: 27%; width: 10px; border-radius: 0 0 var(--radius-sm) var(--radius-sm); background: linear-gradient(90deg, var(--hp-steel), var(--color-white) 45%, var(--hp-steel)); box-shadow: var(--shadow); pointer-events: none; }
.hp-shaft::before { content: ""; position: absolute; left: 50%; top: calc(-1 * var(--space-xs)); width: var(--space-2xl); height: var(--space-sm); transform: translateX(-50%); border-radius: var(--radius-sm); background: var(--color-accent); }
.hp-helix { position: absolute; z-index: 3; left: 27%; width: 5.5rem; height: var(--space-md); transform: translateX(calc(-50% + 5px)) rotate(-8deg); border-radius: 50%; border: 3px solid var(--color-white); background: color-mix(in srgb, var(--hp-steel) 70%, transparent); pointer-events: none; }
.hp-helix--1 { bottom: calc(var(--space-xl) + var(--space-2xl)); }
.hp-helix--2 { bottom: calc(var(--space-xl) - var(--space-xs)); width: 6.5rem; }
.hp-depth__caption { margin-top: var(--space-sm); font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 65%, transparent); }

/* ---- Compare table ---- */
.hp-compare { background: var(--color-paper); }
.hp-compare .section-head { max-width: 66ch; }
.hp-compare .answer-block { margin: 0; background: var(--color-surface); }
.hp-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); background: var(--color-surface); box-shadow: var(--shadow); }
.hp-table { width: 100%; min-width: 620px; border-collapse: collapse; font-size: var(--fs-small); table-layout: fixed; }
.hp-table caption { caption-side: bottom; text-align: left; padding: var(--space-sm) var(--space-lg); font-size: var(--font-size-xs); color: var(--color-muted); }
.hp-table th, .hp-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; border-bottom: 1px solid var(--color-line); line-height: 1.5; }
.hp-table thead th { font-family: var(--font-heading); font-weight: 800; font-size: var(--font-size-lg); color: var(--color-ink); border-bottom: 3px solid var(--color-line); }
.hp-table thead th:nth-child(2) { color: var(--color-white); background: var(--color-dark); border-bottom-color: var(--color-accent); }
.hp-table tbody th { width: 24%; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-muted); }
.hp-table td:nth-child(2) { background: var(--color-card-tint-3); color: var(--color-ink); font-weight: 600; }
.hp-table td:nth-child(3) { color: var(--color-ink-2); }
.hp-table tbody tr:last-child > * { border-bottom: 0; }

/* ---- Uses + process ---- */
.hp-uses { background: var(--color-surface); }
.hp-uses__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.hp-uses__intro { display: grid; gap: var(--space-md); }
.hp-uses__intro .answer-block { margin: 0; }
.hp-uses__intro a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }
.hp-tags { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.hp-tags li { display: inline-flex; align-items: center; gap: var(--space-xs); padding: var(--space-xs) var(--space-md); border-radius: var(--radius-full); background: var(--color-card-tint-1); border: 1px solid var(--color-line); font-weight: 600; font-size: var(--fs-small); color: var(--color-ink); }
.hp-tags svg { color: var(--color-accent-dark); }
.hp-steps { counter-reset: hpstep; display: grid; gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.hp-steps li { counter-increment: hpstep; position: relative; padding: var(--space-lg) var(--space-lg) var(--space-lg) calc(var(--space-3xl) + var(--space-sm)); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-paper); }
.hp-steps li::before { content: counter(hpstep); position: absolute; left: var(--space-lg); top: var(--space-lg); width: var(--space-2xl); height: var(--space-2xl); display: grid; place-items: center; font-family: var(--font-accent); font-weight: 700; font-size: var(--font-size-xl); color: var(--color-white); background: var(--color-accent); clip-path: polygon(50% 0, 100% 25%, 100% 75%, 50% 100%, 0 75%, 0 25%); }
.hp-steps h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-1); }
.hp-steps p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }

/* ---- FAQ ---- */
.hp-faq { background: var(--color-paper-2); }
.hp-faq .answer-block { margin-bottom: var(--space-lg); background: var(--color-surface); }
.hp-faq .faq summary { min-height: 44px; }

/* ---- Other services ---- */
.hp-related { background: var(--color-paper); }
.hp-related .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.hp-related .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.hp-related .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius); background: var(--color-dark); color: var(--color-accent-bright); }
.hp-related__more { margin-top: var(--space-xl); }

/* ---- Closing CTA ---- */
.hp-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.hp-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.hp-cta .link-call svg { color: var(--color-accent-bright); }
.hp-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.hp-cta::before { content: ""; position: absolute; top: 0; bottom: 0; left: 6%; width: 120px; z-index: -1; pointer-events: none; background: repeating-linear-gradient(-28deg, transparent 0 14px, var(--hp-thread) 14px 18px); }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .hp-why__grid, .hp-depth__grid, .hp-uses__grid { grid-template-columns: 1fr; }
  .hp-why__intro { position: static; }
  .hp-reasons li:nth-child(even) { margin-left: 0; }
}
@media (max-width: 900px) { .hp-related .services-grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) {
  .hp-column > li { padding-left: 44%; }
  .hp-shaft, .hp-helix { left: 20%; }
  .hp-hero .hp-two { grid-template-columns: 1fr; }
  .hp-reasons li { padding: var(--space-lg); }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="hp">

<!-- ============ HERO (interior, compact form card) ============ -->
<section class="hero hero--interior hp-hero" aria-labelledby="hp-hero-title">
  <span class="hp-hero__threads" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><a href="/services/">Services</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li aria-current="page"><?php echo h($svc['name']); ?></li>
          </ol>
        </nav>
        <span class="eyebrow">Helical Piers · Plymouth, MA</span>
        <h1 class="hero-title" id="hp-hero-title"><span class="text-accent">Helical pier</span> installation in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services, an excavation contractor based in Plymouth, MA, installs helical piers: steel shafts with screw-like plates turned into the ground until they reach soil firm enough to carry the load. They support new foundations, additions, decks and porches with far less digging than poured footings.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($hpTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('layers', 16); ?>Down to firm soil</li>
          <li><?php icon('clock', 16); ?>No concrete cure time</li>
          <li><?php icon('calendar', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a helical pier estimate?</h2>
        <p class="hero-form-tagline">Tell us what the piers will carry. An engineer's layout helps if you have one.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="hp-two">
            <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
            <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          </div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($svc['name']); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Get my free estimate</button>
        </form>
        <p class="form-footnote">Office hours <?php echo h($businessHours); ?>.</p>
      </aside>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<article class="hp-article" aria-labelledby="hp-hero-title">

<!-- ============ WHY PIERS (sticky intro + offset reasons) ============ -->
<section class="section hp-why" aria-labelledby="hp-why-title">
  <div class="container">
    <div class="hp-why__grid">
      <div class="hp-why__intro reveal-left">
        <span class="eyebrow-label">When piers make sense</span>
        <h2 id="hp-why-title">When is a helical pier a better choice than a <span class="text-accent">poured footing</span>?</h2>
        <p class="answer-block">A helical pier is the better choice when the soil at footing depth is loose, wet or old fill. It also suits tight access and jobs that cannot wait for concrete to cure, since a pier can carry load as soon as it is installed and has reached firm soil.</p>
        <blockquote class="hp-quote"><p>A footing trusts the ground it sits on.</p><p>A helical pier goes down and finds better ground.</p></blockquote>
      </div>
      <ul class="hp-reasons" aria-label="Site conditions that favor helical piers">
<?php foreach ($hpReasons as $hpI => $hpReason): ?>
        <li class="reveal-right reveal-delay-<?php echo ($hpI % 3) + 1; ?>"><span class="hp-reasons__icon"><?php icon($hpReason['icon'], 24); ?></span><h3><?php echo h($hpReason['title']); ?></h3><p><?php echo h($hpReason['text']); ?></p></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: depth diagram (dark band) ============ -->
<section class="section texture-grain slant-top hp-depth" aria-labelledby="hp-depth-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="hp-depth__grid">
      <div class="hp-depth__copy reveal-left">
        <span class="eyebrow-label">How it goes in</span>
        <h2 id="hp-depth-title">How is a helical pier installed and checked in Plymouth soil?</h2>
        <p class="answer-block">A helical pier is screwed into the ground by a hydraulic drive head on an excavator or skid steer, with the turning torque tracked the whole way down. Torque rises as the plates reach firmer soil, and that reading is how the installer confirms the pier can carry its design load.</p>
        <p>The Massachusetts residential code lists a 48-inch frost line, and footings have to bottom out below it. A helical pier is not limited to that depth: extensions are added until the torque says the plates are in firm soil, which on a Plymouth lot with loose sand or old fill near the surface can be well below where a footing would stop.</p>
        <p>Helical piles are an engineered foundation. The layout, pier size and target torque typically come from a structural engineer's plan and go through the Plymouth building permit, and BDPM Site Services installs to that plan.</p>
      </div>
      <figure class="hp-figure reveal-right">
        <div class="hp-figure__col">
        <ol class="hp-column" aria-label="Cross-section: a helical pier passing through soil layers">
          <li class="<?php echo h($hpLayers[0]['class']); ?>"><b><?php echo h($hpLayers[0]['name']); ?></b><span><?php echo h($hpLayers[0]['note']); ?></span></li>
          <li class="<?php echo h($hpLayers[1]['class']); ?>"><b><?php echo h($hpLayers[1]['name']); ?></b><span><?php echo h($hpLayers[1]['note']); ?></span></li>
          <li class="hp-frost"><b>Frost line · 48 in</b></li>
          <li class="<?php echo h($hpLayers[2]['class']); ?>"><b><?php echo h($hpLayers[2]['name']); ?></b><span><?php echo h($hpLayers[2]['note']); ?></span></li>
        </ol>
        <span class="hp-shaft" aria-hidden="true"></span>
        <span class="hp-helix hp-helix--1" aria-hidden="true"></span>
        <span class="hp-helix hp-helix--2" aria-hidden="true"></span>
        </div>
        <figcaption class="hp-depth__caption">Diagram, not to scale. Actual depth is set by the torque reading on each pier.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============ COMPARE (table) ============ -->
<section class="section edge-curve-top hp-compare" aria-labelledby="hp-compare-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Piers vs footings</span>
      <h2 id="hp-compare-title">How do helical piers compare with poured concrete footings?</h2>
      <p class="answer-block">Helical piers and poured concrete footings both carry a structure, but they get there differently. Piers need little excavation and no cure time, and each one is checked by torque; footings need a dug hole, forms and curing, and depend on firm soil at the bottom of that hole.</p>
    </div>
    <div class="hp-table-wrap reveal-up">
      <table class="hp-table">
        <caption>General comparison; the engineer's design decides the foundation for a specific structure.</caption>
        <thead>
          <tr><th scope="col">Factor</th><th scope="col">Helical pier</th><th scope="col">Poured footing</th></tr>
        </thead>
        <tbody>
<?php foreach ($hpCompare as $hpRow): ?>
          <tr><th scope="row"><?php echo h($hpRow[0]); ?></th><td><?php echo h($hpRow[1]); ?></td><td><?php echo h($hpRow[2]); ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============ USES + PROCESS ============ -->
<section class="section hp-uses" aria-labelledby="hp-uses-title">
  <div class="container">
    <div class="hp-uses__grid">
      <div class="hp-uses__intro reveal-left">
        <span class="eyebrow-label">What they carry</span>
        <h2 id="hp-uses-title">What does BDPM Site Services set helical piers under?</h2>
        <p class="answer-block">BDPM Site Services sets helical piers under new foundations, additions, decks and porches in Plymouth. Each pier is installed to the engineer's layout and turned down to firm soil, then the tops are cut to elevation and capped so the foundation or framing can be built on them.</p>
        <ul class="hp-tags" aria-label="Structures supported">
          <li><?php icon('building-2', 16); ?>New foundations</li>
          <li><?php icon('home', 16); ?>Additions</li>
          <li><?php icon('fence', 16); ?>Decks</li>
          <li><?php icon('house', 16); ?>Porches</li>
        </ul>
        <p>Piers often share a job with other ground work. When the rest of the lot needs digging, grading or drainage, that is <a href="/services/site-construction-excavation/">site excavation in Plymouth</a>, and on the water a house can need both piers and <a href="/services/sea-walls/">sea wall construction</a> along the bank in front of it.</p>
      </div>
      <ol class="hp-steps">
<?php foreach ($hpSteps as $hpStepI => $hpStep): ?>
        <li class="reveal-up reveal-delay-<?php echo ($hpStepI % 3) + 1; ?>"><h3><?php echo h($hpStep[0]); ?></h3><p><?php echo h($hpStep[1]); ?></p></li>
<?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$hpReviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($hpReviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $hpReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section hp-faq" aria-labelledby="hp-faq-title">
  <div class="container-narrow">
    <span class="eyebrow-label">Questions</span>
    <h2 id="hp-faq-title">What do Plymouth homeowners ask about soil before a pier job?</h2>
    <p class="answer-block">Plymouth homeowners planning a pier job most often ask BDPM Site Services what kinds of soil and site conditions it works in. The short version: all of them, from sand to ledge, and the site visit decides whether piers or a footing suit the soil on your lot.</p>
<?php foreach ($hpFaqs as $hpFaq): ?>
    <details class="faq reveal-up" open>
      <summary><?php echo h($hpFaq['q']); ?></summary>
      <p class="faq-answer"><?php echo h($hpFaq['a']); ?></p>
    </details>
<?php endforeach; ?>
  </div>
</section>

<!-- ============ OTHER SERVICES (required services component, 3 cards) ============ -->
<section class="section edge-parallelogram-top hp-related" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What other ground work can <span class="text-accent">BDPM Site Services</span> handle around a pier job?</h2>
      <p class="hero-answer">A pier job in Plymouth rarely stands alone. BDPM Site Services also digs and grades building sites, builds sea walls on waterfront lots and installs septic systems, so the foundation support and the rest of the work below grade can be planned together on one schedule.</p>
    </div>
    <div class="services-grid">
<?php foreach ($hpRelated as $hpRelI => $hpRelSlug):
    $hpRelSvc = serviceBySlug($hpRelSlug);
    $hpRelCard = $hpCards[$hpRelSlug]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($hpRelI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($hpRelI % 3) + 1; ?>">
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($hpRelCard['icon'], 26); ?></div>
          <h3><?php echo h($hpRelSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($hpRelCard['desc']); ?></p>
          <ul>
<?php foreach ($hpRelCard['bullets'] as $hpBullet): ?>
            <li><?php echo h($hpBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($hpRelSlug); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($hpRelSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <p class="hp-related__more reveal-up"><a class="btn btn-secondary" href="/services/">See all five Plymouth services</a></p>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-torn-top hp-cta" aria-labelledby="hp-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="hp-cta-title">Ready for a free helical pier estimate in Plymouth?</h2>
      <p>Send the address, what the piers will carry and the engineer's layout if you have one. BDPM Site Services will look at the soil and access and send a written estimate.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free pier estimate</button>
      <a class="link-call" href="<?php echo h($hpTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
