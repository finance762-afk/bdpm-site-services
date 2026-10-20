<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/site-construction-excavation/ — Phase 4 service page (premium editorial structure, warm-human archetype).
 * Photos (2026-10-20): photo hero (.hero--photo, LCP preloaded), a three-photo .sp-gallery-grid strip and a registry photo on
 * every related-service card, all from includes/photos.php. Facts trace to build-plan.json / config.php or to the public sources below; anything the page
 * wanted but intake did not supply is listed in /content-confirmations.json.
 * Sources (checked 2026-10-19):
 *   Dig Safe 72 hours, weekends/holidays excluded — build-plan research_brief.faqs
 *   Trench definition (> 3 ft deep, depth > width, ≤ 15 ft wide) + local trench permit — 520 CMR 14.02, https://www.mass.gov/files/documents/2017/10/06/520cmr14.pdf
 *   Frost line 48 in — 780 CMR 51.00 (10th ed.) Table R301.2(1), https://www.mass.gov/doc/10th-edition-residential-chapter-3-building-planning/download
 *   Protective systems for trenches 5 ft and deeper — OSHA 29 CFR 1926.652
 *   Utility mark colors — APWA uniform color code
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$svc             = serviceBySlug('site-construction-excavation');
$pageTitle       = 'Site Excavation Contractor Plymouth MA | BDPM Site Services';
$pageDescription = 'Site construction and excavation in Plymouth, MA: foundation digs, grading and trenches planned around Dig Safe, ledge and wetlands. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/services/site-construction-excavation/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'site-construction-excavation';
$exHeroPhoto = 'excavator-backhoe-loader-dirt-site';
$heroPreload     = photoHeroPreload($exHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/site-construction-excavation/'],
];

$exTel = formatPhone($phone, 'tel');

// FAQs — real customer questions from research_brief.faqs (wording checked against intake)
$exFaqs = [
    ['q' => 'Do I need to call Dig Safe before digging in Plymouth?',
     'a' => 'Yes. Massachusetts requires a Dig Safe request, by calling 811 or 1-888-344-7233, before any excavation, and the notice has to be in at least 72 hours ahead, not counting weekends and holidays. Utility companies then mark their underground lines. BDPM Site Services confirms the markings are in place before work begins.'],
    ['q' => 'How much does excavation cost in Plymouth?',
     'a' => 'Excavation cost in Plymouth depends on the size of the job, soil and ledge conditions, site access, how much material has to be hauled away and the timeline. BDPM Site Services gives a written estimate after a site visit, with the scope, price and schedule itemized so there are no surprises once the work starts.'],
];

$schemaMarkup = array_merge(servicePageSchema($svc,
    'Site construction and excavation in Plymouth, MA: foundation and footing digs, utility and drainage trenches, site preparation and final grading, scheduled around Dig Safe, permits and soil conditions.'),
    [generateFAQSchema($exFaqs)]);

$exSigns = [
    ['icon' => 'home', 'title' => 'Foundations and footings',
     'text' => 'New houses, additions and garages start with a hole dug to the plan\'s depth. Footings go below the 48-inch frost line the Massachusetts residential code lists for the state.'],
    ['icon' => 'route', 'title' => 'Utility and sewer trenches',
     'text' => 'Water, sewer, conduit and drain lines. Massachusetts treats a trench deeper than three feet as permitted work under 520 CMR 14.00, so the town trench permit is part of the schedule.'],
    ['icon' => 'droplets', 'title' => 'Water in the wrong place',
     'text' => 'Water pooling against a foundation or across a driveway usually comes down to grade. The fix starts with finding where the water comes from, then regrading or adding a drain line.'],
    ['icon' => 'mountain', 'title' => 'Site prep and grading',
     'text' => 'Stripping and stockpiling topsoil, cutting and filling to the planned elevations, then spreading loam back at final grade so the lot sheds water.'],
];

$exWeek = [
    ['day' => 'Thu', 'note' => 'Request placed, 9 am', 'state' => 'start'],
    ['day' => 'Fri', 'note' => '24 hours', 'state' => 'count'],
    ['day' => 'Sat', 'note' => 'Not counted', 'state' => 'skip'],
    ['day' => 'Sun', 'note' => 'Not counted', 'state' => 'skip'],
    ['day' => 'Mon', 'note' => '48 hours', 'state' => 'count'],
    ['day' => 'Tue', 'note' => '72 hours: dig', 'state' => 'go'],
];

