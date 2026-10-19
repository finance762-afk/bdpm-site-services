<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/title-5-inspections/ — Phase 4 service page (premium editorial structure, warm-human archetype).
 * No client photos exist yet, so the page is typographic; its signature section is a sale-timeline ruler.
 * No FAQ section: intake / research_brief holds no customer question specific to Title 5 inspections (zero is fine),
 * so this page carries no FAQPage schema.
 * Sources (checked 2026-10-19):
 *   2-year window, 3 years with annual pumping records, family-transfer exemptions —
 *     https://www.mass.gov/guides/buying-or-selling-property-with-a-septic-system
 *   Up to 6 months after transfer when weather prevents inspection — https://www.mass.gov/info-details/re22rc25-title-5
 *   Four results, conditional pass = minor defect, report to Board of Health within 30 days, failed system upgrade within
 *   2 years unless the Board sets another schedule — https://www.mass.gov/doc/title-5-official-inspection-form-0/download,
 *   https://www.hampdenma.gov/node/974
 *   110 gpd per bedroom — 310 CMR 15.203
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$svc             = serviceBySlug('title-5-inspections');
$pageTitle       = 'Title 5 Inspections Plymouth MA | BDPM Site Services';
$pageDescription = 'Title 5 septic inspections in Plymouth, MA for home sales: the two-year window, the four possible results and what follows a fail. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/services/title-5-inspections/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'title-5-inspections';
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/title-5-inspections/'],
];

$t5Tel = formatPhone($phone, 'tel');

$schemaMarkup = servicePageSchema($svc,
    'Massachusetts Title 5 septic system inspections in Plymouth, MA for property sales and system checks, recorded on the official state inspection form and filed with the Board of Health.');

$t5Rules = [
    ['icon' => 'calendar-check', 'big' => '2 yrs', 'text' => 'The inspection must be done within two years before the sale, and one inspection covers every transfer inside that window.'],
    ['icon' => 'droplets', 'big' => '3 yrs', 'text' => 'The window stretches to three years when the tank has been pumped every year and the records go with the report.'],
    ['icon' => 'cloud-snow', 'big' => '+6 mo', 'text' => 'When weather prevents the inspection, it can be completed up to six months after the transfer.'],
    ['icon' => 'users', 'big' => 'Family', 'text' => 'Transfers between spouses, parents and children or full siblings, and into certain trusts, generally do not need one.'],
];

$t5Ruler = [
    ['mark' => '−3 yrs', 'label' => 'Earliest, with annual pumping records', 'state' => 'soft'],
    ['mark' => '−2 yrs', 'label' => 'Standard window opens', 'state' => 'open'],
    ['mark' => 'Listing', 'label' => 'Report ready for buyers', 'state' => 'best'],
    ['mark' => 'Closing', 'label' => 'Transfer of title', 'state' => 'close'],
    ['mark' => '+6 mo', 'label' => 'Latest, only if weather blocks it', 'state' => 'late'],
];

$t5Results = [
    ['ok', 'Passes', 'The system meets Title 5 standards on the day of the inspection.', 'The report goes to the Board of Health and the seller has it for the sale.'],
    ['cond', 'Conditionally passes', 'A minor defect: a component such as the tank, the distribution box or a pipe needs repair or replacement.', 'Once the repair is made with Board of Health approval, the system is treated as passing.'],
    ['eval', 'Needs further evaluation', 'The inspector found conditions the Board of Health has to look into before deciding whether the system is failing.', 'The Board of Health investigates and makes the call.'],
    ['fail', 'Fails', 'The system does not meet Title 5 criteria for protecting public health and the environment.', 'An upgrade is generally due within two years, sale or no sale, unless the Board of Health sets a different schedule.'],
];

$t5Checks = [
    'Board of Health file and past pumping records reviewed',
    'Tank located, uncovered and opened',
    'Tank condition, baffles and sludge and scum levels',
    'Distribution box checked for level and damage',
    'Leach field checked for backup, breakout or saturated ground',
    'Depth to groundwater and distance to wells and water compared with Title 5 criteria',
    'State inspection form completed and filed with the Board of Health within 30 days',
];

