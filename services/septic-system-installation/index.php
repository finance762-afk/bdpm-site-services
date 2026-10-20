<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/septic-system-installation/ — Phase 4 service page (premium editorial structure, warm-human archetype).
 * Photos (2026-10-20): photo hero (.hero--photo, LCP preloaded), a three-photo .sp-gallery-grid strip and a registry photo on every
 * related-service card, all from includes/photos.php. The signature section is a CSS flow diagram of a Title 5 system.
 * Sources (checked 2026-10-19):
 *   110 gpd per bedroom design flow; bedrooms (not bathrooms) change flow — 310 CMR 15.203, https://www.mashpeema.gov/node/208926
 *   4 ft separation to high groundwater, 5 ft where perc rate ≤ 2 min/inch — 310 CMR 15.212
 *   Failed system upgrade within 2 years unless the Board of Health sets another schedule — https://www.mass.gov/info-details/re22rc25-title-5
 *   Plymouth sequence (Conservation Commission if applicable, RS/PE submits sewage application, Disposal Works permit,
 *   Certificate of Compliance), perc test application $350, permit pick-up $100 covering final + backfill inspection —
 *   https://plymouth-ma.gov/DocumentCenter/View/3825/BOH-Rules-and-Regulations, https://plymouth-ma.gov/m/faq?cat=32,
 *   https://plymouth-ma.gov/DocumentCenter/View/1936/permit_pick_up_acknowledgement_and_payment-PDF
 *   Plymouth new-construction septic guidelines effective June 26, 2019, no stricter than Title 5 —
 *   https://plymouth-ma.gov/DocumentCenter/View/1896/Title-5-New-Construction-Septic-Permit-Guidelines-PDF
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$svc             = serviceBySlug('septic-system-installation');
$pageTitle       = 'Septic System Installation Plymouth MA | BDPM Site Services';
$pageDescription = 'Septic system installation in Plymouth, MA, built to the approved Board of Health design, from soil test to backfill inspection. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/services/septic-system-installation/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'septic-system-installation';
$stHeroPhoto = 'septic-tanks-installed-pit-orange-pipe';
$heroPreload     = photoHeroPreload($stHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
    ['name' => $svc['name'], 'url' => '/services/septic-system-installation/'],
];

$stTel = formatPhone($phone, 'tel');

// FAQ — the septic question from research_brief.faqs, answered to match the service list (BDPM installs systems)
$stFaqs = [
    ['q' => 'Do you work on septic system excavation in Plymouth?',
     'a' => 'Yes. BDPM Site Services installs septic systems in Plymouth and does the excavation for them, working to the plan drawn by the septic designer and approved by the Plymouth Board of Health. Soil testing and the design itself are handled by licensed professionals, and the installation follows their plan and the town\'s inspection schedule.'],
];

$schemaMarkup = servicePageSchema($svc,
    'Septic system installation in Plymouth, MA: excavation, septic tank, distribution box and soil absorption system built to the Title 5 design approved by the Plymouth Board of Health, inspected before backfill.');

$stSigns = [
    ['icon' => 'clipboard-list', 'title' => 'A failed Title 5 inspection',
     'text' => 'A failed system generally has to be upgraded within two years, whether or not the house sells, unless the Board of Health sets a different schedule.'],
    ['icon' => 'home', 'title' => 'An added bedroom',
     'text' => 'Title 5 sizes a house system at 110 gallons per day per bedroom. An addition with a new bedroom raises the design flow; a new bathroom does not.'],
    ['icon' => 'building-2', 'title' => 'A new house without sewer',
     'text' => 'On an unsewered lot the house needs an approved system, installed, inspected and given a Certificate of Compliance before it is used.'],
    ['icon' => 'droplets', 'title' => 'Signs the field is done',
     'text' => 'Slow drains through the whole house, sewage odor outside, soggy or unusually green ground over the leach field, or backups after heavy use.'],
];

