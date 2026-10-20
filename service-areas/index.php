<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/ — Phase 6 service-areas hub (plural, directory + index.php). One area exists in build-plan service_areas ("Plymouth"),
 * so the grid holds one real area card plus an honest "another town?" card; no neighbouring town is listed as served because intake does
 * not say so. Plymouth's neighbours (Bourne, Wareham, Carver, Kingston, Duxbury) appear only as geography, per Wikipedia, with an
 * invitation to call. No GBP map embed exists (integrations.gbp_map_embed = null), so the coverage visual is a village tile map plus the
 * GBP directions link. Villages: https://en.wikipedia.org/wiki/Plymouth,_Massachusetts (checked 2026-10-19).
 */
$pageTitle       = 'Service Areas in Plymouth, MA | BDPM Site Services';
$pageDescription = 'BDPM Site Services is based in Plymouth, MA and serves the town and its villages with excavation, septic, sea wall and helical pier work. Call (508) 989-7101.';
$canonicalUrl    = $siteUrl . '/service-areas/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'service-areas';
$pageType        = 'other';
$saHeroPhoto = 'aerial-bulldozer-grading-rock-shoreline';   // registry name (includes/photos.php) — photo hero, LCP preloaded
$heroPreload     = photoHeroPreload($saHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Service Areas', 'url' => '/service-areas/'],
];

$saTel   = formatPhone($phone, 'tel');
$saBase  = rtrim($siteUrl, '/');
$saPlace = $address['city'] . ', ' . $address['state'];

// Every area in config.php, with an on-disk check so a card never links to a page that does not exist
$saAreas = [];
foreach ($areaPages as $saRow) {
    $saBuilt = is_file($_SERVER['DOCUMENT_ROOT'] . '/service-areas/' . $saRow['slug'] . '/index.php');
    $saAreas[] = $saRow + ['built' => $saBuilt, 'href' => '/service-areas/' . $saRow['slug'] . '/'];
}

$saVillages = ['Plymouth Center', 'North Plymouth', 'West Plymouth', 'South Plymouth', 'Manomet', 'Cedarville'];

$saItems = [];
foreach ($saAreas as $saIdx => $saRow) {
    if (!$saRow['built']) continue;
    $saItems[] = ['@type' => 'ListItem', 'position' => count($saItems) + 1, 'name' => $saRow['name'] . ', ' . $saRow['state'], 'url' => $saBase . $saRow['href']];
}
$schemaMarkup = [[
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $saBase . '/service-areas/#webpage',
    'url' => $saBase . '/service-areas/',
    'name' => $pageTitle,
    'about' => ['@id' => $saBase . '/#organization'],
    'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
    'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => $saItems],
]];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Service areas hub — page composition (tokens only).
   Motif: contour rings behind the hero, a wide featured area card, a village
   tile map as the coverage visual.
   ========================================================================== */
.sa h1, .sa h2, .sa h3 { text-wrap: balance; }
.sa p { text-wrap: pretty; }

/* ---- Hero ---- */
.sa-hero .hero-bg img { object-position: 50% 50%; }
.sa-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: repeating-radial-gradient(circle at 85% 20%, transparent 0 34px, color-mix(in srgb, var(--color-white) 6%, transparent) 34px 35px),
              radial-gradient(ellipse 55% 70% at 85% 10%, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%);
}
.sa-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .26; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.sa-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.sa-hero .breadcrumb a:hover { color: var(--color-white); }
.sa-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.sa-hero .text-accent { color: var(--color-accent-bright); }
.sa-hero .hero-title { max-width: 40ch; }
.sa-hero .hero-answer { max-width: 62ch; }
.sa-hero .btn-primary { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-white); }
.sa-hero .btn-primary:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.sa-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.sa-hero .link-call svg { color: var(--color-accent-bright); }
.sa-hero .link-call:hover { color: var(--color-white); }
.sa-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 8%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.sa-hero .hero-chips svg { color: var(--color-accent-bright); }

