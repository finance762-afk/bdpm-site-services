<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/plymouth/ — Phase 6 city page (premium, warm-human archetype). The only area in build-plan service_areas.
 * Photos (2026-10-20): photo hero (.hero--photo, LCP preloaded), a three-photo strip and a registry photo on every service card, all
 * from includes/photos.php. The signature section is the "ground by part of town" table.
 *
 * RESEARCH (checked 2026-10-19). Every named place below is confirmed by at least one of these:
 *   Villages Plymouth Center / North / West / South Plymouth / Manomet / Cedarville; largest municipality in MA by area (96.4 sq mi land,
 *     37.5 sq mi water); entire western shore of Cape Cod Bay; Plymouth Beach ~3-mile barrier beach guarding Plymouth Harbor; Clark's Island
 *     the only island; Plymouth Pinelands, hilly and forested west; Myles Standish State Forest (SW, 16 freshwater ponds); Great Herring Pond;
 *     county seat of Plymouth County; ZIPs 02360-02362, 02345 Manomet, 02381 White Horse Beach — https://en.wikipedia.org/wiki/Plymouth,_Massachusetts
 *   Outwash plain, ~14,000-year-old glacial meltwater sand and gravel, kettle ponds, the "Six Ponds" (Bloody, Gallows, Halfway, Little Long, Long,
 *     Round) — https://sixponds.org/_uploads/pdfs/1Water_Quality_Overview.pdf and https://www.wildlandstrust.org/news-blog/tag/Halfway+Pond+Conservation+Area
 *   Kettle ponds are depressions whose bottoms sit below the water table — Groton Conservation Trust, https://grotontrails.org/our-icy-past/
 *   Southern Plymouth coastal banks 100 ft+, high risk of erosion and slumping; town has 26 miles of coastline; officials name Long Beach,
 *     Whitehorse Beach and the South Plymouth cliffs as problem areas — WHOI Sea Grant, https://seagrant.whoi.edu/wp-content/uploads/2015/01/Shoreline-Change-and-the-Importance-of-Co.pdf
 *     and NECN (undated), https://www.necn.com/news/local/_necn__erosion_a_major_concern_in_plymouth__mass__necn/165367/
 *   Plymouth Wetland Bylaw 50-ft no-build / 35-ft no-touch zones (seen in Conservation Commission agendas as waiver requests, 2009-2014;
 *     current text not retrieved, so the copy tells readers to read the current bylaw) — https://cmsarchive.civicplus.com/Plymouth%20MA%20Minutes-Agenda/
 *   Board of Health final inspection before backfill on new systems (since July 2005); local Title 5 supplement (last amended Oct 24, 2023) —
 *     https://plymouth-ma.gov/DocumentCenter/View/3825/BOH-Rules-and-Regulations, https://plymouth-ma.gov/DocumentCenter/View/1898/Title-5-Supplement---4-13-2011-PDF
 *   Dig Safe: notice 72 hours ahead, weekends and holidays excluded — build-plan research_brief.faqs; mass.gov About Dig Safe
 *   Frost line 48 in — 780 CMR (cited on the site-construction page).
 * NOT USED: elevation (Wikipedia gives a single 187 ft figure, sources conflict, so no number is printed); USDA zone (the 2023 map value for
 *   ZIP 02360 could not be confirmed from the USDA site, only a third-party mirror said 7a); Ellisville, Chiltonville, Idetown-type names and
 *   anything about frequency of past work in town. Company claims are limited to config.php / build-plan.json.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$paBase          = rtrim($siteUrl, '/');
$paCity          = 'Plymouth';
$paPlace         = $paCity . ', ' . $address['state'];
$pageTitle       = 'Excavation Contractor in Plymouth, MA | BDPM Site Services';
$pageDescription = 'BDPM Site Services digs, grades and installs septic systems across Plymouth, MA, from pinelands to coastal banks. Written estimates. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/service-areas/plymouth/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'service-areas';
$pageType        = 'city';
$citySlug        = 'plymouth';
$paHeroPhoto     = 'stone-retaining-wall-shoreline-construction';
$heroPreload     = photoHeroPreload($paHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ['name' => $paPlace, 'url' => '/service-areas/plymouth/'],
];

$paTel   = formatPhone($phone, 'tel');
$paCards = serviceCards();

