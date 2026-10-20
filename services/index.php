<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ — Phase 4 services hub (warm-human archetype). Lists all five services from config.php $services with the
 * required services-grid component, a "which service do I need" table and the typical multi-service sequence.
 * Photos (2026-10-20): photo hero (.hero--photo) and a registry photo on every card via serviceCards()['photo']. The estimate tool is NOT authorized
 * (build-plan integrations.estimate_tool.authorized = false), so it is not referenced here.
 */
$pageTitle       = 'Excavation Services Plymouth MA | BDPM Site Services';
$pageDescription = 'Site excavation, septic installation, Title 5 inspections, sea walls and helical piers in Plymouth, MA from BDPM Site Services. Get an estimate: (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/services/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'services';
$pageType        = 'other';
$serviceSlug     = '';
$svHeroPhoto     = 'construction-crew-scaffolding-site-review';
$heroPreload     = photoHeroPreload($svHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Services', 'url' => '/services/'],
];

$svTel   = formatPhone($phone, 'tel');
$svCards = serviceCards();

// ItemList of the five service pages (each page carries its own Service node)
$svItems = [];
foreach ($services as $svIdx => $svRow) {
    $svItems[] = ['@type' => 'ListItem', 'position' => $svIdx + 1, 'name' => $svRow['name'],
                  'url' => rtrim($siteUrl, '/') . '/services/' . $svRow['slug'] . '/'];
}
$schemaMarkup = [[
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => rtrim($siteUrl, '/') . '/services/#webpage',
    'url' => rtrim($siteUrl, '/') . '/services/',
    'name' => $pageTitle,
    'about' => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
    'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
    'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => $svItems],
]];

// Situation -> service map (every link points at a page that exists)
$svSituations = [
    ['Selling a house with a septic system', 'title-5-inspections', 'Septic installation if the system fails'],
    ['A failed Title 5 inspection', 'septic-system-installation', 'Excavation and final grade around the new system'],
    ['Building a house or an addition', 'site-construction-excavation', 'A septic system on unsewered lots; helical piers on loose soil'],
    ['A deck, porch or addition on soft or wet ground', 'helical-piers', 'Grading and drainage around the new structure'],
    ['Water pooling against the house or across the driveway', 'site-construction-excavation', 'Final grade pitched away from the building'],
    ['An eroding coastal bank or a failing wall', 'sea-walls', 'Helical piers for decks and additions near the water'],
];