/* ---- Areas grid ---- */
.sa-areas { background: var(--color-paper); }
.sa-areas .section-head { max-width: 68ch; }
.sa-areas .answer-block { margin: 0; }
.sa-grid { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: var(--space-lg); }
.sa-card { position: relative; display: grid; gap: var(--space-sm); align-content: start; padding: var(--space-xl); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); scroll-margin-top: calc(var(--nav-height) + var(--space-lg)); }
.sa-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.sa-card--main { background: var(--color-card-tint-3); border-top: 6px solid var(--color-accent); }
.sa-card--call { background: var(--color-card-tint-1); border-top: 6px solid var(--color-secondary); }
.sa-card__tag { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.sa-card h3 { font-size: var(--fs-h2); line-height: 1.1; }
.sa-card--call h3 { font-size: var(--fs-h3); }
.sa-card p { margin: 0; color: var(--color-ink-2); }
.sa-card ul { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.sa-card li { padding: var(--space-1) var(--space-sm); border-radius: var(--radius-full); background: var(--color-surface); border: 1px solid var(--color-line); font-size: var(--font-size-xs); font-weight: 600; color: var(--color-ink-2); }
.sa-card .btn { justify-self: start; margin-top: var(--space-xs); }

/* ---- Coverage visual (dark band) ---- */
.sa-cover .section-head { max-width: 66ch; }
.sa-cover .answer-block { margin: 0; background: color-mix(in srgb, var(--color-white) 8%, transparent); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sa-cover__grid { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: center; }
.sa-tiles { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.sa-tiles li { position: relative; display: grid; align-content: end; min-height: 96px; padding: var(--space-md); border-radius: var(--radius); background: color-mix(in srgb, var(--color-white) 7%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); font-family: var(--font-heading); font-weight: 800; color: var(--color-white); overflow: hidden; }
.sa-tiles li::before { content: ""; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, transparent 0 12px, color-mix(in srgb, var(--color-white) 4%, transparent) 12px 13px); pointer-events: none; }
.sa-cover__side { display: grid; gap: var(--space-md); }
.sa-cover__side p { margin: 0; font-size: var(--fs-small); }
.sa-cover__side .btn { justify-self: start; }
.sa-cover__legend { font-size: var(--font-size-xs); color: color-mix(in srgb, var(--color-white) 72%, transparent); }

/* ---- Closing CTA ---- */
.sa-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.sa-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.sa-cta .link-call svg { color: var(--color-accent-bright); }
.sa-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }

@media (max-width: 1000px) { .sa-grid, .sa-cover__grid { grid-template-columns: 1fr; } }
@media (max-width: 560px) { .sa-tiles { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="sa">

<!-- ============ HERO ============ -->
<section class="hero hero--interior hero--photo sa-hero" aria-labelledby="sa-hero-title">
  <div class="hero-bg"><?php echo photoPicture($saHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li aria-current="page">Service Areas</li>
      </ol>
    </nav>
    <span class="eyebrow">Where we work</span>
    <h1 class="hero-title" id="sa-hero-title"><span class="text-accent">Excavation Contractor</span> in Plymouth, MA &amp; Surrounding Communities</h1>
    <p class="hero-answer">BDPM Site Services works out of 168 Beaver Dam Rd in Plymouth, MA, and serves Plymouth and the surrounding area with excavation, septic, sea wall and helical pier work.</p>
    <div class="hero-actions">
      <button type="button" class="btn btn-primary btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="link-call" href="<?php echo h($saTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
    </div>
    <ul class="hero-chips" aria-label="At a glance">
      <li><?php icon('map-pin', 16); ?>Based in Plymouth, MA</li>
      <li><?php icon('tractor', 16); ?>Five ground trades</li>
      <li><?php icon('clock', 16); ?>Mon–Fri 7am–5pm</li>
    </ul>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<article class="sa-article" aria-labelledby="sa-hero-title">

<!-- ============ AREA CARDS ============ -->
<section class="section sa-areas" aria-labelledby="sa-areas-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Coverage</span>
      <h2 id="sa-areas-title">Which towns does BDPM Site Services serve?</h2>
      <p class="answer-block">BDPM Site Services is an excavation contractor based in Plymouth, MA, and serves Plymouth and the surrounding area. Plymouth has its own page below, written around the town's soils, shoreline and permits. If your property is in another town, call <?php echo h($phone); ?> and ask whether the job is within reach.</p>
    </div>
    <div class="sa-grid">
<?php foreach ($saAreas as $saRow): ?>
      <article class="sa-card sa-card--main reveal-left" id="<?php echo h($saRow['slug']); ?>">
        <span class="sa-card__tag">Home base</span>
        <h3><?php echo h($saRow['name'] . ', ' . $saRow['state']); ?></h3>
        <p>The largest town in Massachusetts by area, from the sandy pinelands in the west to the harbor in the center and the high coastal banks in the south. The Plymouth page covers the ground, the permits and the five services BDPM Site Services offers there.</p>
        <ul aria-label="Villages in <?php echo h($saRow['name']); ?>">
<?php foreach ($saVillages as $saVillage): ?>
          <li><?php echo h($saVillage); ?></li>
<?php endforeach; ?>
        </ul>
<?php if ($saRow['built']): ?>
        <a class="btn btn-primary" href="<?php echo h($saRow['href']); ?>">Excavation in <?php echo h($saRow['name']); ?>, <?php echo h($saRow['state']); ?></a>
<?php endif; ?>
      </article>
<?php endforeach; ?>
      <article class="sa-card sa-card--call reveal-right">
        <span class="sa-card__tag">Nearby town?</span>
        <h3>Not in Plymouth?</h3>
        <p>Plymouth borders Bourne, Wareham, Carver, Kingston and Duxbury. Call with the address and BDPM Site Services will tell you whether the job fits the route before booking a site visit.</p>
        <a class="btn btn-secondary" href="<?php echo h($saTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
      </article>
    </div>
  </div>
</section>

<!-- ============ COVERAGE VISUAL (village tile map) ============ -->
<section class="section texture-grain edge-curve-top sa-cover" aria-labelledby="sa-cover-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Plymouth, village by village</span>
      <h2 id="sa-cover-title">Which parts of Plymouth does an estimate visit cover?</h2>
      <p class="answer-block">An estimate visit from BDPM Site Services covers the whole town of Plymouth, which has six named villages: Plymouth Center, North Plymouth, West Plymouth, South Plymouth, Manomet and Cedarville. The crew drives to the lot, looks at the soil, ledge, access and water, and sends a written estimate.</p>
    </div>
    <div class="sa-cover__grid">
      <ul class="sa-tiles reveal-scale" aria-label="Villages of Plymouth, Massachusetts">
<?php foreach ($saVillages as $saVillage): ?>
        <li><?php echo h($saVillage); ?></li>
<?php endforeach; ?>
      </ul>
      <div class="sa-cover__side reveal-right">
        <p>The tiles are a list of villages, not a scale map. Use the directions link to see where the office sits on Beaver Dam Road.</p>
        <a class="btn btn-accent" href="<?php echo h($gbp['directions']); ?>" target="_blank" rel="noopener"><?php icon('map-pin', 18); ?>Get directions</a>
        <p class="sa-cover__legend">Village names from the town's public geography listing.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-torn-top sa-cta" aria-labelledby="sa-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="sa-cta-title">Ready for a free estimate in Plymouth?</h2>
      <p>Send the address and a few lines about the job. BDPM Site Services will walk the lot and send a written estimate with the scope, price and schedule.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="link-call" href="<?php echo h($saTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