$paFaqs = [
    ['q' => 'Does BDPM Site Services work in all of Plymouth, including Manomet and the other villages?',
     'a' => 'BDPM Site Services is based at ' . $address['street'] . ' in Plymouth and serves the town, which includes Plymouth Center, North Plymouth, West Plymouth, South Plymouth, Manomet and Cedarville. Call ' . $phone . ' with the address and the crew will confirm the job is within reach before booking a site visit.'],
    ['q' => 'Will my project need a wetlands or conservation permit in Plymouth?',
     'a' => 'It may. Work within wetland resource areas or their buffer zones is regulated under the Massachusetts Wetlands Protection Act and local bylaws, which often means review by the Plymouth Conservation Commission. Tell BDPM Site Services about the property during the estimate and we will explain what review is likely before any work is scheduled.'],
    ['q' => 'Do I need to call Dig Safe before digging in Plymouth?',
     'a' => 'Yes. In Massachusetts you must contact Dig Safe by calling 811 or 1-888-344-7233 before any excavation. Utility companies then mark their underground lines. Dig Safe requires notice at least 72 hours before digging, not counting weekends and holidays. BDPM Site Services confirms the markings before any work begins.'],
];

$paGround = [
    ['West Plymouth and the pinelands',
     'Hilly, forested land in the Plymouth Pinelands. Sand and gravel left by retreating glaciers underlie much of it, and ponds are scattered through it, from the Six Ponds cluster to the 16 ponds inside Myles Standish State Forest.',
     'Loose sand digs quickly, but the walls of a deep trench need support. Low ground near a pond sits close to the water table, so the drainage plan comes before the dig.'],
    ['Plymouth Center and North Plymouth',
     'The harbor side. Plymouth Beach, a roughly three-mile barrier beach, guards Plymouth Harbor, and Clark\'s Island is the town\'s only island. Lots built up decades ago can turn up clay, buried fill or boulders where sand was expected.',
     'Shoreline and harbor-edge work falls under coastal and wetland review. Machine access, and what is buried at footing depth, are checked at the site visit.'],
    ['Manomet and South Plymouth',
     'Coastal banks of 100 feet and more rise along the southern shore, and state coastal studies flag many homes on them as at high risk from erosion and slumping.',
     'Work near a bank starts with the Conservation Commission, and bank drainage matters as much as the wall in front of it.'],
    ['White Horse Beach and Long Beach',
     'Plymouth officials have named White Horse Beach and Long Beach, along with the South Plymouth cliffs, as the places where erosion is the problem.',
     'Sea wall and bank work is permit-driven here. The schedule is built around the review and the tides, not the other way around.'],
];

$paWhy = [
    ['map-pin', 'A Plymouth address and phone', $address['street'] . ', ' . $paPlace . ' ' . $address['zip'] . '. Call ' . $phone . ' during office hours, ' . $businessHours . '.'],
    ['users', 'Owner-run', $ownerName . ' owns and runs BDPM Site Services, so the person you talk to at the estimate is the person responsible for the job.'],
    ['layers', 'Five ground trades, one contractor', 'Excavation, septic installation, Title 5 inspections, sea walls and helical piers share the same soil questions and the same permit reviews.'],
    ['clipboard-list', 'A written estimate after a site visit', 'Scope, price and schedule are itemized after the crew has seen the soil, the ledge, the access and the water on your lot.'],
    ['landmark', 'Permits explained before the work is scheduled', 'Tell us about the property and we explain what Conservation Commission or Board of Health review is likely, so it is on the schedule from day one.'],
];