$svChain = [
    ['icon' => 'search', 'title' => 'Soil test and design', 'text' => 'A perc test and an engineered septic design set the elevations the rest of the job works to.'],
    ['icon' => 'tractor', 'title' => 'Site excavation', 'text' => 'Clearing topsoil, digging the foundation and running the utility trenches.'],
    ['icon' => 'building-2', 'title' => 'Helical piers, if needed', 'text' => 'Where the soil is loose or wet, piers carry the load instead of a standard footing.'],
    ['icon' => 'droplets', 'title' => 'Septic installation', 'text' => 'Tank, distribution box and field built to the approved plan, inspected before backfill.'],
    ['icon' => 'mountain', 'title' => 'Final grade', 'text' => 'Loam spread back and the lot pitched so water runs away from the house.'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Services hub — page composition (tokens only).
   Motif: the job board. Survey grid in the hero, the featured services grid,
   a situation table and a five-stop job chain.
   ========================================================================== */
.sv { --sv-grid: color-mix(in srgb, var(--color-white) 6%, transparent); }
.sv h1, .sv h2, .sv h3 { text-wrap: balance; }
.sv p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + survey grid ---- */
.sv-hero { padding-bottom: clamp(2.5rem, 5vw, 4rem); }
.sv-hero .hero-bg img { object-position: 50% 40%; }
.sv-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 55% 90% at 90% 20%, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 70%);
}
.sv-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.sv-hero__grid { position: absolute; inset: 0 0 0 45%; z-index: -1; pointer-events: none; background-image: linear-gradient(var(--sv-grid) 1px, transparent 1px), linear-gradient(90deg, var(--sv-grid) 1px, transparent 1px); background-size: 48px 48px; -webkit-mask: radial-gradient(closest-side at 60% 50%, var(--color-black), transparent); mask: radial-gradient(closest-side at 60% 50%, var(--color-black), transparent); }
.sv-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.sv-hero .breadcrumb a:hover { color: var(--color-white); }
.sv-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.sv-hero .text-accent { color: var(--color-accent-bright); }
.sv-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.sv-hero .link-call svg { color: var(--color-accent-bright); }
.sv-hero .link-call:hover { color: var(--color-white); }
.sv-hero__inner { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, .75fr); gap: clamp(2rem, 5vw, 4rem); align-items: end; }
.sv-hero .hero-copy { max-width: 40rem; }
.sv-hero .hero-title { max-width: 20ch; }
.sv-hero .hero-chips li { background: var(--sv-grid); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.sv-hero .hero-chips svg { color: var(--color-accent-bright); }
.sv-index { margin: 0; padding: var(--space-lg); list-style: none; counter-reset: svidx; border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); backdrop-filter: blur(6px); }
.sv-index li { counter-increment: svidx; border-top: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); }
.sv-index li:first-child { border-top: 0; }
.sv-index a { display: flex; align-items: center; gap: var(--space-sm); min-height: 44px; padding: var(--space-xs) 0; color: var(--color-white); font-weight: 600; text-decoration: none; transition: color var(--transition), padding var(--transition); }
.sv-index a::before { content: counter(svidx, decimal-leading-zero); font-family: var(--font-accent); font-size: var(--font-size-sm); color: var(--color-accent-bright); letter-spacing: .08em; }
.sv-index a:hover { color: var(--color-accent-bright); padding-left: var(--space-xs); }

/* ---- Services grid (featured, 5 photo cards) ---- */
.sv-services { background: var(--color-paper); }
.sv-services .section-title { max-width: 66ch; }
.sv-services .section-subtitle { color: var(--color-accent-dark); }
.sv-services .service-card-with-image { box-shadow: var(--shadow-sm); }
.sv-services .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.sv-services .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow); }
.sv-services .services-grid--featured > :first-child { color: var(--color-white); border-color: transparent; isolation: isolate; background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 120%); }
.sv-services .services-grid--featured > :first-child::before { content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; background-image: linear-gradient(var(--sv-grid) 1px, transparent 1px), linear-gradient(90deg, var(--sv-grid) 1px, transparent 1px); background-size: 36px 36px; }
.sv-services .services-grid--featured > :first-child .service-card__body { padding: var(--space-xl); align-content: end; gap: var(--space-sm); }
.sv-services .services-grid--featured > :first-child h3 { color: var(--color-white); font-size: var(--fs-h2); }
.sv-services .services-grid--featured > :first-child .service-card__desc,
.sv-services .services-grid--featured > :first-child ul li { color: color-mix(in srgb, var(--color-white) 82%, transparent); font-size: var(--fs-body); }
.sv-services .services-grid--featured > :first-child ul { border-top-color: color-mix(in srgb, var(--color-white) 16%, transparent); }
.sv-services .services-grid--featured > :first-child ul li::before { color: var(--color-accent-bright); }
.sv-services .services-grid--featured > :first-child .service-card__icon { width: 64px; height: 64px; background: var(--color-accent); color: var(--color-ink); }
.sv-services .services-grid--featured > :first-child .service-card__cta { color: var(--color-white); }
.sv-services .services-grid--featured > :first-child .service-card__cta:hover { color: var(--color-accent-bright); }
.sv-services .services-grid--featured > :first-child[data-featured-label]::after { color: var(--color-white); }

