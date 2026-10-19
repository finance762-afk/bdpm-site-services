<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/sea-walls/ — Phase 4 service page (premium editorial structure, warm-human archetype).
 * No client photos exist yet, so the page is typographic; its signature section is the 1978 coastal-bank rule.
 * Sources (checked 2026-10-19):
 *   New coastal engineering structures on or within 100 ft of a coastal bank only to protect buildings constructed before
 *   Aug 10, 1978 (or under an NOI filed before then); minimize effects on adjacent beaches; no feasible alternative —
 *   310 CMR 10.30(3), e.g. https://www.mass.gov/doc/recommended-appeals-decision-scott-glass-trustee-of-hill-and-dale-nominee-trust-docket-no-wet/download
 *   and https://beachapedia.org/State_of_the_Beach/State_Reports/MA/Shoreline_Structures
 *   Chapter 91 waterways licensing for work in tidelands — MassDEP Waterways Regulation Program (310 CMR 9.00)
 *   Wetlands review by the Plymouth Conservation Commission — build-plan research_brief.faqs
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$svc             = serviceBySlug('sea-walls');
$pageTitle       = 'Sea Walls Plymouth MA | BDPM Site Services';
$pageDescription = 'Sea wall construction for Plymouth, MA waterfront property, planned around the coastal bank, the tides and Conservation Commission permits. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/services/sea-walls/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'sea-walls';
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/sea-walls/'],
];

$swTel = formatPhone($phone, 'tel');

// FAQ — the wetlands question from research_brief.faqs (the one a waterfront owner asks first)
$swFaqs = [
    ['q' => 'Will my sea wall project need a wetlands or conservation permit in Plymouth?',
     'a' => 'Almost certainly. Work within coastal and wetland resource areas or their buffer zones is regulated under the Massachusetts Wetlands Protection Act and local bylaws, which usually means review by the Plymouth Conservation Commission. Tell BDPM Site Services about the property during the estimate and we will explain what review is likely before any work is scheduled.'],
];

$schemaMarkup = array_merge(servicePageSchema($svc,
    'Sea wall construction for waterfront property in Plymouth, MA, planned around the coastal bank, tide windows, the Massachusetts Wetlands Protection Act and Plymouth Conservation Commission review.'),
    [generateFAQSchema($swFaqs)]);

$swSigns = [
    ['icon' => 'waves', 'title' => 'Scour at the toe', 'text' => 'Waves pull sand away from the base. Once the toe is exposed, a wall can rotate or slide forward.'],
    ['icon' => 'layers', 'title' => 'A leaning or bulging face', 'text' => 'Movement in the face usually means pressure behind it: water that cannot drain, or backfill that has shifted.'],
    ['icon' => 'search', 'title' => 'Holes behind the wall', 'text' => 'Dips in the lawn behind a wall mean fill is washing out through the joints or under the base.'],
    ['icon' => 'wind', 'title' => 'Bank loss after storms', 'text' => 'On an unprotected coastal bank, each nor\'easter can take another slice of the slope closer to the house.'],
];

$swTests = [
    ['Building date', 'The building being protected was constructed before August 10, 1978, or under a Notice of Intent filed before that date.'],
    ['No other option', 'The owner shows that no method other than the proposed structure can feasibly protect that building.'],
    ['Beach effects', 'The design uses the best available measures to limit wave effects on the beaches next to it.'],
];

$swOptions = [
    ['Vertical sea wall', 'Concrete or mortared stone standing upright at the top of the beach.', 'Tight lots with no room for a slope.', 'New walls fall under the 1978 building rule.'],
    ['Stone revetment', 'Large armor stone laid on a sloped bank over filter fabric.', 'Exposed banks with room for a wider footprint.', 'Treated as a coastal engineering structure, like a wall.'],
    ['Sheet-pile bulkhead', 'Interlocking steel or vinyl sheets driven into the ground and tied back.', 'Harbor and marsh edges with calmer water.', 'Work in tidelands may also need a Chapter 91 license.'],
    ['Bank stabilization', 'Coir fiber envelopes, plantings and added sand on the slope.', 'Lower-energy banks where a hard structure is not allowed.', 'Often the easier permit, but it needs upkeep after storms.'],
];

$swSteps = [
    ['Shoreline visit', 'We look at the building, the bank, any existing wall and its toe, the route a machine can take to the beach and the tide window for working at the base.'],
    ['Plans and permits', 'The wall is built from an engineered plan and the conditions the Conservation Commission sets. The schedule is built around that review.'],
    ['Tide-timed construction', 'Footing and toe work happens on the low tide; the rest of the wall goes up behind it, with the permit\'s erosion controls in place.'],
    ['Backfill and drainage', 'Behind the wall, backfill and drainage let water out instead of building pressure, then the bank and lawn are graded back.'],
];