$t5Steps = [
    ['Book it', 'Send the address, the bedroom count and the sale timeline. The closing date sets how soon the report is needed.'],
    ['Records first', 'The Board of Health file shows where the system is, when it was built and what it was designed for.'],
    ['On-site inspection', 'The system is located, opened and checked from the tank through the leach field.'],
    ['Report and filing', 'The result goes on the official state form, to you and to the Board of Health within 30 days.'],
];

$t5Related = ['septic-system-installation', 'site-construction-excavation', 'helical-piers'];
$t5Cards = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Title 5 Inspections — page composition (tokens only).
   Motif: the inspection form. Ruled lines in the hero, a sale-timeline
   ruler as the signature, a colour-coded results table, a checklist sheet.
   ========================================================================== */
.t5 { --t5-rule: color-mix(in srgb, var(--color-white) 7%, transparent); --t5-ink-rule: color-mix(in srgb, var(--color-ink) 8%, transparent); }
.t5 h1, .t5 h2, .t5 h3 { text-wrap: balance; }
.t5 p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + ruled form lines ---- */
.t5-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 50% 70% at 0% 0%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              radial-gradient(ellipse 40% 60% at 100% 100%, color-mix(in srgb, var(--color-secondary) 30%, transparent), transparent 70%);
}
.t5-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.t5-hero__lines { position: absolute; inset: 0; z-index: -1; pointer-events: none; background: repeating-linear-gradient(180deg, transparent 0 31px, var(--t5-rule) 31px 32px); -webkit-mask: linear-gradient(90deg, transparent 30%, var(--color-black) 75%); mask: linear-gradient(90deg, transparent 30%, var(--color-black) 75%); }
.t5-hero__lines::before { content: ""; position: absolute; top: 0; bottom: 0; left: 62%; width: 2px; background: color-mix(in srgb, var(--color-accent) 35%, transparent); }
.t5-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.t5-hero .breadcrumb a:hover { color: var(--color-white); }
.t5-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.t5-hero .text-accent { color: var(--color-accent-bright); }
.t5-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.t5-hero .link-call svg { color: var(--color-accent-bright); }
.t5-hero .link-call:hover { color: var(--color-white); }
.t5-hero .hero-form-open { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-white); }
.t5-hero .hero-form-open:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.t5-hero .hero-title { max-width: 18ch; }
.t5-hero .hero-chips li { background: var(--t5-rule); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.t5-hero .hero-chips svg { color: var(--color-accent-bright); }
.t5-hero .hero-form-card { border-top: 4px double var(--color-accent); }
.t5-hero .hero-form .consent a { color: var(--color-primary); }
.t5-hero .t5-pair { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); margin-top: var(--space-xs); }
.t5-hero .t5-pair .form-row + .form-row { margin-top: 0; }