$stFlow = [
    ['icon' => 'home', 'name' => 'House', 'text' => 'Every drain in the house joins one building sewer pipe that runs out to the tank.'],
    ['icon' => 'layers', 'name' => 'Septic tank', 'text' => 'Solids settle to the bottom and grease and scum float, so only the clearer middle layer leaves.'],
    ['icon' => 'waypoints', 'name' => 'Distribution box', 'text' => 'A level box splits the flow evenly so every line of the field takes its share.'],
    ['icon' => 'sprout', 'name' => 'Soil absorption system', 'text' => 'Trenches, beds or chambers let the liquid soak into the soil, which does the final treatment.'],
];

$stSteps = [
    ['Perc test and soil evaluation', 'The application goes to Plymouth\'s health department with the town fee, listed at $350 on the town FAQ, and the office calls to schedule a date. Deep test holes and a percolation test show the soil and the high groundwater level the design must work with.'],
    ['Engineered design', 'A Registered Sanitarian or Professional Engineer draws the system to fit the soil results, the bedroom count and the setbacks, then submits the sewage application to the town.'],
    ['Approvals and permit', 'Conservation Commission approval comes first when the lot is near wetlands. The health department then issues the Disposal Works permit; the town lists a $100 pick-up fee that covers the backfill and final inspections.'],
    ['Installation', 'BDPM Site Services confirms the Dig Safe markings, excavates, sets the tank and distribution box, and builds the soil absorption system to the elevations on the approved plan.'],
    ['Inspection before backfill', 'The system is inspected while it is still open, so the town can confirm the tank, pipes and field match the plan before anything is covered.'],
    ['Backfill and Certificate of Compliance', 'Once it passes, the system is backfilled and graded. The Board of Health issues a Certificate of Compliance, and the system can go into use.'],
];

$stFactors = [
    ['Bedroom count', 'Sets the design flow: 110 gallons per day for each bedroom.', 'The Title 5 bedroom definition, applied by the designer'],
    ['Percolation rate', 'Decides how much leaching area the flow needs, and whether the field sits four or five feet above high groundwater.', 'The soil evaluation'],
    ['High groundwater', 'A high water table lifts the whole system, which can mean imported fill and a raised field.', 'The deep observation holes'],
    ['Wetlands and water nearby', 'Setbacks limit where the tank and field can go, and the work may need Conservation Commission approval.', 'The design and the Commission'],
    ['Lot slope and access', 'Where a machine can reach and where the field fits drive the excavation cost.', 'The site visit'],
];

$stRelated = ['title-5-inspections', 'site-construction-excavation', 'helical-piers'];
$stCards = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Septic System Installation — page composition (tokens only).
   Motif: the flow line. A pipe runs along the hero floor; the signature
   section is a four-stop flow diagram; the permit path is a 3x2 step grid.
   ========================================================================== */
.st { --st-pipe: color-mix(in srgb, var(--color-accent-bright) 75%, transparent); --st-soft: color-mix(in srgb, var(--color-white) 8%, transparent); }
.st h1, .st h2, .st h3 { text-wrap: balance; }
.st p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + pipe line ---- */
.st-hero::before {
  content: ""; position: absolute; inset: -30% 40% auto -15%; height: 150%; z-index: -1; pointer-events: none;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-secondary) 38%, transparent), transparent 70%);
}
.st-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='180' height='180'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.st-hero__pipe { position: absolute; left: 0; right: 0; bottom: var(--space-lg); height: var(--space-sm); z-index: -1; pointer-events: none; border-block: 2px solid var(--st-pipe); background: repeating-linear-gradient(90deg, transparent 0 46px, var(--st-pipe) 46px 50px); opacity: .45; }
.st-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.st-hero .breadcrumb a:hover { color: var(--color-white); }
.st-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.st-hero .text-accent { color: var(--color-accent-bright); }
.st-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.st-hero .link-call svg { color: var(--color-accent-bright); }
.st-hero .link-call:hover { color: var(--color-white); }
.st-hero .hero-form-open { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-ink); }
.st-hero .hero-form-open:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.st-hero .hero-title { max-width: 17ch; }
.st-hero .hero-chips li { background: var(--st-soft); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.st-hero .hero-chips svg { color: var(--color-accent-bright); }
.st-hero .hero-form-card { border-left: 4px solid var(--color-accent); }
.st-hero .hero-form .consent a { color: var(--color-primary); }
.st-hero .st-pair { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-xs); margin-top: var(--space-xs); }
.st-hero .st-pair .form-row + .form-row { margin-top: 0; }