$exMarks = [
    ['red', 'Electric'], ['yellow', 'Gas and oil'], ['orange', 'Communications'],
    ['blue', 'Drinking water'], ['green', 'Sewer and drain'], ['white', 'Proposed dig area'],
];

$exGround = [
    ['Sand and gravel', 'Drains well and digs quickly, but trench walls slough as the cut gets deeper.', 'Wider, sloped cuts or a trench box; little or no dewatering.'],
    ['Clay and old fill', 'Holds water. Old fill can hide debris, stumps or the remains of earlier structures.', 'Hauling the material away and bringing in fill that compacts; drainage work.'],
    ['Ledge and boulders', 'Bedrock or large stones at or near the depth the plan calls for.', 'Different equipment for breaking or removing rock, and more machine hours.'],
    ['High groundwater or nearby wetlands', 'Water seeps into the hole; the lot may sit in a wetland buffer zone.', 'Dewatering, and Conservation Commission review before work is scheduled.'],
];

$exRelated = ['septic-system-installation', 'helical-piers', 'sea-walls'];
$exCards = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Site Construction / Excavation — page composition (tokens only).
   Motif: cut-and-fill. A hatched earth band under the hero, a grade line,
   and a Dig Safe week strip as the signature section.
   ========================================================================== */
.ex { --ex-hatch: color-mix(in srgb, var(--color-white) 7%, transparent); --ex-earth: color-mix(in srgb, var(--color-accent) 28%, var(--color-dark)); }
.ex h1, .ex h2, .ex h3 { text-wrap: balance; }
.ex p { text-wrap: pretty; }

/* ---- Hero: layered (radial ::before, noise ::after, hatched earth band) ---- */
.ex-hero { padding-bottom: calc(clamp(2rem, 4vw, 3rem) + var(--space-2xl)); }
.ex-hero::before {
  content: ""; position: absolute; inset: -20% -10% auto 45%; height: 140%; z-index: -1; pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 26%, transparent), transparent 72%);
}
.ex-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .32; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.ex-hero__earth {
  position: absolute; inset: auto 0 0 0; height: var(--space-2xl); z-index: -1; pointer-events: none;
  background: repeating-linear-gradient(135deg, var(--ex-hatch) 0 2px, transparent 2px 12px), var(--ex-earth);
  border-top: 3px dashed color-mix(in srgb, var(--color-accent-bright) 70%, transparent);
}
.ex-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.ex-hero .breadcrumb a:hover { color: var(--color-white); }
.ex-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.ex-hero .text-accent { color: var(--color-accent-bright); }
.ex-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.ex-hero .link-call svg { color: var(--color-accent-bright); }
.ex-hero .link-call:hover { color: var(--color-white); }
.ex-hero .hero-form-open { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-ink); }
.ex-hero .hero-form-open:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.ex-hero .hero-title { max-width: 18ch; }
.ex-hero .hero-answer { max-width: 36rem; }
.ex-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 8%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.ex-hero .hero-chips svg { color: var(--color-accent-bright); }
.ex-hero .hero-form-card { border-top: 4px solid var(--color-accent); }
.ex-hero .hero-form .consent a { color: var(--color-primary); }
.ex-hero .form-row--pair { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); }
.ex-hero .form-row--pair .form-row + .form-row { margin-top: 0; }