$swRelated = ['helical-piers', 'site-construction-excavation', 'septic-system-installation'];
$swCards = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Sea Walls — page composition (tokens only).
   Motif: tide lines. Concentric wave rules in the hero, a 1978 "gate" as the
   signature, an options table with a sand header, a tide-scale process strip.
   ========================================================================== */
.sw { --sw-tide: color-mix(in srgb, var(--color-white) 9%, transparent); --sw-sand: color-mix(in srgb, var(--color-paper) 70%, var(--color-accent) 12%); }
.sw h1, .sw h2, .sw h3 { text-wrap: balance; }
.sw p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + tide lines ---- */
.sw-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: linear-gradient(180deg, transparent 0%, transparent 55%, color-mix(in srgb, var(--color-secondary) 28%, transparent) 100%),
              radial-gradient(ellipse 60% 70% at 85% 10%, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%);
}
.sw-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .28; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.sw-hero__tide { position: absolute; inset: auto 0 0 0; height: 45%; z-index: -1; pointer-events: none; background: repeating-radial-gradient(ellipse 140% 60% at 50% 160%, transparent 0 18px, var(--sw-tide) 18px 19px); -webkit-mask: linear-gradient(180deg, transparent, var(--color-black) 60%); mask: linear-gradient(180deg, transparent, var(--color-black) 60%); }
.sw-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.sw-hero .breadcrumb a:hover { color: var(--color-white); }
.sw-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.sw-hero .text-accent { color: var(--color-accent-bright); }
.sw-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.sw-hero .link-call svg { color: var(--color-accent-bright); }
.sw-hero .link-call:hover { color: var(--color-white); }
.sw-hero .hero-form-open { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-white); }
.sw-hero .hero-form-open:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.sw-hero .hero-title { max-width: 16ch; }
.sw-hero .hero-chips li { background: var(--sw-tide); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.sw-hero .hero-chips svg { color: var(--color-accent-bright); }
.sw-hero .hero-form-card { border-bottom: 4px solid var(--color-accent); }
.sw-hero .hero-form .consent a { color: var(--color-primary); }
.sw-hero .sw-duo { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); margin-top: var(--space-xs); }
.sw-hero .sw-duo .form-row + .form-row { margin-top: 0; }