/* ---- Situation table ---- */
.sv-match { background: var(--color-surface); }
.sv-match__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.4fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.sv-match__intro { display: grid; gap: var(--space-md); position: sticky; top: calc(var(--nav-height) + var(--space-xl)); }
.sv-match__intro .answer-block { margin: 0; }
.sv-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow); }
.sv-table { width: 100%; min-width: 600px; border-collapse: collapse; font-size: var(--fs-small); background: var(--color-surface); }
.sv-table th, .sv-table td { padding: var(--space-md) var(--space-lg); text-align: left; vertical-align: top; line-height: 1.5; border-bottom: 1px solid var(--color-line); }
.sv-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-white); background: var(--color-dark); }
.sv-table tbody th { font-weight: 700; color: var(--color-ink); }
.sv-table tbody tr:nth-child(odd) { background: var(--color-paper); }
.sv-table td a { display: inline-flex; align-items: center; gap: var(--space-xs); font-weight: 700; color: var(--color-accent-dark); text-decoration: none; border-bottom: 2px solid color-mix(in srgb, var(--color-accent) 35%, transparent); }
.sv-table td a:hover { border-bottom-color: var(--color-accent); }
.sv-table td:last-child { color: var(--color-ink-2); }

/* ---- Job chain (dark band) ---- */
.sv-chain .section-head { max-width: 66ch; }
.sv-chain .answer-block { background: var(--sv-grid); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.sv-links { counter-reset: svlink; display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: var(--space-md); margin: var(--space-2xl) 0 0; padding: 0; list-style: none; }
.sv-links li { counter-increment: svlink; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 5%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
.sv-links li + li::before { content: ""; position: absolute; left: calc(-1 * var(--space-md)); top: 2.4rem; width: var(--space-md); height: 2px; background: var(--color-accent-bright); }
.sv-links svg { color: var(--color-accent-bright); }
.sv-links h3 { font-size: var(--font-size-base); color: var(--color-white); }
.sv-links p { margin: 0; font-size: var(--fs-small); }
.sv-links li:nth-child(3) { border-style: dashed; }

/* ---- Closing CTA ---- */
.sv-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.sv-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.sv-cta .link-call svg { color: var(--color-accent-bright); }
.sv-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.sv-cta .floating-ring { right: -6rem; top: -6rem; opacity: .1; }

/* ---- Responsive ---- */
@media (max-width: 1100px) { .sv-links { grid-template-columns: repeat(3, minmax(0, 1fr)); } .sv-links li:nth-child(4)::before { display: none; } }
@media (max-width: 1000px) {
  .sv-hero__inner, .sv-match__grid { grid-template-columns: 1fr; }
  .sv-match__intro { position: static; }
}
@media (max-width: 700px) {
  .sv-links { grid-template-columns: 1fr; }
  .sv-links li + li::before { left: 2.2rem; top: calc(-1 * var(--space-md)); width: 2px; height: var(--space-md); }
  .sv-links li:nth-child(4)::before { display: block; }
  .sv-hero .hero-actions .btn { width: 100%; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="sv">

<!-- ============ HERO (interior, no form: the hub routes to the service pages) ============ -->
<section class="hero hero--interior hero--photo sv-hero" aria-labelledby="sv-hero-title">
  <div class="hero-bg"><?php echo photoPicture($svHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <span class="sv-hero__grid" aria-hidden="true"></span>
  <div class="container">
    <div class="sv-hero__inner">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li aria-current="page">Services</li>
          </ol>
        </nav>
        <span class="eyebrow">Services · Plymouth, MA</span>
        <h1 class="hero-title" id="sv-hero-title"><span class="text-accent">Excavation, septic</span> and foundation services in Plymouth, MA</h1>
        <p class="hero-answer">BDPM Site Services is an excavation contractor based in Plymouth, MA offering five services: site construction and excavation, septic system installation, Title 5 inspections, sea walls and helical piers. Each one starts with a site visit and a written estimate covering the scope, price and schedule.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($svTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('map-pin', 16); ?>Based on Beaver Dam Rd</li>
          <li><?php icon('clipboard-list', 16); ?>Written estimates</li>
          <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
        </ul>
      </div>
      <nav aria-label="Service pages">
        <ol class="sv-index">
<?php foreach ($services as $svNav): ?>
          <li><a href="/services/<?php echo h($svNav['slug']); ?>/"><?php echo h($svNav['name']); ?></a></li>
<?php endforeach; ?>
        </ol>
      </nav>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<!-- ============ SERVICES GRID (required component, featured 5) ============ -->
<section class="section sv-services" id="all-services" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">BDPM Site Services</span> job fits your Plymouth project?</h2>
      <p class="hero-answer">BDPM Site Services offers five jobs in Plymouth, MA: site construction and excavation, septic system installation, Title 5 inspections, sea walls and helical piers. Most projects start with one and lead into another, because they share the same ground, the same soil questions and often the same permit reviews.</p>
      <span class="section-subtitle">Dig · Install · Inspect · Protect · Support</span>
      <p class="prose">Each card opens a page with the process, the Massachusetts rules that apply and what changes the price on a Plymouth lot.</p>
    </div>

    <div class="services-grid services-grid--featured">
<?php foreach ($services as $svI => $svSvc):
    $svCard = $svCards[$svSvc['slug']]; ?>
      <article class="service-card-with-image card-tint-<?php echo ($svI % 3) + 1; ?> reveal-up reveal-delay-<?php echo ($svI % 3) + 1; ?>"<?php echo $svI === 0 ? ' data-featured-label="Core service"' : ''; ?>>
        <div class="service-card__image"><?php echo photoPicture($svCard['photo'], $svI === 0 ? '(max-width: 1000px) 92vw, 760px' : '(max-width: 720px) 92vw, (max-width: 1000px) 46vw, 380px'); ?></div>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($svCard['icon'], 26); ?></div>
          <h3><?php echo h($svSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($svCard['desc']); ?></p>
          <ul>
<?php foreach ($svCard['bullets'] as $svBullet): ?>
            <li><?php echo h($svBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($svSvc['slug']); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($svSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ WHICH SERVICE (situation table) ============ -->
<section class="section edge-curve-top sv-match" aria-labelledby="sv-match-title">
  <div class="container-wide">
    <div class="sv-match__grid">
      <div class="sv-match__intro reveal-left">
        <span class="eyebrow-label">Start here</span>
        <h2 id="sv-match-title">Which Plymouth service do you need for your situation?</h2>
        <p class="answer-block">The service you need in Plymouth depends on what is happening on the property. A home sale with a septic system starts with a Title 5 inspection, new construction starts with site excavation, and an eroding coastal bank starts with a sea wall assessment. The table matches six common situations to the right first step.</p>
      </div>
      <div class="sv-table-wrap reveal-right">
        <table class="sv-table">
          <thead>
            <tr><th scope="col">Your situation</th><th scope="col">Start with</th><th scope="col">Often followed by</th></tr>
          </thead>
          <tbody>
<?php foreach ($svSituations as $svSit):
    $svSitSvc = serviceBySlug($svSit[1]); ?>
            <tr><th scope="row"><?php echo h($svSit[0]); ?></th><td><a href="/services/<?php echo h($svSit[1]); ?>/"><?php echo h($svSitSvc['name']); ?></a></td><td><?php echo h($svSit[2]); ?></td></tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ============ JOB CHAIN (dark band) ============ -->
<section class="section texture-grain slant-top sv-chain" aria-labelledby="sv-chain-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">One lot, several trades</span>
      <h2 id="sv-chain-title">How does a new house on an unsewered Plymouth lot use more than one service?</h2>
      <p class="answer-block">A new house on a Plymouth lot without town sewer typically needs site excavation, a septic installation and final grading, and sometimes helical piers where the soil is soft. With BDPM Site Services doing all of it, the soil test and septic design set one set of elevations that every stage of the work follows.</p>
    </div>
    <ol class="sv-links">
<?php foreach ($svChain as $svChI => $svLink): ?>
      <li class="reveal-up reveal-delay-<?php echo ($svChI % 4) + 1; ?>"><?php icon($svLink['icon'], 24); ?><h3><?php echo h($svLink['title']); ?></h3><p><?php echo h($svLink['text']); ?></p></li>
<?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-torn-top sv-cta" aria-labelledby="sv-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="sv-cta-title">Not sure which service fits your Plymouth project?</h2>
      <p>Describe the job in the estimate form or call during office hours. BDPM Site Services will tell you where to start and set up a site visit.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request an estimate</button>
      <a class="link-call" href="<?php echo h($svTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