$schemaMarkup = [
    [   // areaServed for THIS area, merged into the sitewide LocalBusiness node by @id
        '@context' => 'https://schema.org',
        '@type' => ['LocalBusiness', 'GeneralContractor'],
        '@id' => $paBase . '/#organization',
        'name' => $siteName,
        'url' => $paBase . '/',
        'areaServed' => [
            '@type' => 'City',
            'name' => $paPlace,
            'sameAs' => 'https://en.wikipedia.org/wiki/Plymouth,_Massachusetts',
            'containedInPlace' => ['@type' => 'AdministrativeArea', 'name' => $primaryCounty . ', ' . $address['state']],
        ],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => $paBase . '/service-areas/plymouth/#webpage',
        'url' => $paBase . '/service-areas/plymouth/',
        'name' => $pageTitle,
        'about' => ['@id' => $paBase . '/#organization'],
        'isPartOf' => ['@type' => 'WebSite', 'url' => $paBase . '/'],
        'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
    ],
    generateFAQSchema($paFaqs),
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Plymouth service area — page composition (tokens only).
   Motif: strata. Layered ground bands in the hero, a dark "ground by part of
   town" table as the signature, a field-notes card beside the local copy.
   ========================================================================== */
.pa h1, .pa h2, .pa h3 { text-wrap: balance; }
.pa p { text-wrap: pretty; }
.pa { --pa-strata-1: color-mix(in srgb, var(--color-accent) 22%, transparent); --pa-strata-2: color-mix(in srgb, var(--color-white) 8%, transparent); }

/* ---- Hero: strata bands + noise ---- */
.pa-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 55% 70% at 88% 8%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              linear-gradient(180deg, transparent 0%, transparent 62%, color-mix(in srgb, var(--color-secondary) 24%, transparent) 100%);
}
.pa-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .26; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.pa-hero .hero-bg img { object-position: 50% 60%; }
.pa-hero__strata { position: absolute; inset: auto 0 0 0; height: 38%; z-index: -1; pointer-events: none; background: repeating-linear-gradient(176deg, transparent 0 26px, var(--pa-strata-2) 26px 28px, transparent 28px 58px, var(--pa-strata-1) 58px 59px); -webkit-mask: linear-gradient(180deg, transparent, var(--color-black) 70%); mask: linear-gradient(180deg, transparent, var(--color-black) 70%); }
.pa-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.pa-hero .breadcrumb a:hover { color: var(--color-white); }
.pa-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.pa-hero .text-accent { color: var(--color-accent-bright); }
.pa-hero .hero-title { max-width: 18ch; }
.pa-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.pa-hero .link-call svg { color: var(--color-accent-bright); }
.pa-hero .link-call:hover { color: var(--color-white); }
.pa-hero .hero-form-open { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-ink); }
.pa-hero .hero-form-open:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.pa-hero .hero-chips li { background: var(--pa-strata-2); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.pa-hero .hero-chips svg { color: var(--color-accent-bright); }
.pa-hero .hero-form-card { border-bottom: 4px solid var(--color-accent); }
.pa-hero .hero-form .consent a { color: var(--color-primary); }

/* ---- Local copy + field-notes card (asymmetric) ---- */
.pa-local { background: var(--color-paper); }
.pa-local__grid { display: grid; grid-template-columns: minmax(0, 1.55fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.pa-local__copy { display: grid; gap: var(--space-md); }
.pa-local__copy p { margin: 0; max-width: var(--measure); color: var(--color-ink-2); }
.pa-local__copy a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }
.pa-local__copy .answer-block { margin: 0; color: var(--color-ink); }
.pa-notes { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); padding: var(--space-xl); border-radius: var(--radius-lg) var(--radius-lg) var(--radius-sm) var(--radius-sm); background: var(--color-card-tint-3); border: 1px solid var(--color-line); border-top: 6px solid var(--color-accent); box-shadow: var(--shadow); display: grid; gap: var(--space-md); }
.pa-notes h3 { font-size: var(--font-size-xl); }
.pa-notes dl { display: grid; gap: var(--space-md); margin: 0; }
.pa-notes dt { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.pa-notes dd { margin: var(--space-1) 0 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.5; }
.pa-notes__src { margin: 0; padding-top: var(--space-sm); border-top: 1px solid var(--color-line); font-size: var(--font-size-xs); color: var(--color-muted); }

/* ---- Signature: ground by part of town (dark band) ---- */
.pa-ground .section-head { max-width: 70ch; }
.pa-ground .answer-block { margin: 0; background: color-mix(in srgb, var(--color-white) 8%, transparent); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.pa-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); background: color-mix(in srgb, var(--color-white) 5%, transparent); }
.pa-table { width: 100%; min-width: 760px; border-collapse: collapse; font-size: var(--fs-small); }
.pa-table caption { caption-side: bottom; text-align: left; padding: var(--space-sm) var(--space-lg); font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.pa-table th, .pa-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; }
.pa-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); border-bottom: 2px solid var(--color-accent); }
.pa-table tbody tr { border-bottom: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); }
.pa-table tbody tr:last-child { border-bottom: 0; }
.pa-table tbody th { font-family: var(--font-heading); font-weight: 800; font-size: var(--font-size-lg); color: var(--color-white); width: 20%; }
.pa-table td { color: color-mix(in srgb, var(--color-white) 82%, transparent); line-height: 1.55; }
.pa-ground__sources { margin-top: var(--space-lg); font-size: var(--font-size-sm); color: color-mix(in srgb, var(--color-white) 78%, transparent); max-width: 80ch; }
.pa-ground__sources a { color: var(--color-accent-bright); text-decoration: underline; text-underline-offset: .15em; }