/* ---- Warning signs: wide intro bar + four-up row ---- */
.sw-signs { background: var(--color-paper); }
.sw-signs__head { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: end; margin-bottom: var(--space-2xl); }
.sw-signs__head .answer-block { margin: 0; }
.sw-motto { margin: 0; padding-left: var(--space-lg); border-left: 4px solid var(--color-accent); font-family: var(--font-heading); font-weight: 700; font-size: clamp(1.35rem, 1rem + 1.4vw, 1.9rem); line-height: 1.2; color: var(--color-ink); }
.sw-row { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.sw-row li { position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-xl) var(--space-lg) var(--space-lg); border-radius: var(--radius-lg) var(--radius-lg) var(--radius-sm) var(--radius-sm); background: var(--color-surface); border: 1px solid var(--color-line); border-bottom: 4px solid var(--color-secondary); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.sw-row li:nth-child(odd) { border-bottom-color: var(--color-accent); }
.sw-row li:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.sw-row svg { color: var(--color-accent-dark); }
.sw-row h3 { font-size: var(--font-size-lg); }
.sw-row p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Signature: the 1978 rule (dark band) ---- */
.sw-rule__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.sw-rule__year { position: relative; font-family: var(--font-accent); font-weight: 700; font-size: clamp(5rem, 3rem + 9vw, 10rem); line-height: .8; letter-spacing: -.02em; color: transparent; -webkit-text-stroke: 2px var(--color-accent-bright); margin-bottom: var(--space-lg); }
.sw-rule__year span { display: block; font-size: var(--fs-eyebrow); letter-spacing: .18em; text-transform: uppercase; -webkit-text-stroke: 0; color: color-mix(in srgb, var(--color-white) 72%, transparent); margin-top: var(--space-sm); }
.sw-rule .answer-block { background: var(--sw-tide); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: var(--space-md) 0 0; }
.sw-gate { counter-reset: swgate; display: grid; gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.sw-gate li { counter-increment: swgate; display: grid; grid-template-columns: 3rem minmax(0, 1fr); gap: var(--space-xs) var(--space-md); padding: var(--space-lg); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
.sw-gate li::before { content: counter(swgate); grid-row: span 2; width: 3rem; height: 3rem; display: grid; place-items: center; border-radius: var(--radius); background: var(--color-accent); color: var(--color-white); font-family: var(--font-accent); font-size: var(--font-size-xl); font-weight: 700; }
.sw-gate b { color: var(--color-white); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.sw-gate p { margin: 0; font-size: var(--fs-small); }
.sw-rule__more { margin-top: var(--space-xl); display: grid; gap: var(--space-sm); }
.sw-rule__more p { margin: 0; }

/* ---- Options table ---- */
.sw-options { background: var(--color-surface); }
.sw-options .section-head { max-width: 70ch; }
.sw-options .answer-block { margin: 0; }
.sw-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow); }
.sw-table { width: 100%; min-width: 760px; border-collapse: collapse; font-size: var(--fs-small); background: var(--color-surface); }
.sw-table caption { caption-side: bottom; text-align: left; padding: var(--space-sm) var(--space-lg); font-size: var(--font-size-xs); color: var(--color-muted); background: var(--color-paper); }
.sw-table th, .sw-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; }
.sw-table thead th { background: var(--sw-sand); color: var(--color-ink); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; border-bottom: 2px solid var(--color-accent); }
.sw-table tbody th { font-family: var(--font-heading); font-weight: 800; color: var(--color-ink); white-space: nowrap; }
.sw-table tbody tr { border-bottom: 1px solid var(--color-line); transition: background var(--transition); }
.sw-table tbody tr:hover { background: var(--color-paper); }
.sw-table tbody tr:first-child { background: var(--color-card-tint-3); }
.sw-table td { color: var(--color-ink-2); line-height: 1.5; }
.sw-shore { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr); gap: var(--space-xl); margin-top: var(--space-2xl); align-items: center; }
.sw-shore p { margin: 0; color: var(--color-ink-2); }
.sw-shore a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }
.sw-shoreline { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.sw-shoreline li { padding: var(--space-1) var(--space-sm); border-radius: var(--radius-full); background: var(--color-paper); border: 1px solid var(--color-line); font-size: var(--font-size-xs); font-weight: 600; color: var(--color-ink-2); }

/* ---- Process: tide-scale strip ---- */
.sw-process { background: var(--color-paper-2); }
.sw-process .section-head { max-width: 66ch; }
.sw-process .answer-block { margin: 0; background: var(--color-surface); }
.sw-strip { counter-reset: swstep; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); margin: 0; padding: 0; list-style: none; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
.sw-strip li { counter-increment: swstep; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-2xl) var(--space-lg) var(--space-xl); background: var(--color-surface); }
.sw-strip li:nth-child(2) { background: var(--color-card-tint-1); }
.sw-strip li:nth-child(3) { background: var(--color-card-tint-2); }
.sw-strip li:nth-child(4) { background: var(--color-dark); color: var(--color-white); }
.sw-strip li:nth-child(4) h3 { color: var(--color-white); }
.sw-strip li:nth-child(4) p { color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.sw-strip li::before { content: "0" counter(swstep); font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-h2); line-height: 1; color: var(--color-accent-dark); }
.sw-strip li:nth-child(4)::before { color: var(--color-accent-bright); }
.sw-strip li::after { content: ""; position: absolute; left: 0; right: 0; top: 0; height: 6px; background: repeating-linear-gradient(90deg, var(--color-accent) 0 2px, transparent 2px 10px); opacity: .55; }
.sw-strip h3 { font-size: var(--font-size-lg); }
.sw-strip p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- FAQ ---- */
.sw-faq { background: var(--color-paper); }
.sw-faq .answer-block { margin-bottom: var(--space-lg); }
.sw-faq .faq { border-top: 1px solid var(--color-line); border-bottom: 1px solid var(--color-line); }
.sw-faq .faq summary { min-height: 44px; }

/* ---- Other services ---- */
.sw-related { background: var(--color-surface); }
.sw-related .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.sw-related .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.sw-related .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow); }
.sw-related__more { margin-top: var(--space-xl); }