/* ---- Signs: pull-quote column + bento of job types ---- */
.ex-signs { background: var(--color-paper); }
.ex-signs__grid { display: grid; grid-template-columns: minmax(0, .95fr) minmax(0, 1.25fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.ex-signs__intro { display: grid; gap: var(--space-md); }
.ex-signs__intro .answer-block { margin: 0; }
.ex-quote { margin: var(--space-md) 0 0; padding: var(--space-lg) 0 0; border-top: 2px solid var(--color-ink); }
.ex-quote p { font-family: var(--font-heading); font-weight: 700; font-size: clamp(1.4rem, 1rem + 1.6vw, 2.1rem); line-height: 1.2; color: var(--color-ink); margin: 0; }
.ex-quote p::before { content: "“"; color: var(--color-accent-dark); }
.ex-quote p::after { content: "”"; color: var(--color-accent-dark); }
.ex-bento { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ex-bento li { position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.ex-bento li:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.ex-bento li:first-child { grid-row: span 2; background: linear-gradient(165deg, var(--color-dark) 0%, var(--color-dark-alt) 75%, var(--color-primary-deep) 130%); color: var(--color-white); border-color: transparent; align-content: end; min-height: 18rem; overflow: hidden; isolation: isolate; }
.ex-bento li:first-child::before { content: ""; position: absolute; inset: 0; z-index: -1; background: repeating-linear-gradient(0deg, transparent 0 22px, var(--ex-hatch) 22px 23px); }
.ex-bento li:first-child h3 { color: var(--color-white); font-size: var(--fs-h3); }
.ex-bento li:first-child p { color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.ex-bento li:first-child svg { color: var(--color-accent-bright); }
.ex-bento svg { color: var(--color-accent-dark); }
.ex-bento h3 { font-size: var(--font-size-lg); }
.ex-bento p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Signature: Dig Safe week strip on a dark band ---- */
.ex-digsafe .ex-digsafe__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.ex-digsafe__stat { display: grid; gap: var(--space-sm); }
.ex-digsafe__big { font-family: var(--font-accent); font-weight: 700; font-size: clamp(4rem, 2.5rem + 6vw, 7.5rem); line-height: .85; letter-spacing: -.01em; color: var(--color-white); }
.ex-digsafe__big span { color: var(--color-accent-bright); font-size: .4em; letter-spacing: .08em; text-transform: uppercase; margin-left: var(--space-xs); }
.ex-digsafe .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.ex-week { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.ex-week li { display: grid; gap: var(--space-1); align-content: start; min-height: 7.5rem; padding: var(--space-md) var(--space-sm); border-radius: var(--radius); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); background: color-mix(in srgb, var(--color-white) 5%, transparent); }
.ex-week b { font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .08em; text-transform: uppercase; color: var(--color-white); }
.ex-week span { font-size: var(--font-size-xs); line-height: 1.35; color: color-mix(in srgb, var(--color-white) 76%, transparent); }
.ex-week .is-skip { background: repeating-linear-gradient(135deg, transparent 0 6px, var(--ex-hatch) 6px 8px); border-style: dashed; }
.ex-week .is-skip b { color: color-mix(in srgb, var(--color-white) 55%, transparent); }
.ex-week .is-start { border-color: var(--color-accent-bright); }
.ex-week .is-go { background: var(--color-accent); border-color: var(--color-accent); box-shadow: var(--shadow-lg); }
.ex-week .is-go b, .ex-week .is-go span { color: var(--color-ink); font-weight: 600; }
.ex-digsafe__body { display: grid; gap: var(--space-md); margin-top: var(--space-2xl); grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); align-items: start; }
.ex-digsafe__body p { margin: 0; }
.ex-marks { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.ex-marks li { display: inline-flex; align-items: center; gap: var(--space-xs); padding: var(--space-1) var(--space-sm); border-radius: var(--radius-full); font-size: var(--font-size-xs); font-weight: 600; letter-spacing: .02em; color: var(--color-white); border: 1px solid color-mix(in srgb, var(--color-white) 18%, transparent); }
.ex-marks i { width: .8rem; height: .8rem; border-radius: var(--radius-full); box-shadow: 0 0 0 2px color-mix(in srgb, var(--color-white) 20%, transparent); }
.ex-marks .m-red { background: var(--color-danger); } .ex-marks .m-yellow { background: var(--color-star); }
.ex-marks .m-orange { background: var(--color-accent); } .ex-marks .m-blue { background: var(--color-info); }
.ex-marks .m-green { background: var(--color-success); } .ex-marks .m-white { background: var(--color-white); }
.ex-digsafe__caption { font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 65%, transparent); }

/* ---- Scope + sticky process ---- */
.ex-scope { background: var(--color-surface); }
.ex-scope__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.ex-scope__intro { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); display: grid; gap: var(--space-md); }
.ex-scope__intro .answer-block { margin: 0; }
.ex-checklist { display: grid; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.ex-checklist li { display: grid; grid-template-columns: 1.4rem 1fr; gap: var(--space-sm); font-size: var(--fs-small); color: var(--color-ink-2); }
.ex-checklist svg { color: var(--color-success); margin-top: var(--space-1); }
.ex-steps { counter-reset: exstep; display: grid; gap: 0; margin: 0; padding: 0; list-style: none; border-left: 2px solid var(--color-line); }
.ex-steps li { counter-increment: exstep; position: relative; padding: 0 0 var(--space-2xl) var(--space-2xl); }
.ex-steps li:last-child { padding-bottom: 0; }
.ex-steps li::before { content: counter(exstep, decimal-leading-zero); position: absolute; left: calc(-1 * var(--space-lg) - 1px); top: 0; width: var(--space-2xl); height: var(--space-2xl); display: grid; place-items: center; font-family: var(--font-accent); font-size: var(--font-size-lg); color: var(--color-white); background: var(--color-dark); border-radius: var(--radius-full); box-shadow: 0 0 0 6px var(--color-surface); }
.ex-steps li:last-child::before { background: var(--color-accent); color: var(--color-ink); }
.ex-steps h3 { font-size: var(--fs-h3); margin-bottom: var(--space-xs); padding-top: var(--space-xs); }
.ex-steps p { margin: 0; color: var(--color-ink-2); }
.ex-steps p + p { margin-top: var(--space-xs); }
.ex-scope__links { margin: var(--space-2xl) 0 0; padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-paper); border: 1px dashed var(--color-line); }
.ex-scope__links a { color: var(--color-accent-dark); font-weight: 600; text-underline-offset: .15em; text-decoration: underline; }

/* ---- Ground conditions table ---- */
.ex-ground { background: var(--color-paper-2); }
.ex-ground .section-head { max-width: 68ch; }
.ex-ground .answer-block { background: var(--color-surface); margin: 0; }
.ex-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); background: var(--color-surface); }
.ex-table { width: 100%; min-width: 640px; border-collapse: collapse; font-size: var(--fs-small); }
.ex-table caption { caption-side: bottom; text-align: left; padding: var(--space-sm) var(--space-lg); font-size: var(--font-size-xs); color: var(--color-muted); }
.ex-table th, .ex-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; border-bottom: 1px solid var(--color-line); }
.ex-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-white); background: var(--color-dark); }
.ex-table tbody th { font-family: var(--font-heading); font-weight: 800; color: var(--color-ink); width: 22%; border-left: 4px solid var(--color-accent); }
.ex-table tbody tr:nth-child(even) { background: var(--color-paper); }
.ex-table td { color: var(--color-ink-2); line-height: 1.55; }
.ex-ground__note { margin: var(--space-lg) 0 0; max-width: 68ch; color: var(--color-ink-2); }