/* ---- Permits strip (three approvals) ---- */
.pa-permits { background: var(--color-surface); }
.pa-permits .section-head { max-width: 68ch; }
.pa-permits .answer-block { margin: 0; }
.pa-permits__row { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.pa-permits__row li { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-xl) var(--space-lg) var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); border-bottom: 4px solid var(--color-secondary); box-shadow: var(--shadow-sm); }
.pa-permits__row li:nth-child(1) { background: var(--color-card-tint-1); }
.pa-permits__row li:nth-child(2) { background: var(--color-card-tint-2); border-bottom-color: var(--color-accent); }
.pa-permits__row li:nth-child(3) { background: var(--color-card-tint-3); }
.pa-permits__row svg { color: var(--color-accent-dark); }
.pa-permits__row h3 { font-size: var(--font-size-lg); }
.pa-permits__row p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Photo strip (three registry photos) ---- */
.pa-photos { background: var(--color-paper-2); }
.pa-photos__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.pa-photos__intro { display: grid; gap: var(--space-md); }
.pa-photos__intro .answer-block { margin: 0; background: var(--color-surface); }
.pa-photos .sp-gallery-grid { margin: 0; }
.pa-photos .sp-gallery-item { box-shadow: var(--shadow); }

/* ---- Services available (required services component) ---- */
.pa-services { background: var(--color-paper-2); }
.pa-services__more { margin-top: var(--space-xl); display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-md); }
.pa-services__more p { margin: 0; color: var(--color-ink-2); font-size: var(--fs-small); }