/* ---- Closing CTA ---- */
.sw-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.sw-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.sw-cta .link-call svg { color: var(--color-accent-bright); }
.sw-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.sw-cta::before { content: ""; position: absolute; inset: auto 0 0 0; height: 40%; z-index: -1; pointer-events: none; background: repeating-radial-gradient(ellipse 140% 60% at 50% 170%, transparent 0 16px, var(--sw-tide) 16px 17px); }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .sw-signs__head, .sw-rule__grid, .sw-shore { grid-template-columns: 1fr; }
  .sw-row, .sw-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 900px) { .sw-related .services-grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) {
  .sw-row, .sw-strip { grid-template-columns: 1fr; }
  .sw-hero .sw-duo { grid-template-columns: 1fr; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="sw">

<!-- ============ HERO (interior, compact form card) ============ -->
<section class="hero hero--interior sw-hero" aria-labelledby="sw-hero-title">
  <span class="sw-hero__tide" aria-hidden="true"></span>
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
        <span class="eyebrow">Sea Walls · Plymouth, MA</span>
        <h1 class="hero-title" id="sw-hero-title"><span class="text-accent">Sea wall</span> construction in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services builds sea walls for waterfront property in Plymouth, MA, working from its base on Beaver Dam Road. Before work is scheduled we look at the building the wall protects, the coastal bank, equipment access at low tide and the permits the job will need.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($swTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('landmark', 16); ?>Planned around coastal permits</li>
          <li><?php icon('waves', 16); ?>Bank and tides checked first</li>
          <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a sea wall estimate?</h2>
        <p class="hero-form-tagline">Tell us where the property is and what the bank or wall looks like now.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="sw-duo">
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

<article class="sw-article" aria-labelledby="sw-hero-title">

<!-- ============ WARNING SIGNS ============ -->
<section class="section sw-signs" aria-labelledby="sw-signs-title">
  <div class="container-wide">
    <div class="sw-signs__head reveal-up">
      <div>
        <span class="eyebrow-label">When to call</span>
        <h2 id="sw-signs-title">When does a Plymouth waterfront property need <span class="text-accent">sea wall</span> work?</h2>
        <p class="answer-block">A Plymouth waterfront property needs sea wall work when an existing wall is failing or bank erosion is moving toward a building. BDPM Site Services, an excavation contractor based in Plymouth, looks first for the usual warnings: storm damage, a scoured toe, or soil washing out from behind the wall.</p>
      </div>
      <p class="sw-motto">A wall is only as good as its toe and its drainage.</p>
    </div>
    <ul class="sw-row" aria-label="Warning signs on a sea wall or coastal bank">
<?php foreach ($swSigns as $swI => $swSign): ?>
      <li class="reveal-up reveal-delay-<?php echo ($swI % 4) + 1; ?>"><?php icon($swSign['icon'], 26); ?><h3><?php echo h($swSign['title']); ?></h3><p><?php echo h($swSign['text']); ?></p></li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============ SIGNATURE: the 1978 rule (dark band) ============ -->
<section class="section texture-grain edge-wave-top sw-rule" aria-labelledby="sw-rule-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="sw-rule__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">The coastal bank rule</span>
        <div class="sw-rule__year" aria-hidden="true">1978<span>August 10 · the line that matters</span></div>
        <h2 id="sw-rule-title">Can I build a new sea wall on my Plymouth property?</h2>
        <p class="answer-block">Only in specific cases: Massachusetts allows a new sea wall at a coastal bank mainly to protect a building built before August 10, 1978. The rule covers work on or within 100 feet of the bank, the design must limit wave effects on nearby beaches, and no other protection method can be feasible.</p>
      </div>
      <div class="reveal-right">
        <ol class="sw-gate" aria-label="Three tests for a new coastal engineering structure">
<?php foreach ($swTests as $swTest): ?>
          <li><b><?php echo h($swTest[0]); ?></b><p><?php echo h($swTest[1]); ?></p></li>
<?php endforeach; ?>
        </ol>
        <div class="sw-rule__more">
          <p>Repairing or rebuilding an existing wall is a different question from building a new one, but it still goes before the Plymouth Conservation Commission, typically through a Notice of Intent that ends in an Order of Conditions. Work in tidelands, below the historic high-water mark, may also need a Chapter 91 waterways license from MassDEP.</p>
          <p>The building's construction date is the first fact to find. The assessor's record, old permits or the deed history usually settle it before anyone pays for a design.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ OPTIONS (comparison table) ============ -->
<section class="section sw-options" aria-labelledby="sw-options-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Options</span>
      <h2 id="sw-options-title">What are the options for protecting a Plymouth coastal bank?</h2>
      <p class="answer-block">Plymouth coastal banks are protected four main ways: a vertical sea wall, a sloped stone revetment, a sheet-pile bulkhead, or softer stabilization with plantings and natural fiber. Which one fits depends on the building's age, the wave exposure, the beach in front and what the Conservation Commission will approve.</p>
    </div>
    <div class="sw-table-wrap reveal-up">
      <table class="sw-table">
        <caption>General comparison; the engineer's plan and the Commission's order decide what is built on a given lot.</caption>
        <thead>
          <tr><th scope="col">Option</th><th scope="col">What it is</th><th scope="col">Where it tends to fit</th><th scope="col">Permitting note</th></tr>
        </thead>
        <tbody>
<?php foreach ($swOptions as $swOpt): ?>
          <tr><th scope="row"><?php echo h($swOpt[0]); ?></th><td><?php echo h($swOpt[1]); ?></td><td><?php echo h($swOpt[2]); ?></td><td><?php echo h($swOpt[3]); ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="sw-shore reveal-up">
      <p>Plymouth's shoreline runs from the harbor and Plymouth Long Beach south past Priscilla Beach, White Horse Beach and Manomet to Ellisville, and the exposure changes along the way, from sheltered harbor edges to open Cape Cod Bay beaches and the high bluffs at Manomet. Where a house near the water needs support rather than shore protection, <a href="/services/helical-piers/">helical piers for decks and additions</a> carry the load with little digging, and the rest of the lot's ground work is covered under <a href="/services/">BDPM Site Services' full service list</a>.</p>
      <ul class="sw-shoreline" aria-label="Plymouth shoreline, north to south">
        <li>Plymouth Harbor</li><li>Plymouth Long Beach</li><li>Priscilla Beach</li><li>White Horse Beach</li><li>Manomet</li><li>Ellisville</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ PROCESS (tide-scale strip) ============ -->
<section class="section slant-top sw-process" aria-labelledby="sw-process-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">How the job runs</span>
      <h2 id="sw-process-title">How does a sea wall project in Plymouth run from first visit to final grade?</h2>
      <p class="answer-block">A Plymouth sea wall project runs from a shoreline site visit to plans and permits, then tide-timed construction, then backfill and drainage. Permits usually take the longest, so BDPM Site Services builds the schedule around the Conservation Commission's review and the conditions it sets for the work.</p>
    </div>
    <ol class="sw-strip reveal-up">
<?php foreach ($swSteps as $swStep): ?>
      <li><h3><?php echo h($swStep[0]); ?></h3><p><?php echo h($swStep[1]); ?></p></li>
<?php endforeach; ?>
    </ol>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$swReviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($swReviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $swReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section sw-faq" aria-labelledby="sw-faq-title">
  <div class="container-narrow">
    <span class="eyebrow-label">Questions</span>
    <h2 id="sw-faq-title">What do Plymouth waterfront owners ask before sea wall work starts?</h2>
    <p class="answer-block">Plymouth waterfront owners most often ask BDPM Site Services whether sea wall work needs a wetlands or conservation permit. On the coast the answer is nearly always yes, and the estimate visit is the time to work out which review applies to your lot.</p>
<?php foreach ($swFaqs as $swFaq): ?>
    <details class="faq reveal-up" open>
      <summary><?php echo h($swFaq['q']); ?></summary>
      <p class="faq-answer"><?php echo h($swFaq['a']); ?></p>
    </details>
<?php endforeach; ?>
  </div>
</section>

<!-- ============ OTHER SERVICES (required services component, 3 cards) ============ -->
<section class="section edge-curve-top sw-related" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What other work does a <span class="text-accent">Plymouth waterfront lot</span> often need?</h2>
      <p class="hero-answer">A Plymouth waterfront lot often needs more than shore protection. BDPM Site Services also sets helical piers for decks and additions near the water, handles excavation and grading, and installs septic systems, so the ground work on a coastal property can stay with one contractor and one schedule.</p>
    </div>
    <div class="services-grid">
<?php foreach ($swRelated as $swRelI => $swRelSlug):
    $swRelSvc = serviceBySlug($swRelSlug);
    $swRelCard = $swCards[$swRelSlug]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($swRelI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($swRelI % 3) + 1; ?>">
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($swRelCard['icon'], 26); ?></div>
          <h3><?php echo h($swRelSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($swRelCard['desc']); ?></p>
          <ul>
<?php foreach ($swRelCard['bullets'] as $swBullet): ?>
            <li><?php echo h($swBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($swRelSlug); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($swRelSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <p class="sw-related__more reveal-up"><a class="btn btn-secondary" href="/services/">See all five Plymouth services</a></p>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-torn-top sw-cta" aria-labelledby="sw-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="sw-cta-title">Ready for a free sea wall estimate in Plymouth?</h2>
      <p>Send the address and a few lines about the bank or the wall. BDPM Site Services will walk the shoreline and send a written estimate with the scope, price and schedule.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free sea wall estimate</button>
      <a class="link-call" href="<?php echo h($swTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