/* ---- When you need one: asymmetric (bento left, intro right) ---- */
.st-signs { background: var(--color-paper); }
.st-signs__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.st-signs__intro { display: grid; gap: var(--space-md); order: 2; }
.st-signs__intro .answer-block { margin: 0; background: var(--color-surface); }
.st-pull { margin: var(--space-sm) 0 0; font-family: var(--font-heading); font-weight: 800; font-style: italic; font-size: clamp(1.5rem, 1rem + 2vw, 2.4rem); line-height: 1.12; color: var(--color-ink); max-width: 16ch; }
.st-pull span { color: var(--color-accent-dark); }
.st-cards { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.st-cards li { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.st-cards li:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.st-cards li:nth-child(1) { background: var(--color-card-tint-3); border-color: color-mix(in srgb, var(--color-accent) 30%, var(--color-line)); }
.st-cards li:nth-child(4) { background: var(--color-card-tint-2); }
.st-cards li:nth-child(even) { transform: translateY(var(--space-lg)); }
.st-cards li:nth-child(even):hover { transform: translateY(calc(var(--space-lg) - 3px)); }
.st-cards svg { color: var(--color-accent-dark); }
.st-cards h3 { font-size: var(--font-size-lg); }
.st-cards p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Signature: flow diagram on a dark band ---- */
.st-flow .section-head { max-width: 64ch; }
.st-flow .answer-block { background: var(--st-soft); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.st-diagram { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-xl); margin: var(--space-2xl) 0 0; padding: 0; list-style: none; position: relative; }
.st-diagram::before { content: ""; position: absolute; left: 6%; right: 6%; top: 2.25rem; height: 4px; border-radius: var(--radius-full); background: linear-gradient(90deg, var(--color-accent) 0%, var(--color-accent-bright) 60%, var(--color-success) 100%); opacity: .8; }
.st-diagram li { position: relative; display: grid; gap: var(--space-sm); justify-items: start; align-content: start; }
.st-diagram__node { position: relative; z-index: 1; width: 4.5rem; height: 4.5rem; border-radius: var(--radius-full); display: grid; place-items: center; background: var(--color-dark); border: 3px solid var(--color-accent-bright); color: var(--color-white); box-shadow: 0 0 0 8px color-mix(in srgb, var(--color-dark) 85%, transparent); }
.st-diagram li:last-child .st-diagram__node { border-color: var(--color-success); }
.st-diagram__node svg { width: 28px; height: 28px; }
.st-diagram b { font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .08em; text-transform: uppercase; color: var(--color-white); }
.st-diagram p { margin: 0; font-size: var(--fs-small); line-height: 1.55; }
.st-separation { display: grid; grid-template-columns: auto minmax(0, 1fr); gap: var(--space-lg); align-items: center; margin-top: var(--space-2xl); padding: var(--space-lg) var(--space-xl); border: 1px dashed color-mix(in srgb, var(--color-white) 24%, transparent); border-radius: var(--radius-lg); }
.st-separation__num { font-family: var(--font-accent); font-weight: 700; font-size: clamp(2.6rem, 2rem + 2.5vw, 4rem); line-height: .9; color: var(--color-accent-bright); }
.st-separation__num small { display: block; font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-top: var(--space-1); }
.st-separation p { margin: 0; }

/* ---- Permit path: 3x2 step grid ---- */
.st-path { background: var(--color-surface); }
.st-path__head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: end; margin-bottom: var(--space-2xl); }
.st-path__head .answer-block { margin: 0; }
.st-path__head h2 { max-width: 22ch; }
.st-grid { counter-reset: ststep; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.st-grid li { counter-increment: ststep; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: calc(var(--space-2xl) + var(--space-sm)) var(--space-lg) var(--space-lg); border-radius: var(--radius-lg); background: var(--color-paper); border: 1px solid var(--color-line); overflow: hidden; }
.st-grid li::before { content: counter(ststep); position: absolute; top: var(--space-md); left: var(--space-lg); font-family: var(--font-accent); font-weight: 700; font-size: var(--font-size-xl); color: var(--color-accent-dark); }
.st-grid li::after { content: counter(ststep); position: absolute; right: calc(-1 * var(--space-xs)); bottom: calc(-1 * var(--space-xl)); font-family: var(--font-accent); font-weight: 700; font-size: 7rem; line-height: 1; color: var(--color-ink); opacity: .05; pointer-events: none; }
.st-grid li.is-ours { background: var(--color-dark); border-color: transparent; color: var(--color-white); box-shadow: var(--shadow-lg); }
.st-grid li.is-ours h3 { color: var(--color-white); }
.st-grid li.is-ours p { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.st-grid li.is-ours::before { color: var(--color-accent-bright); }
.st-grid li.is-ours::after { color: var(--color-white); opacity: .08; }
.st-grid h3 { font-size: var(--font-size-lg); }
.st-grid p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }
.st-path__note { margin: var(--space-xl) 0 0; max-width: 70ch; color: var(--color-ink-2); font-size: var(--fs-small); }
.st-path__note a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }

/* ---- Sizing: table + flow chips ---- */
.st-size { background: var(--color-paper-2); }
.st-size__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.6fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.st-size__intro { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.st-size__intro .answer-block { margin: 0; background: var(--color-surface); }
.st-flows { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.st-flows li { display: grid; gap: var(--space-1); padding: var(--space-md); border-radius: var(--radius); background: var(--color-surface); border: 1px solid var(--color-line); text-align: center; }
.st-flows b { font-family: var(--font-accent); font-size: var(--fs-h2); line-height: 1; color: var(--color-ink); }
.st-flows span { font-size: var(--font-size-xs); color: var(--color-muted); }
.st-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); box-shadow: var(--shadow); }
.st-table { width: 100%; min-width: 600px; border-collapse: separate; border-spacing: 0; font-size: var(--fs-small); }
.st-table caption { caption-side: top; text-align: left; padding: var(--space-md) var(--space-lg); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); border-bottom: 1px solid var(--color-line); }
.st-table th, .st-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; }
.st-table thead th { font-weight: 700; color: var(--color-ink); background: var(--color-card-tint-1); border-bottom: 2px solid var(--color-ink); }
.st-table tbody th { font-family: var(--font-heading); font-weight: 800; color: var(--color-ink); white-space: nowrap; }
.st-table tbody tr + tr > * { border-top: 1px solid var(--color-line); }
.st-table td { color: var(--color-ink-2); line-height: 1.55; }
.st-table td:last-child { color: var(--color-muted); font-style: italic; }