/* ---- Why us ---- */
.pa-why { background: var(--color-paper); }
.pa-why__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.3fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.pa-why .answer-block { margin: var(--space-md) 0 0; }
.pa-why__list { counter-reset: pawhy; display: grid; gap: var(--space-sm); margin: 0; padding: 0; list-style: none; }
.pa-why__list li { counter-increment: pawhy; display: grid; grid-template-columns: 2.75rem minmax(0, 1fr); gap: var(--space-xs) var(--space-md); padding: var(--space-md) var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.pa-why__list li::before { content: counter(pawhy); grid-row: span 2; width: 2.75rem; height: 2.75rem; display: grid; place-items: center; border-radius: var(--radius); background: var(--color-primary); color: var(--color-white); font-family: var(--font-accent); font-size: var(--font-size-xl); font-weight: 700; }
.pa-why__list li:nth-child(odd)::before { background: var(--color-accent); color: var(--color-ink); }
.pa-why__list b { font-family: var(--font-heading); font-size: var(--font-size-lg); color: var(--color-ink); }
.pa-why__list p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- FAQ ---- */
.pa-faq { background: var(--color-surface); }
.pa-faq .answer-block { margin-bottom: var(--space-lg); }
.pa-faq .faq { border-bottom: 1px solid var(--color-line); }
.pa-faq .faq summary { min-height: 44px; }

/* ---- Closing CTA ---- */
.pa-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.pa-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.pa-cta .link-call svg { color: var(--color-accent-bright); }
.pa-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.pa-cta__dir { color: color-mix(in srgb, var(--color-white) 90%, transparent); text-decoration: underline; text-underline-offset: .18em; min-height: 44px; display: inline-flex; align-items: center; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .pa-local__grid, .pa-why__grid, .pa-photos__grid { grid-template-columns: 1fr; }
  .pa-notes { position: static; }
  .pa-permits__row { grid-template-columns: 1fr; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="pa">

<!-- ============ HERO (interior, compact form card) ============ -->
<section class="hero hero--interior hero--photo pa-hero" aria-labelledby="pa-hero-title">
  <div class="hero-bg"><?php echo photoPicture($paHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <span class="pa-hero__strata" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><a href="/service-areas/">Service Areas</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li aria-current="page"><?php echo h($paPlace); ?></li>
          </ol>
        </nav>
        <span class="eyebrow">Service area · <?php echo h($paPlace); ?></span>
        <h1 class="hero-title" id="pa-hero-title"><span class="text-accent">Site excavation</span> in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services digs, grades and installs septic systems in Plymouth, MA from its base on Beaver Dam Road, and prices each job in writing after a site visit.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($paTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('map-pin', 16); ?>Based on Beaver Dam Rd</li>
          <li><?php icon('clipboard-list', 16); ?>Written estimates</li>
          <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Free estimate in Plymouth</h2>
        <p class="hero-form-tagline">Tell us where the property is and what the ground needs.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Get my free estimate</button>
        </form>
        <p class="form-footnote">Office hours <?php echo h($businessHours); ?>.</p>
      </aside>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<article class="pa-article" aria-labelledby="pa-hero-title">

<!-- ============ LOCAL COPY + FIELD NOTES ============ -->
<section class="section pa-local" aria-labelledby="pa-local-title">
  <div class="container-wide">
    <div class="pa-local__grid">
      <div class="pa-local__copy reveal-left">
        <span class="eyebrow-label">Excavation near me in Plymouth</span>
        <h2 id="pa-local-title">What does an excavation job in Plymouth, MA actually involve?</h2>
        <p class="answer-block">BDPM Site Services is an excavation contractor based at 168 Beaver Dam Rd in Plymouth, MA. A Plymouth job starts with where in town the lot sits, because the ground changes from pinelands to harbor to coastal bank, and each one changes the equipment, the drainage plan and the permits.</p>
        <p>Plymouth is the largest town in Massachusetts by area, 96 square miles of land and 37 more of water, and it is the county seat of Plymouth County. It takes in the whole western shore of Cape Cod Bay, and its villages run from Plymouth Center and North Plymouth to West Plymouth, South Plymouth, Manomet and Cedarville. Someone searching for an excavation contractor near them in Plymouth is rarely asking about the same ground as the next caller.</p>
        <p>Inland, the town sits in the Plymouth Pinelands: hilly, forested country where the western ponds, the kettle ponds of the Six Ponds cluster and the 16 ponds inside Myles Standish State Forest mark where meltwater and buried ice shaped the land about 14,000 years ago. Sand and gravel dig fast, but a deep trench in loose sand needs its walls supported, and a low lot beside a pond can hold water close to the surface. <a href="/services/site-construction-excavation/">Site construction and excavation</a> in those conditions is planned around trench support and drainage before the machine arrives.</p>
        <p>On the coast the questions change. Plymouth Beach, a roughly three-mile barrier beach, guards the harbor, and the banks along the southern shore reach 100 feet and more. Wherever the work touches a coastal bank, a wetland or its buffer zone, the Plymouth Conservation Commission is part of the schedule, and a new septic system goes through the Board of Health, which inspects before the trench is backfilled. <a href="/services/septic-system-installation/">Septic system installation</a> and <a href="/services/sea-walls/">sea wall work</a> are built around those reviews rather than waiting on them.</p>
      </div>
      <aside class="pa-notes reveal-right" aria-labelledby="pa-notes-title">
        <span class="eyebrow-label">Field notes</span>
        <h3 id="pa-notes-title">Plymouth at a glance</h3>
        <dl>
          <div><dt>Size</dt><dd>96.4 square miles of land and 37.5 of water, the largest municipality in Massachusetts by area.</dd></div>
          <div><dt>Villages</dt><dd>Plymouth Center, North Plymouth, West Plymouth, South Plymouth, Manomet and Cedarville.</dd></div>
          <div><dt>Water</dt><dd>The entire western shore of Cape Cod Bay, with nine public beaches and Clark's Island offshore.</dd></div>
          <div><dt>Inland</dt><dd>The Plymouth Pinelands, with Myles Standish State Forest in the southwest and Great Herring Pond in the western quadrant.</dd></div>
          <div><dt>ZIP codes</dt><dd>02360, 02361, 02362, 02345 (Manomet) and 02381 (White Horse Beach).</dd></div>
        </dl>
        <p class="pa-notes__src">Source: the town's <a href="https://en.wikipedia.org/wiki/Plymouth,_Massachusetts" rel="noopener" target="_blank">Wikipedia entry</a>.</p>
      </aside>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: ground by part of town (dark band) ============ -->
<section class="section texture-grain edge-wave-top pa-ground" aria-labelledby="pa-ground-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">The ground, village by village</span>
      <h2 id="pa-ground-title">How does the ground change from one part of Plymouth to the next?</h2>
      <p class="answer-block">The ground in Plymouth changes from sandy, pond-dotted pinelands in the west to harbor frontage in the center and high eroding banks in the south. BDPM Site Services plans the equipment, drainage and permit steps for the part of town your lot is in, not for an average Plymouth lot.</p>
    </div>
    <div class="pa-table-wrap reveal-up">
      <table class="pa-table">
        <caption>General conditions by area, from the public sources listed below. The site visit decides what a given lot actually has.</caption>
        <thead>
          <tr><th scope="col">Part of town</th><th scope="col">What the land and water look like</th><th scope="col">What the crew plans around</th></tr>
        </thead>
        <tbody>
<?php foreach ($paGround as $paRow): ?>
          <tr><th scope="row"><?php echo h($paRow[0]); ?></th><td><?php echo h($paRow[1]); ?></td><td><?php echo h($paRow[2]); ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="pa-ground__sources reveal-up">Sources: <a href="https://en.wikipedia.org/wiki/Plymouth,_Massachusetts" target="_blank" rel="noopener">Plymouth, Massachusetts</a> (geography), <a href="https://sixponds.org/_uploads/pdfs/1Water_Quality_Overview.pdf" target="_blank" rel="noopener">Six Ponds water quality overview</a> (glacial outwash and kettle ponds), <a href="https://seagrant.whoi.edu/wp-content/uploads/2015/01/Shoreline-Change-and-the-Importance-of-Co.pdf" target="_blank" rel="noopener">WHOI Sea Grant</a> (southern Plymouth coastal banks) and <a href="https://www.necn.com/news/local/_necn__erosion_a_major_concern_in_plymouth__mass__necn/165367/" target="_blank" rel="noopener">NECN's report on Plymouth erosion</a> (the beaches town officials named).</p>
  </div>
</section>

<!-- ============ PHOTOS (three registry photos) ============ -->
<section class="section pa-photos" aria-labelledby="pa-photos-title">
  <div class="container-wide">
    <div class="pa-photos__grid">
      <div class="pa-photos__intro reveal-left">
        <span class="eyebrow-label">On Plymouth lots</span>
        <h2 id="pa-photos-title">What does <span class="text-accent">BDPM Site Services</span> work look like on a Plymouth lot?</h2>
        <p class="answer-block">BDPM Site Services work on a Plymouth lot is mostly below grade: septic risers brought to the surface, a tee fitting set in a concrete tank, and a foundation excavation with the crew in the hole. These three photos show that work in progress.</p>
      </div>
      <div class="sp-gallery-grid reveal-right">
      <figure class="sp-gallery-item reveal-up reveal-delay-1"><?php echo photoPicture('excavator-foundation-dig-worker-plymouth', '(max-width: 700px) 92vw, 520px'); ?><figcaption>Foundation excavation with the crew in the hole</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-2"><?php echo photoPicture('septic-access-covers-concrete-risers', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Septic access covers brought to grade on concrete risers</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-3"><?php echo photoPicture('installing-septic-tee-fitting-concrete-tank', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Setting a tee fitting in a concrete septic tank</figcaption></figure>
      </div>
    </div>
  </div>
</section>

<!-- ============ PERMITS: three approvals on a Plymouth lot ============ -->
<section class="section pa-permits" aria-labelledby="pa-permits-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Before the machine arrives</span>
      <h2 id="pa-permits-title">Which approvals can a Plymouth excavation job need?</h2>
      <p class="answer-block">A Plymouth excavation job can need up to three approvals: a Dig Safe notice before any digging, Conservation Commission review near wetlands or a coastal bank, and Board of Health sign-off for septic work. BDPM Site Services lines them up at the estimate so none of them stalls the schedule.</p>
    </div>
    <ul class="pa-permits__row">
      <li class="reveal-up reveal-delay-1"><?php icon('phone', 26); ?><h3>Dig Safe, 811</h3><p>A notice goes in at least 72 hours before digging, not counting weekends and holidays, so utilities can mark their lines. The crew confirms the markings before the first cut.</p></li>
      <li class="reveal-up reveal-delay-2"><?php icon('landmark', 26); ?><h3>Plymouth Conservation Commission</h3><p>Work in a wetland resource area or its buffer zone can need a filing. The town's wetland bylaw has its own no-build and no-touch setbacks, so read the current text for your lot.</p></li>
      <li class="reveal-up reveal-delay-3"><?php icon('clipboard-list', 26); ?><h3>Plymouth Board of Health</h3><p>Plymouth publishes a local supplement to Title 5 and inspects a new septic system before it is backfilled, so the dig is scheduled around the inspector.</p></li>
    </ul>
  </div>
</section>

<!-- ============ SERVICES AVAILABLE IN PLYMOUTH (required services component, 5 cards -> featured grid) ============ -->
<section class="section slant-top pa-services" aria-label="Excavation contractor services in Plymouth">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What ground work can <span class="text-accent">BDPM Site Services</span> do on a Plymouth property?</h2>
      <p class="hero-answer">BDPM Site Services does five kinds of ground work in Plymouth, MA: site construction and excavation, septic system installation, Massachusetts Title 5 inspections, sea walls and helical piers. One contractor covers the dig, the septic system and the support underneath it, on one schedule.</p>
    </div>
    <div class="services-grid services-grid--featured">
<?php foreach ($services as $paIdx => $paSvc):
    $paCard = $paCards[$paSvc['slug']]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($paIdx % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($paIdx % 3) + 1; ?>"<?php echo $paIdx === 0 ? ' data-featured-label="Core service"' : ''; ?>>
        <div class="service-card__image"><?php echo photoPicture($paCard['photo'], $paIdx === 0 ? '(max-width: 1000px) 92vw, 760px' : '(max-width: 720px) 92vw, (max-width: 1000px) 46vw, 380px'); ?></div>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($paCard['icon'], 26); ?></div>
          <h3><?php echo h($paSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($paCard['desc']); ?></p>
          <ul>
<?php foreach ($paCard['bullets'] as $paBullet): ?>
            <li><?php echo h($paBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($paSvc['slug']); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($paSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <div class="pa-services__more reveal-up">
      <a class="btn btn-secondary" href="/services/">See all five services</a>
      <p>Not sure which one your lot needs? Describe it in the estimate form.</p>
    </div>
  </div>
</section>

<!-- ============ WHY BDPM FOR PLYMOUTH ============ -->
<section class="section pa-why" aria-labelledby="pa-why-title">
  <div class="container">
    <div class="pa-why__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Why BDPM Site Services</span>
        <h2 id="pa-why-title">Why hire a Plymouth-based excavation contractor for a Plymouth lot?</h2>
        <p class="answer-block">Hire BDPM Site Services for a Plymouth lot if you want an owner-run contractor with a local address, five related ground trades under one roof and a written scope, price and schedule before any work is booked.</p>
      </div>
      <ol class="pa-why__list">
<?php foreach ($paWhy as $paI => $paReason): ?>
        <li class="reveal-up reveal-delay-<?php echo ($paI % 4) + 1; ?>"><b><?php echo h($paReason[1]); ?></b><p><?php echo h($paReason[2]); ?></p></li>
<?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$paReviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($paReviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $paReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section pa-faq" aria-labelledby="pa-faq-title">
  <div class="container-narrow">
    <span class="eyebrow-label">Questions</span>
    <h2 id="pa-faq-title">What do Plymouth property owners ask before excavation starts?</h2>
    <p class="answer-block">Before excavation starts, Plymouth property owners need to know where BDPM Site Services works, whether the job needs a wetlands permit and whether Dig Safe applies. The answers are below, and the estimate visit settles each one for your lot.</p>
<?php foreach ($paFaqs as $paFaq): ?>
    <details class="faq reveal-up">
      <summary><?php echo h($paFaq['q']); ?></summary>
      <p class="faq-answer"><?php echo h($paFaq['a']); ?></p>
    </details>
<?php endforeach; ?>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-torn-top pa-cta" aria-labelledby="pa-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="pa-cta-title">Get a Free Estimate in Plymouth</h2>
      <p>Send the address and a few lines about the job. BDPM Site Services will walk the lot and send a written estimate with the scope, price and schedule.</p>
      <a class="pa-cta__dir" href="<?php echo h($gbp['directions']); ?>" target="_blank" rel="noopener">Get directions to 168 Beaver Dam Rd</a>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate in Plymouth</button>
      <a class="link-call" href="<?php echo h($paTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