/* ---- When required: intro + 4 rule tiles ---- */
.t5-when { background: var(--color-paper); }
.t5-when__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.t5-when__intro { display: grid; gap: var(--space-md); }
.t5-when__intro .answer-block { margin: 0; background: var(--color-surface); }
.t5-pull { margin: var(--space-sm) 0 0; padding: var(--space-lg) 0 0; font-family: var(--font-heading); font-weight: 800; font-size: clamp(1.4rem, 1rem + 1.5vw, 2rem); line-height: 1.15; color: var(--color-ink); border-top: 1px solid var(--color-line); }
.t5-pull em { font-style: normal; color: var(--color-accent-dark); }
.t5-tiles { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.t5-tiles li { position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); background-image: repeating-linear-gradient(180deg, transparent 0 27px, var(--t5-ink-rule) 27px 28px); transition: transform var(--transition), box-shadow var(--transition); }
.t5-tiles li:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.t5-tiles li:first-child { background-color: var(--color-card-tint-3); border-color: color-mix(in srgb, var(--color-accent) 30%, var(--color-line)); }
.t5-tiles b { font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-h2); line-height: 1; color: var(--color-ink); }
.t5-tiles svg { position: absolute; top: var(--space-lg); right: var(--space-lg); color: var(--color-accent-dark); }
.t5-tiles p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Signature: sale-timeline ruler (dark band) ---- */
.t5-time .section-head { max-width: 66ch; }
.t5-time .answer-block { background: var(--t5-rule); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.t5-ruler { position: relative; display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); margin: var(--space-3xl) 0 0; padding: 0; list-style: none; }
.t5-ruler::before { content: ""; position: absolute; left: 0; right: 0; top: 1.4rem; height: 6px; border-radius: var(--radius-full); background: linear-gradient(90deg, color-mix(in srgb, var(--color-white) 18%, transparent) 0%, var(--color-accent-bright) 22%, var(--color-accent) 62%, color-mix(in srgb, var(--color-white) 18%, transparent) 100%); }
.t5-ruler::after { content: ""; position: absolute; left: 0; right: 0; top: 2.4rem; height: var(--space-sm); background: repeating-linear-gradient(90deg, color-mix(in srgb, var(--color-white) 30%, transparent) 0 1px, transparent 1px 24px); }
.t5-ruler li { position: relative; display: grid; gap: var(--space-xs); justify-items: center; text-align: center; padding: 0 var(--space-xs); }
.t5-ruler i { position: relative; z-index: 1; width: 2.9rem; height: 2.9rem; border-radius: var(--radius-full); background: var(--color-dark); border: 3px solid color-mix(in srgb, var(--color-white) 40%, transparent); }
.t5-ruler .is-open i, .t5-ruler .is-close i { border-color: var(--color-accent-bright); }
.t5-ruler .is-best i { background: var(--color-accent); border-color: var(--color-white); box-shadow: 0 0 0 8px color-mix(in srgb, var(--color-accent) 30%, transparent); }
.t5-ruler .is-soft i, .t5-ruler .is-late i { border-style: dashed; }
.t5-ruler b { margin-top: var(--space-sm); font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .06em; text-transform: uppercase; color: var(--color-white); }
.t5-ruler span { font-size: var(--font-size-xs); line-height: 1.35; color: color-mix(in srgb, var(--color-white) 76%, transparent); max-width: 16ch; }
.t5-time__note { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-xl); margin-top: var(--space-2xl); }
.t5-time__note p { margin: 0; }

/* ---- Results table ---- */
.t5-results { background: var(--color-surface); }
.t5-results .section-head { max-width: 68ch; }
.t5-results .answer-block { margin: 0; }
.t5-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow); }
.t5-table { width: 100%; min-width: 680px; border-collapse: collapse; font-size: var(--fs-small); background: var(--color-surface); }
.t5-table caption { caption-side: bottom; text-align: left; padding: var(--space-sm) var(--space-lg); font-size: var(--font-size-xs); color: var(--color-muted); background: var(--color-paper); }
.t5-table th, .t5-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; line-height: 1.55; }
.t5-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); border-bottom: 2px solid var(--color-ink); background: var(--color-paper); }
.t5-table tbody tr { border-bottom: 1px solid var(--color-line); }
.t5-table tbody tr:last-child { border-bottom: 0; }
.t5-table tbody th { width: 22%; }
.t5-table td { color: var(--color-ink-2); }
.t5-chip { display: inline-flex; align-items: center; gap: var(--space-xs); padding: var(--space-1) var(--space-sm); border-radius: var(--radius-full); font-family: var(--font-heading); font-weight: 800; font-size: var(--fs-small); color: var(--color-ink); white-space: nowrap; }
.t5-chip::before { content: ""; width: .65rem; height: .65rem; border-radius: var(--radius-full); }
.t5-chip--ok { background: color-mix(in srgb, var(--color-success) 14%, var(--color-surface)); } .t5-chip--ok::before { background: var(--color-success); }
.t5-chip--cond { background: color-mix(in srgb, var(--color-warning) 16%, var(--color-surface)); } .t5-chip--cond::before { background: var(--color-warning); }
.t5-chip--eval { background: color-mix(in srgb, var(--color-info) 14%, var(--color-surface)); } .t5-chip--eval::before { background: var(--color-info); }
.t5-chip--fail { background: color-mix(in srgb, var(--color-danger) 14%, var(--color-surface)); } .t5-chip--fail::before { background: var(--color-danger); }
.t5-results__after { margin: var(--space-xl) 0 0; max-width: 72ch; color: var(--color-ink-2); }
.t5-results__after a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }

/* ---- Checklist sheet + process ---- */
.t5-check { background: var(--color-paper-2); }
.t5-check__grid { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.t5-check__intro { display: grid; gap: var(--space-md); }
.t5-check__intro .answer-block { margin: 0; background: var(--color-surface); }
.t5-sheet { position: relative; margin: 0; padding: var(--space-xl) var(--space-xl) var(--space-xl) calc(var(--space-3xl) + var(--space-xs)); list-style: none; background: var(--color-surface); border-radius: var(--radius); box-shadow: var(--shadow-lg); background-image: repeating-linear-gradient(180deg, transparent 0 39px, var(--t5-ink-rule) 39px 40px); transform: rotate(-.6deg); }
.t5-sheet::before { content: ""; position: absolute; top: 0; bottom: 0; left: var(--space-2xl); width: 2px; background: color-mix(in srgb, var(--color-danger) 45%, transparent); }
.t5-sheet li { position: relative; min-height: 40px; display: flex; align-items: center; font-size: var(--fs-small); color: var(--color-ink); }
.t5-sheet li::before { content: ""; position: absolute; left: calc(-1 * var(--space-2xl) + var(--space-1)); width: 1.05rem; height: 1.05rem; border: 2px solid var(--color-ink-2); border-radius: var(--radius-sm); background: var(--color-surface); }
.t5-sheet li::after { content: ""; position: absolute; left: calc(-1 * var(--space-2xl) + .45rem); width: .4rem; height: .7rem; border: solid var(--color-accent-dark); border-width: 0 3px 3px 0; transform: translateY(-.15rem) rotate(45deg); }
.t5-flow { counter-reset: t5step; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); margin: var(--space-lg) 0 0; padding: 0; list-style: none; }
.t5-flow li { counter-increment: t5step; display: grid; gap: var(--space-1); padding: var(--space-md) var(--space-lg); border-radius: var(--radius); background: var(--color-surface); border-left: 4px solid var(--color-accent); }
.t5-flow li::before { content: "Step " counter(t5step); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.t5-flow h3 { font-size: var(--font-size-base); }
.t5-flow p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
.t5-tip { margin: 0; padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-dark); color: color-mix(in srgb, var(--color-white) 86%, transparent); font-size: var(--fs-small); }
.t5-tip strong { color: var(--color-accent-bright); }

/* ---- Other services ---- */
.t5-related { background: var(--color-surface); }
.t5-related .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.t5-related .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.t5-related .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--color-card-tint-3); color: var(--color-accent-dark); border: 1px solid var(--color-line); }
.t5-related__more { margin-top: var(--space-xl); }