/* ---- FAQ ---- */
.st-faq { background: var(--color-surface); }
.st-faq__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: start; }
.st-faq .answer-block { margin: 0; }
.st-faq .faq { border-top: 2px solid var(--color-ink); }
.st-faq .faq summary { min-height: 44px; }

.st-hero .hero-bg img { object-position: 50% 55%; }

/* ---- Photo strip (three registry photos) ---- */
.st-photos { background: var(--color-surface); }
.st-photos__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.st-photos__intro { display: grid; gap: var(--space-md); }
.st-photos__intro .answer-block { margin: 0; background: var(--color-paper); }
.st-photos .sp-gallery-grid { margin: 0; }
.st-photos .sp-gallery-item { box-shadow: var(--shadow); }
@media (max-width: 1000px) { .st-photos__grid { grid-template-columns: 1fr; } }

/* ---- Other services ---- */
.st-related { background: var(--color-paper); }
.st-related .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.st-related .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.st-related .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius-full); background: var(--color-dark); color: var(--color-white); }
.st-related__more { margin-top: var(--space-xl); }

/* ---- Closing CTA ---- */
.st-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.st-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.st-cta .link-call svg { color: var(--color-accent-bright); }
.st-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.st-cta .floating-ring { left: -7rem; bottom: -8rem; opacity: .1; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .st-signs__grid, .st-path__head, .st-size__grid, .st-faq__grid { grid-template-columns: 1fr; }
  .st-signs__intro { order: 0; }
  .st-size__intro { position: static; }
  .st-diagram { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .st-diagram::before { display: none; }
  .st-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 900px) { .st-related .services-grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) {
  .st-cards, .st-diagram, .st-grid { grid-template-columns: 1fr; }
  .st-cards li:nth-child(even) { transform: none; }
  .st-separation { grid-template-columns: 1fr; }
  .st-hero .st-pair { grid-template-columns: 1fr; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="st">

<!-- ============ HERO (interior, compact form card) ============ -->
<section class="hero hero--interior hero--photo st-hero" aria-labelledby="st-hero-title">
  <div class="hero-bg"><?php echo photoPicture($stHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <span class="st-hero__pipe" aria-hidden="true"></span>
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
        <span class="eyebrow">Septic Systems · Plymouth, MA</span>
        <h1 class="hero-title" id="st-hero-title"><span class="text-accent">Septic system installation</span> in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services, an excavation contractor based in Plymouth, installs septic systems to the design approved by the town's Board of Health, from the first trench to the final backfill. The dig is planned around the soil test results, the required inspections and the lot's grade.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($stTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('pencil-ruler', 16); ?>Built to the approved plan</li>
          <li><?php icon('search', 16); ?>Inspected before backfill</li>
          <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a septic installation estimate?</h2>
        <p class="hero-form-tagline">Have the approved plan? Mention it and we will price to it.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="st-pair">
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

<article class="st-article" aria-labelledby="st-hero-title">

<!-- ============ WHEN YOU NEED ONE (bento left, intro right) ============ -->
<section class="section st-signs" aria-labelledby="st-signs-title">
  <div class="container">
    <div class="st-signs__grid">
      <div class="st-signs__intro reveal-right">
        <span class="eyebrow-label">When to call</span>
        <h2 id="st-signs-title">When does a Plymouth home need a new <span class="text-accent">septic system</span>?</h2>
        <p class="answer-block">A Plymouth home needs a new septic system when a failed Title 5 inspection, new construction or a growing household outstrips the old one. On a lot without town sewer, each case starts the same way: soil testing, then an engineered design that the Board of Health approves before any digging.</p>
        <p class="st-pull">Title 5 counts <span>bedrooms</span>, not bathrooms.</p>
      </div>
      <ul class="st-cards reveal-left" aria-label="Reasons a septic system is installed">
<?php foreach ($stSigns as $stSign): ?>
        <li><?php icon($stSign['icon'], 26); ?><h3><?php echo h($stSign['title']); ?></h3><p><?php echo h($stSign['text']); ?></p></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: how the system works (dark band, flow diagram) ============ -->
<section class="section texture-grain edge-parallelogram-top st-flow" aria-labelledby="st-flow-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">How it works</span>
      <h2 id="st-flow-title">How does a Title 5 septic system work?</h2>
      <p class="answer-block">A Title 5 septic system carries household wastewater to a septic tank, where solids settle and scum floats. The clearer liquid flows to a distribution box that splits it evenly across a soil absorption system, and the soil beneath it finishes the treatment before the water reaches groundwater.</p>
    </div>
    <ol class="st-diagram" aria-label="Path of wastewater through a septic system">
<?php foreach ($stFlow as $stI => $stStop): ?>
      <li class="reveal-up reveal-delay-<?php echo $stI + 1; ?>">
        <span class="st-diagram__node"><?php icon($stStop['icon'], 28); ?></span>
        <b><?php echo h($stStop['name']); ?></b>
        <p><?php echo h($stStop['text']); ?></p>
      </li>
<?php endforeach; ?>
    </ol>
    <div class="st-separation reveal-up">
      <div class="st-separation__num">4–5 ft<small>to high groundwater</small></div>
      <p>Title 5 sets the bottom of the soil absorption system at least four feet above the high groundwater level, and five feet where the soil percolates at two minutes per inch or faster. Fast-draining sandy soil is common in Plymouth, so that five-foot figure, and the fill it can call for, often shapes the design and the excavation.</p>
    </div>
  </div>
</section>

<!-- ============ PERMIT PATH (3x2 grid) ============ -->
<section class="section st-path" aria-labelledby="st-path-title">
  <div class="container-wide">
    <div class="st-path__head reveal-up">
      <div>
        <span class="eyebrow-label">Plymouth permit path</span>
        <h2 id="st-path-title">What has to happen before a septic system goes in on a Plymouth lot?</h2>
      </div>
      <p class="answer-block">A Plymouth septic system needs a soil test, an engineered design and a town permit before installation starts. A Registered Sanitarian or Professional Engineer submits the design, the health department issues the Disposal Works permit, and the installed system is inspected before it is backfilled.</p>
    </div>
    <ol class="st-grid">
<?php foreach ($stSteps as $stStepI => $stStep): ?>
      <li class="reveal-up reveal-delay-<?php echo ($stStepI % 3) + 1; ?><?php echo $stStepI === 3 ? ' is-ours' : ''; ?>"><h3><?php echo h($stStep[0]); ?></h3><p><?php echo h($stStep[1]); ?></p></li>
<?php endforeach; ?>
    </ol>
    <p class="st-path__note reveal-up">Plymouth's own new-construction septic guidelines, in effect since June 26, 2019, follow Title 5 without adding a stricter standard. Fees and steps can change, so confirm current amounts with the health department. If the new system follows a failed inspection, start with <a href="/services/title-5-inspections/">Title 5 inspections in Plymouth</a>; if the tank and field sit on a lot that also needs a driveway, grading or drainage, the same crew handles the <a href="/services/site-construction-excavation/">site excavation and grading</a>.</p>
  </div>
</section>

<!-- ============ PHOTOS (three registry photos) ============ -->
<section class="section st-photos" aria-labelledby="st-photos-title">
  <div class="container-wide">
    <div class="st-photos__grid">
      <div class="st-photos__intro reveal-left">
        <span class="eyebrow-label">On the job</span>
        <h2 id="st-photos-title">What does a <span class="text-accent">septic installation</span> look like before backfill?</h2>
        <p class="answer-block">A BDPM Site Services septic installation in Plymouth is inspected while the tank, the pipes and the field are still open. These photos show a concrete tank with its riser set, two tanks connected in the trench, and precast riser rings staged beside the hole.</p>
      </div>
      <div class="sp-gallery-grid reveal-right">
      <figure class="sp-gallery-item reveal-up reveal-delay-1"><?php echo photoPicture('concrete-septic-tank-riser-backyard', '(max-width: 700px) 92vw, 520px'); ?><figcaption>Concrete tank set, riser and lid in place</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-2"><?php echo photoPicture('plastic-septic-tanks-trench-connected', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Tanks connected in the trench before backfill</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-3"><?php echo photoPicture('precast-concrete-septic-riser-rings', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Precast risers staged beside the excavation</figcaption></figure>
      </div>
    </div>
  </div>
</section>

<!-- ============ SIZING (table) ============ -->
<section class="section edge-curve-top st-size" aria-labelledby="st-size-title">
  <div class="container">
    <div class="st-size__grid">
      <div class="st-size__intro reveal-left">
        <span class="eyebrow-label">Sizing</span>
        <h2 id="st-size-title">How is a septic system sized for a Plymouth house?</h2>
        <p class="answer-block">Title 5 sizes a septic system for a house by bedrooms, at 110 gallons per day per bedroom, not by how many people live there. A three-bedroom house is designed for 330 gallons a day, and the soil test decides how much leaching area that flow needs.</p>
        <ul class="st-flows" aria-label="Title 5 design flow by bedroom count">
          <li><b>220</b><span>gal/day · 2 bedrooms</span></li>
          <li><b>330</b><span>gal/day · 3 bedrooms</span></li>
          <li><b>440</b><span>gal/day · 4 bedrooms</span></li>
        </ul>
      </div>
      <div class="st-table-wrap reveal-right">
        <table class="st-table">
          <caption>What shapes a Plymouth septic design</caption>
          <thead>
            <tr><th scope="col">Factor</th><th scope="col">What it changes</th><th scope="col">Where it is decided</th></tr>
          </thead>
          <tbody>
<?php foreach ($stFactors as $stRow): ?>
            <tr><th scope="row"><?php echo h($stRow[0]); ?></th><td><?php echo h($stRow[1]); ?></td><td><?php echo h($stRow[2]); ?></td></tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$stReviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($stReviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $stReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section st-faq" aria-labelledby="st-faq-title">
  <div class="container">
    <div class="st-faq__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">Questions</span>
        <h2 id="st-faq-title">Who does what on a Plymouth septic installation?</h2>
        <p class="answer-block">Licensed professionals test the soil and design a Plymouth septic system, and the town approves and inspects it. BDPM Site Services does the excavation and installation to that approved plan, and the question customers ask most about how that work is split is answered below.</p>
      </div>
      <div class="reveal-right">
<?php foreach ($stFaqs as $stFaq): ?>
        <details class="faq" open>
          <summary><?php echo h($stFaq['q']); ?></summary>
          <p class="faq-answer"><?php echo h($stFaq['a']); ?></p>
        </details>
<?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ OTHER SERVICES (required services component, 3 cards) ============ -->
<section class="section slant-top st-related" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What else does a <span class="text-accent">septic project</span> in Plymouth usually need?</h2>
      <p class="hero-answer">A septic project in Plymouth often starts with a Title 5 inspection and runs into site work around the tank and field. BDPM Site Services handles the inspection, the excavation and grading, and helical piers where an addition needs support, so the work below grade stays with one contractor.</p>
    </div>
    <div class="services-grid">
<?php foreach ($stRelated as $stRelI => $stRelSlug):
    $stRelSvc = serviceBySlug($stRelSlug);
    $stRelCard = $stCards[$stRelSlug]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($stRelI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($stRelI % 3) + 1; ?>">
        <div class="service-card__image"><?php echo photoPicture($stRelCard['photo'], '(max-width: 900px) 92vw, 380px'); ?></div>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($stRelCard['icon'], 24); ?></div>
          <h3><?php echo h($stRelSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($stRelCard['desc']); ?></p>
          <ul>
<?php foreach ($stRelCard['bullets'] as $stBullet): ?>
            <li><?php echo h($stBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($stRelSlug); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($stRelSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <p class="st-related__more reveal-up"><a class="btn btn-secondary" href="/services/">See all five Plymouth services</a></p>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-wave-top st-cta" aria-labelledby="st-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="st-cta-title">Ready for a free septic installation estimate in Plymouth?</h2>
      <p>Send the address and, if you have it, the approved septic plan. BDPM Site Services will look at the lot and send a written estimate with the scope, price and schedule.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free septic estimate</button>
      <a class="link-call" href="<?php echo h($stTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