/* ---- FAQ ---- */
.ex-faq { background: var(--color-paper); }
.ex-faq .answer-block { margin-bottom: var(--space-lg); }
.ex-faq .faq summary { min-height: 44px; }
.ex-faq .faq[open] summary { color: var(--color-accent-dark); }

.ex-hero .hero-bg img { object-position: 50% 55%; }

/* ---- Photo strip (three registry photos) ---- */
.ex-photos { background: var(--color-surface); }
.ex-photos__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.ex-photos__intro { display: grid; gap: var(--space-md); }
.ex-photos__intro .answer-block { margin: 0; background: var(--color-paper); }
.ex-photos .sp-gallery-grid { margin: 0; }
.ex-photos .sp-gallery-item { box-shadow: var(--shadow); }
@media (max-width: 1000px) { .ex-photos__grid { grid-template-columns: 1fr; } }

/* ---- Other services ---- */
.ex-related { background: var(--color-surface); }
.ex-related .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.ex-related .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.ex-related .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow); }
.ex-related__more { margin-top: var(--space-xl); }

/* ---- Closing CTA ---- */
.ex-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.ex-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.ex-cta .link-call svg { color: var(--color-accent-bright); }
.ex-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.ex-cta .floating-ring { right: -6rem; top: -5rem; opacity: .12; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .ex-signs__grid, .ex-scope__grid, .ex-digsafe .ex-digsafe__grid, .ex-digsafe__body { grid-template-columns: 1fr; }
  .ex-scope__intro { position: static; }
  .ex-week { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}
@media (max-width: 900px) {
  .ex-related .services-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
  .ex-bento { grid-template-columns: 1fr; }
  .ex-bento li:first-child { grid-row: auto; min-height: 0; }
  .ex-steps li { padding-left: var(--space-xl); }
  .ex-hero .form-row--pair { grid-template-columns: 1fr; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="ex">

<!-- ============ HERO (interior, compact form card) ============ -->
<section class="hero hero--interior hero--photo ex-hero" aria-labelledby="ex-hero-title">
  <div class="hero-bg"><?php echo photoPicture($exHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <span class="ex-hero__earth" aria-hidden="true"></span>
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
        <span class="eyebrow">Site Construction · Plymouth, MA</span>
        <h1 class="hero-title" id="ex-hero-title"><span class="text-accent">Site construction</span> and excavation in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services is an excavation contractor based in Plymouth, MA that digs, grades and prepares sites for homes and businesses. Every job starts with a site visit to check soil, ledge, access and wetlands, then a written estimate before any machine moves.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($exTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('clipboard-list', 16); ?>Written estimate first</li>
          <li><?php icon('map-pin', 16); ?>Dig Safe before digging</li>
          <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need an excavation estimate?</h2>
        <p class="hero-form-tagline">Send the address and the job. We call back to set up a site visit.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row form-row--pair">
            <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
            <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          </div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($svc['name']); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Send my request</button>
        </form>
        <p class="form-footnote">Office hours <?php echo h($businessHours); ?>.</p>
      </aside>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<article class="ex-article" aria-labelledby="ex-hero-title">

<!-- ============ WHEN YOU NEED IT (pull-quote + bento) ============ -->
<section class="section ex-signs" aria-labelledby="ex-signs-title">
  <div class="container">
    <div class="ex-signs__grid">
      <div class="ex-signs__intro reveal-left">
        <span class="eyebrow-label">When to call</span>
        <h2 id="ex-signs-title">When does a Plymouth property need <span class="text-accent">site excavation</span>?</h2>
        <p class="answer-block">A Plymouth property needs site excavation when the ground must change before something is built, drained or connected. That covers new foundations and additions, utility and sewer lines, and water that collects in the wrong place. The dig sets the grade, the drainage and the base for everything above it.</p>
        <blockquote class="ex-quote"><p>The price of a dig is mostly decided below the topsoil.</p></blockquote>
      </div>
      <ul class="ex-bento" aria-label="Common excavation jobs">
<?php foreach ($exSigns as $exI => $exSign): ?>
        <li class="reveal-up reveal-delay-<?php echo ($exI % 3) + 1; ?>"><?php icon($exSign['icon'], 26); ?><h3><?php echo h($exSign['title']); ?></h3><p><?php echo h($exSign['text']); ?></p></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: Dig Safe week (dark band) ============ -->
<section class="section texture-grain slant-top ex-digsafe" aria-labelledby="ex-digsafe-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="ex-digsafe__grid">
      <div class="ex-digsafe__stat reveal-left">
        <span class="eyebrow-label">Dig Safe</span>
        <div class="ex-digsafe__big" aria-hidden="true">72<span>hours</span></div>
        <h2 id="ex-digsafe-title">How long does Dig Safe take before digging can start in Plymouth?</h2>
        <p class="answer-block">Dig Safe needs at least 72 hours' notice before excavation in Massachusetts, and weekends and legal holidays do not count. A request placed Thursday morning clears the following Tuesday morning, so BDPM Site Services builds that wait into the schedule from the first conversation.</p>
      </div>
      <ol class="ex-week reveal-right" aria-label="Example: a Dig Safe request placed on a Thursday">
<?php foreach ($exWeek as $exDay): ?>
        <li class="is-<?php echo h($exDay['state']); ?>"><b><?php echo h($exDay['day']); ?></b><span><?php echo h($exDay['note']); ?></span></li>
<?php endforeach; ?>
      </ol>
    </div>
    <div class="ex-digsafe__body">
      <div class="reveal-up">
        <p>Dig Safe passes the request to its member utilities, and each one marks its own lines with paint or flags in the standard color code. Private lines are not part of that system: a power feed to a detached garage, an irrigation line, a gas line to a pool heater or the pipe from a house to its septic tank. Tell us about those at the site visit so they are found before the bucket is.</p>
      </div>
      <div class="reveal-up reveal-delay-2">
        <ul class="ex-marks" aria-label="Utility marking colors">
<?php foreach ($exMarks as $exMark): ?>
          <li><i class="m-<?php echo h($exMark[0]); ?>" aria-hidden="true"></i><?php echo h(ucfirst($exMark[0]) . ': ' . $exMark[1]); ?></li>
<?php endforeach; ?>
        </ul>
        <p class="ex-digsafe__caption">Dig Safe: call 811 or 1-888-344-7233.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ WHAT'S INCLUDED + PROCESS ============ -->
<section class="section edge-curve-top ex-scope" aria-labelledby="ex-scope-title">
  <div class="container">
    <div class="ex-scope__grid">
      <div class="ex-scope__intro reveal-left">
        <span class="eyebrow-label">Scope and process</span>
        <h2 id="ex-scope-title">What's included in a BDPM Site Services <span class="text-accent">excavation job</span>?</h2>
        <p class="answer-block">A BDPM Site Services excavation job covers the site visit, a written estimate, Dig Safe and permit timing, the excavation, backfill and final grade. You get the scope, price and schedule in writing before the work is booked, and the estimate is built on what the site visit actually found.</p>
        <ul class="ex-checklist">
          <li><?php icon('check-circle', 18); ?><span>Site visit covering soil, ledge, access, wetlands and where water runs</span></li>
          <li><?php icon('check-circle', 18); ?><span>Written scope, price and schedule</span></li>
          <li><?php icon('check-circle', 18); ?><span>Dig Safe request and markings confirmed before digging</span></li>
          <li><?php icon('check-circle', 18); ?><span>Topsoil stripped and stockpiled for reuse</span></li>
          <li><?php icon('check-circle', 18); ?><span>Excavation to the depths and elevations on the plan</span></li>
          <li><?php icon('check-circle', 18); ?><span>Backfill, then final grade pitched away from the building</span></li>
        </ul>
      </div>

      <div>
        <ol class="ex-steps">
          <li class="reveal-up">
            <h3>Site visit</h3>
            <p>We walk the property with you and look at what decides the price: the soil, any exposed ledge, how a machine gets in, nearby wetlands or water, and where runoff goes now.</p>
          </li>
          <li class="reveal-up">
            <h3>Written estimate</h3>
            <p>The scope, price and schedule go down in writing, including what happens to the excavated material: reused on site, spread at final grade or hauled away.</p>
          </li>
          <li class="reveal-up">
            <h3>Dig Safe and approvals</h3>
            <p>Utility lines are marked through Dig Safe. Work near wetlands may need Plymouth Conservation Commission review first, and a trench deeper than three feet needs a town trench permit under 520 CMR 14.00.</p>
            <p>Federal OSHA rules require sloping, shoring or a trench box once a trench reaches five feet, so the depth on the plan also sets how wide the dig has to be.</p>
          </li>
          <li class="reveal-up">
            <h3>Dig, backfill, grade</h3>
            <p>The excavation follows the plan's depths and elevations, inspections happen where the permit requires them, and the site is backfilled and left at final grade with the stockpiled loam spread back.</p>
          </li>
        </ol>
        <p class="ex-scope__links reveal-up">Excavation is often the first trade on a bigger job. On a lot without town sewer, the same crew can carry the work into <a href="/services/septic-system-installation/">septic system installation in Plymouth</a>, and where the soil under an addition is too loose for a standard footing, <a href="/services/helical-piers/">helical pier foundations</a> can carry the load instead.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ PHOTOS (three registry photos) ============ -->
<section class="section ex-photos" aria-labelledby="ex-photos-title">
  <div class="container-wide">
    <div class="ex-photos__grid">
      <div class="ex-photos__intro reveal-left">
        <span class="eyebrow-label">On the job</span>
        <h2 id="ex-photos-title">What does a BDPM Site Services <span class="text-accent">excavation job</span> look like?</h2>
        <p class="answer-block">BDPM Site Services excavation work in Plymouth runs from the open foundation hole to the formwork that goes in it. These photos show a foundation dig with the crew in the excavation, footing forms with rebar set before the pour, and a crew checking a crane lift on site.</p>
      </div>
      <div class="sp-gallery-grid reveal-right">
      <figure class="sp-gallery-item reveal-up reveal-delay-1"><?php echo photoPicture('excavator-foundation-dig-worker-plymouth', '(max-width: 700px) 92vw, 520px'); ?><figcaption>Foundation dig with the crew in the hole</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-2"><?php echo photoPicture('foundation-formwork-rebar-site-construction', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Footing formwork and rebar before the pour</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-3"><?php echo photoPicture('site-crew-inspecting-crane-lift', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Checking the lift plan on site</figcaption></figure>
      </div>
    </div>
  </div>
</section>

<!-- ============ GROUND CONDITIONS (comparison table) ============ -->
<section class="section ex-ground" aria-labelledby="ex-ground-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Plymouth ground</span>
      <h2 id="ex-ground-title">How do Plymouth soil conditions change an excavation estimate?</h2>
      <p class="answer-block">Soil type changes an excavation estimate more than almost anything else on a Plymouth lot. Sand digs fast but needs sloped or shored walls, clay and old fill may have to leave the site, and ledge calls for different equipment and more machine hours than the same hole in sand.</p>
    </div>
    <div class="ex-table-wrap reveal-up">
      <table class="ex-table">
        <caption>Conditions vary lot to lot; the site visit decides which apply.</caption>
        <thead>
          <tr><th scope="col">Ground condition</th><th scope="col">What it means in the hole</th><th scope="col">What it changes in the estimate</th></tr>
        </thead>
        <tbody>
<?php foreach ($exGround as $exRow): ?>
          <tr><th scope="row"><?php echo h($exRow[0]); ?></th><td><?php echo h($exRow[1]); ?></td><td><?php echo h($exRow[2]); ?></td></tr>
<?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="ex-ground__note reveal-up">Much of Plymouth, including the pine barrens around Myles Standish State Forest, sits on sandy glacial outwash. Closer to the coast and on lots that were built up decades ago, the same depth can turn up clay, buried fill or boulders, which is why the estimate waits for the site visit.</p>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$exReviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($exReviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $exReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section ex-faq" aria-labelledby="ex-faq-title">
  <div class="container-narrow">
    <span class="eyebrow-label">Questions</span>
    <h2 id="ex-faq-title">What do Plymouth property owners ask before an excavation starts?</h2>
    <p class="answer-block">Plymouth property owners most often ask BDPM Site Services two things before an excavation starts: whether Dig Safe has to be called first, and what drives the cost. Both answers are below, and the estimate visit covers anything specific to your lot.</p>
<?php foreach ($exFaqs as $exFaqI => $exFaq): ?>
    <details class="faq reveal-up"<?php echo $exFaqI === 0 ? ' open' : ''; ?>>
      <summary><?php echo h($exFaq['q']); ?></summary>
      <p class="faq-answer"><?php echo h($exFaq['a']); ?></p>
    </details>
<?php endforeach; ?>
  </div>
</section>

<!-- ============ OTHER SERVICES (required services component, 3 cards) ============ -->
<section class="section edge-wave-top ex-related" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What other ground work can <span class="text-accent">BDPM Site Services</span> do on the same lot?</h2>
      <p class="hero-answer">Excavation is often the first step of a bigger job. BDPM Site Services also installs septic systems, sets helical piers, builds sea walls and performs Title 5 inspections in Plymouth, so the work below grade can run as one project on one schedule with the same crew.</p>
    </div>
    <div class="services-grid">
<?php foreach ($exRelated as $exRelI => $exRelSlug):
    $exRelSvc = serviceBySlug($exRelSlug);
    $exRelCard = $exCards[$exRelSlug]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($exRelI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($exRelI % 3) + 1; ?>">
        <div class="service-card__image"><?php echo photoPicture($exRelCard['photo'], '(max-width: 900px) 92vw, 380px'); ?></div>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($exRelCard['icon'], 26); ?></div>
          <h3><?php echo h($exRelSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($exRelCard['desc']); ?></p>
          <ul>
<?php foreach ($exRelCard['bullets'] as $exBullet): ?>
            <li><?php echo h($exBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($exRelSlug); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($exRelSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <p class="ex-related__more reveal-up"><a class="btn btn-secondary" href="/services/">See all five Plymouth services</a></p>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-torn-top ex-cta" aria-labelledby="ex-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="ex-cta-title">Ready for a free excavation estimate in Plymouth?</h2>
      <p>Tell us the address and what you are building. BDPM Site Services will set up a site visit and send a written estimate with the scope, price and schedule.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free excavation estimate</button>
      <a class="link-call" href="<?php echo h($exTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