/* ---- Closing CTA ---- */
.t5-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.t5-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.t5-cta .link-call svg { color: var(--color-accent-bright); }
.t5-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.t5-cta .floating-ring { right: -5rem; bottom: -9rem; opacity: .1; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .t5-when__grid, .t5-check__grid, .t5-time__note { grid-template-columns: 1fr; }
}
@media (max-width: 900px) { .t5-related .services-grid { grid-template-columns: 1fr; } }
@media (max-width: 760px) {
  .t5-ruler { grid-template-columns: 1fr; gap: var(--space-md); padding-left: var(--space-xl); }
  .t5-ruler::before { left: .9rem; right: auto; top: 0; bottom: 0; width: 6px; height: auto; background: linear-gradient(180deg, color-mix(in srgb, var(--color-white) 18%, transparent), var(--color-accent-bright) 25%, var(--color-accent) 65%, color-mix(in srgb, var(--color-white) 18%, transparent)); }
  .t5-ruler::after { display: none; }
  .t5-ruler li { grid-template-columns: 2.9rem minmax(0, 1fr); justify-items: start; text-align: left; gap: 0 var(--space-md); margin-left: calc(-1 * var(--space-xl)); }
  .t5-ruler i { grid-row: span 2; }
  .t5-ruler b { margin-top: 0; }
  .t5-ruler span { max-width: none; }
}
@media (max-width: 600px) {
  .t5-tiles, .t5-flow { grid-template-columns: 1fr; }
  .t5-sheet { transform: none; padding-right: var(--space-lg); }
  .t5-hero .t5-pair { grid-template-columns: 1fr; }
  .t5-hero__lines::before { display: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="t5">

<!-- ============ HERO (interior, compact form card) ============ -->
<section class="hero hero--interior t5-hero" aria-labelledby="t5-hero-title">
  <span class="t5-hero__lines" aria-hidden="true"></span>
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
        <span class="eyebrow">Title 5 · Plymouth, MA</span>
        <h1 class="hero-title" id="t5-hero-title"><span class="text-accent">Title 5 septic inspections</span> in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services, an excavation contractor based in Plymouth, performs Massachusetts Title 5 septic inspections for home sales and system checks. The inspection locates and examines each part of the system and records the result on the state form, which goes to the Board of Health.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Request an inspection</button>
          <a class="link-call" href="<?php echo h($t5Tel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('clipboard-list', 16); ?>Official state form</li>
          <li><?php icon('droplets', 16); ?>Same team installs systems</li>
          <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a Title 5 inspection?</h2>
        <p class="hero-form-tagline">Selling? Have your target closing date handy when we call back.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="t5-pair">
            <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
            <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          </div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($svc['name']); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Request my inspection</button>
        </form>
        <p class="form-footnote">Office hours <?php echo h($businessHours); ?>.</p>
      </aside>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<article class="t5-article" aria-labelledby="t5-hero-title">

<!-- ============ WHEN REQUIRED ============ -->
<section class="section t5-when" aria-labelledby="t5-when-title">
  <div class="container">
    <div class="t5-when__grid">
      <div class="t5-when__intro reveal-left">
        <span class="eyebrow-label">When it's required</span>
        <h2 id="t5-when-title">When is a <span class="text-accent">Title 5 inspection</span> required in Massachusetts?</h2>
        <p class="answer-block">A Title 5 inspection is required before most Massachusetts property transfers that involve a septic system. It has to be done within two years before the sale, or within three years if the tank has been pumped every year and the pumping records are kept.</p>
        <p class="t5-pull">Book it before you list, <em>not after the offer.</em></p>
      </div>
      <ul class="t5-tiles" aria-label="Title 5 inspection timing rules">
<?php foreach ($t5Rules as $t5I => $t5Rule): ?>
        <li class="reveal-up reveal-delay-<?php echo ($t5I % 3) + 1; ?>"><?php icon($t5Rule['icon'], 22); ?><b><?php echo h($t5Rule['big']); ?></b><p><?php echo h($t5Rule['text']); ?></p></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: sale timeline (dark band) ============ -->
<section class="section texture-grain edge-torn-top t5-time" aria-labelledby="t5-time-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Timing a sale</span>
      <h2 id="t5-time-title">How far ahead of a Plymouth home sale should the Title 5 inspection be done?</h2>
      <p class="answer-block">Book the Title 5 inspection before the house is listed, inside the two-year window before the closing date. With the report in hand, buyers see the result up front, and a conditional or failed result can be dealt with on your schedule instead of the closing's.</p>
    </div>
    <ol class="t5-ruler reveal-up" aria-label="Title 5 inspection timing around a sale">
<?php foreach ($t5Ruler as $t5Mark): ?>
      <li class="is-<?php echo h($t5Mark['state']); ?>"><i aria-hidden="true"></i><b><?php echo h($t5Mark['mark']); ?></b><span><?php echo h($t5Mark['label']); ?></span></li>
<?php endforeach; ?>
    </ol>
    <div class="t5-time__note">
      <p class="reveal-up">The six-month extension is for weather, not convenience. Frozen or snow-covered ground can make it impossible to uncover and inspect a system in a Plymouth winter, and lenders may hold back funds at closing until the inspection is done.</p>
      <p class="reveal-up reveal-delay-2">Local boards of health can set stricter rules than the state's. Confirm the Plymouth requirements for your property with the health department before you set a closing date.</p>
    </div>
  </div>
</section>

<!-- ============ RESULTS (table) ============ -->
<section class="section t5-results" aria-labelledby="t5-results-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Results</span>
      <h2 id="t5-results-title">What do the four Title 5 inspection results mean?</h2>
      <p class="answer-block">A Title 5 inspection ends in one of four results: passes, conditionally passes, needs further evaluation by the Board of Health, or fails. The inspector files the report with the Board of Health within 30 days, and a failed system generally has to be upgraded within two years.</p>
    </div>
    <div class="t5-table-wrap reveal-up">
      <table class="t5-table">
        <caption>Results as listed on the official Massachusetts Title 5 inspection form.</caption>
        <thead>
          <tr><th scope="col">Result</th><th scope="col">What it means</th><th scope="col">What happens next</th></tr>
        </thead>
        <tbody>
<?php foreach ($t5Results as $t5Row): ?>
          <tr><th scope="row"><span class="t5-chip t5-chip--<?php echo h($t5Row[0]); ?>"><?php echo h($t5Row[1]); ?></span></th><td><?php echo h($t5Row[2]); ?></td><td><?php echo h($t5Row[3]); ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="t5-results__after reveal-up">A failed result is where the inspection and the installation meet. BDPM Site Services also handles <a href="/services/septic-system-installation/">septic system installation in Plymouth</a>, building the new or rebuilt system to the engineer's approved design, and the <a href="/services/site-construction-excavation/">site excavation and grading</a> around it.</p>
  </div>
</section>

<!-- ============ WHAT'S CHECKED + PROCESS ============ -->
<section class="section slant-top t5-check" aria-labelledby="t5-check-title">
  <div class="container">
    <div class="t5-check__grid">
      <div class="t5-check__intro reveal-left">
        <span class="eyebrow-label">On inspection day</span>
        <h2 id="t5-check-title">What does BDPM Site Services check during a Title 5 inspection?</h2>
        <p class="answer-block">During a Title 5 inspection, BDPM Site Services locates and opens the system and checks the tank, the distribution box and the soil absorption system. The system's records and its position relative to groundwater, wells and surface water are reviewed too, then the state form is completed and filed.</p>
        <ol class="t5-flow">
<?php foreach ($t5Steps as $t5Step): ?>
          <li><h3><?php echo h($t5Step[0]); ?></h3><p><?php echo h($t5Step[1]); ?></p></li>
<?php endforeach; ?>
        </ol>
        <p class="t5-tip"><strong>Selling a house with more bedrooms than the system was designed for?</strong> Title 5 sizes a house system at 110 gallons per day per bedroom, so a listing that counts more bedrooms than the septic design is a common snag at sale. The Board of Health file shows the design flow; check it before the listing goes live.</p>
      </div>
      <ul class="t5-sheet reveal-right" aria-label="Title 5 inspection checklist">
<?php foreach ($t5Checks as $t5Check): ?>
        <li><?php echo h($t5Check); ?></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$t5Reviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($t5Reviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $t5Reviews; ?></div></section>
<?php endif; ?>

<!-- ============ OTHER SERVICES (required services component, 3 cards) ============ -->
<section class="section edge-curve-top t5-related" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What happens if the <span class="text-accent">Title 5 inspection</span> turns up a problem?</h2>
      <p class="hero-answer">If a Title 5 inspection turns up a problem, the fix is usually ground work. BDPM Site Services installs new and replacement septic systems in Plymouth, digs and grades the site around them, and sets helical piers where an addition needs support, so the repair can follow the inspection without a new contractor.</p>
    </div>
    <div class="services-grid">
<?php foreach ($t5Related as $t5RelI => $t5RelSlug):
    $t5RelSvc = serviceBySlug($t5RelSlug);
    $t5RelCard = $t5Cards[$t5RelSlug]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($t5RelI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($t5RelI % 3) + 1; ?>">
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($t5RelCard['icon'], 26); ?></div>
          <h3><?php echo h($t5RelSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($t5RelCard['desc']); ?></p>
          <ul>
<?php foreach ($t5RelCard['bullets'] as $t5Bullet): ?>
            <li><?php echo h($t5Bullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($t5RelSlug); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($t5RelSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <p class="t5-related__more reveal-up"><a class="btn btn-secondary" href="/services/">See all five Plymouth services</a></p>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-wave-top t5-cta" aria-labelledby="t5-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Before you list</span>
      <h2 id="t5-cta-title">Ready to book a Title 5 inspection in Plymouth?</h2>
      <p>Send the address, the bedroom count and your target closing date. BDPM Site Services will call during office hours to set the inspection date.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request a Title 5 inspection</button>
      <a class="link-call" href="<?php echo h($t5Tel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
