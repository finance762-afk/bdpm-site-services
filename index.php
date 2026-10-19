<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * Homepage — Phase 3 (v7 scaffold, archetype warm-human, editorial section script).
 * The intake supplied NO client photos and NO logo (build-plan assets.images = []), so the hero falls back to
 * .hero-grid--form (copy | form card), service cards are icon cards, the gallery is skipped (< 8 photos) and the
 * about column carries a typographic company card instead of a photo. Every fact below traces to build-plan.json /
 * config.php; facts the page wants but intake does not supply are listed in /content-confirmations.json.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';

$pageTitle       = 'Site Excavation in Plymouth, MA | ' . $siteName;
$pageDescription = $siteName . ' handles site excavation, septic system installation, Title 5 inspections, sea walls and helical piers in Plymouth, MA. Call ' . $phone . '.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = '/assets/images/og-default.jpg';   // head.php emits og:image only once the file exists
$currentPage     = 'home';
$pageType        = 'home';
$heroPreloadImage = '';                                // no hero photo in the manifest -> no image preload
$heroPreload     = [];

$homeTel   = formatPhone($phone, 'tel');
$homePlace = $address['city'] . ', ' . $address['state'];

// Service cards — order = config $services. Five cards -> ORPHAN RULE: featured grid, first card is the 2x2 tile.
$homeCards = [
    'site-construction-excavation' => [
        'icon'    => 'tractor',
        'desc'    => 'Excavation, grading and site preparation for residential and commercial lots.',
        'bullets' => ['Site prep and final grading', 'Foundation and footing digs', 'Drainage and utility trenches'],
    ],
    'septic-system-installation' => [
        'icon'    => 'droplets',
        'desc'    => 'New and replacement septic systems installed to the approved design.',
        'bullets' => ['Built to the approved plan', 'Board of Health inspections', 'New and replacement systems'],
    ],
    'sea-walls' => [
        'icon'    => 'waves',
        'desc'    => 'Sea wall construction for waterfront and coastal property.',
        'bullets' => ['Built for waterfront lots', 'Planned around coastal permits', 'Holds back shoreline erosion'],
    ],
    'helical-piers' => [
        'icon'    => 'building-2',
        'desc'    => 'Steel piers screwed down past loose soil to carry a structure.',
        'bullets' => ['Support for new foundations', 'Additions, decks and porches', 'Far less digging than footings'],
    ],
    'title-5-inspections' => [
        'icon'    => 'clipboard-list',
        'desc'    => 'Massachusetts Title 5 septic inspections for sales and system checks.',
        'bullets' => ['Required before most sales', 'Completed state inspection form', 'Same team installs septic systems'],
    ],
];

// Ticker — services + plain facts from intake. Rendered twice for the seamless loop.
$tickerItems = [
    ['tractor', 'Site Excavation'],
    ['droplets', 'Septic System Installation'],
    ['clipboard-list', 'Title 5 Inspections'],
    ['waves', 'Sea Walls'],
    ['building-2', 'Helical Piers'],
    ['mountain', 'Grading & Site Prep'],
    ['home', 'Residential & Commercial'],
    ['map-pin', 'Plymouth, MA'],
    ['clock', 'Mon–Fri 7am–5pm'],
];

// FAQs — from the research brief (research_brief.brief.faqs), wording checked against intake.
$homeFaqs = [
    ['q' => 'Do I need to call Dig Safe before digging in Plymouth?',
     'a' => 'Yes. In Massachusetts, you must contact Dig Safe by calling 811 or 1-888-344-7233 before any excavation, and utility companies then mark their underground lines. Dig Safe requires notice at least 72 hours before digging, not counting weekends and holidays. BDPM Site Services confirms the markings are in place before any work begins.'],
    ['q' => 'Will my project need a wetlands or conservation permit in Plymouth?',
     'a' => 'It may. Work within wetland resource areas or their buffer zones is regulated under the Massachusetts Wetlands Protection Act and local bylaws, which often means review by the Plymouth Conservation Commission. Tell BDPM Site Services about the property during your estimate and we will explain what review is likely before any work is scheduled.'],
    ['q' => 'How much does excavation cost in Plymouth?',
     'a' => 'Excavation pricing depends on the size of the job, soil and ledge conditions, site access, how much material must be hauled away, and the timeline. BDPM Site Services gives a written estimate after a site visit, with the scope, price and schedule spelled out.'],
    ['q' => 'Do you install septic systems and do Title 5 inspections?',
     'a' => 'Yes. BDPM Site Services installs septic systems and performs Massachusetts Title 5 inspections in Plymouth. Installations follow the system design approved by the Plymouth Board of Health, and the work is inspected on the board\'s schedule.'],
    ['q' => 'What types of soil and site conditions do you deal with?',
     'a' => 'Plymouth sites vary widely, from sandy and gravelly soils to clay, fill and exposed ledge. BDPM Site Services assesses each site during the estimate so the right equipment, drainage and disposal plan are included in the quote before work begins.'],
];

$schemaMarkup = [generateFAQSchema($homeFaqs)];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Homepage — page-specific composition (tokens only; framework.css owns the
   shared components). Motif: survey contour lines, drawn with gradients.
   ========================================================================== */
.home { --contour: color-mix(in srgb, var(--color-primary) 9%, transparent); --contour-dark: color-mix(in srgb, var(--color-white) 7%, transparent); }

/* Headings balance their lines (also set in framework.css) */
.home h2, .home h3 { text-wrap: balance; }

/* ---- Hero: layered (radial ::before from framework + grain ::after + contour field) ---- */
.home-hero { background: linear-gradient(180deg, var(--color-paper) 0%, var(--color-paper-2) 100%); }
.home-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .28; mix-blend-mode: multiply;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.5'/%3E%3C/svg%3E");
}
.home-hero__contours {
  position: absolute; inset: 0 0 0 40%; z-index: -1; pointer-events: none;
  background: repeating-radial-gradient(ellipse 60% 48% at 62% 46%, transparent 0 26px, var(--contour) 26px 27px);
  -webkit-mask: radial-gradient(closest-side at 62% 46%, var(--color-black) 55%, transparent 100%);
  mask: radial-gradient(closest-side at 62% 46%, var(--color-black) 55%, transparent 100%);
}
.home-hero .hero-title { max-width: 19ch; }
.home-hero .hero-text { gap: var(--space-md); }
.home-hero .hero-chips li { box-shadow: var(--shadow-sm); }
.home-hero .hero-chips svg { color: var(--color-accent-dark); }
.home-hero .hero-form-card { position: relative; border-top: 4px solid var(--color-accent); }
.home-hero .hero-form .consent a { color: var(--color-primary); }
.home-hero__hours { display: flex; align-items: center; gap: var(--space-xs); margin: 0; font-size: var(--fs-small); color: var(--color-muted); }
.home-hero__hours svg { color: var(--color-accent-dark); }

/* ---- Ticker ---- */
.home-ticker { background: var(--color-surface); }
.home-ticker .ticker-track svg { color: var(--color-accent-dark); }
.home-ticker .ticker-track > span + span::before { content: ""; width: 6px; height: 6px; border-radius: var(--radius-full); background: var(--color-line); margin-right: var(--space-lg); }

/* ---- Services: featured icon cards (no client photos yet) ---- */
.home-services { background: var(--color-paper); }
.home-services .section-title { max-width: 64ch; }
.home-services .hero-answer { max-width: 60ch; }
.home-services .service-card-with-image { box-shadow: var(--shadow-sm); }
.home-services .service-card__body { padding: var(--space-xl) var(--space-lg) var(--space-lg); }
.home-services .service-card__icon { width: 52px; height: 52px; border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow); }
.home-services .services-grid--featured > :first-child {
  display: flex; color: var(--color-white); border-color: transparent; isolation: isolate;
  background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 120%);
}
.home-services .services-grid--featured > :first-child::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: repeating-radial-gradient(ellipse 70% 55% at 85% 20%, transparent 0 22px, var(--contour-dark) 22px 23px);
}
.home-services .services-grid--featured > :first-child .service-card__body { padding: calc(var(--space-3xl) + var(--space-lg)) var(--space-xl) var(--space-xl); align-content: end; gap: var(--space-sm); }
.home-services .services-grid--featured > :first-child h3 { color: var(--color-white); font-size: var(--fs-h2); }
.home-services .services-grid--featured > :first-child .service-card__desc,
.home-services .services-grid--featured > :first-child ul li { color: color-mix(in srgb, var(--color-white) 82%, transparent); font-size: var(--fs-body); }
.home-services .services-grid--featured > :first-child ul { border-top-color: color-mix(in srgb, var(--color-white) 16%, transparent); }
.home-services .services-grid--featured > :first-child ul li::before { color: var(--color-accent-bright); }
.home-services .services-grid--featured > :first-child .service-card__icon { width: 64px; height: 64px; background: var(--color-accent); color: var(--color-white); }
.home-services .services-grid--featured > :first-child .service-card__icon svg { width: 30px; height: 30px; }
.home-services .services-grid--featured > :first-child .service-card__cta { color: var(--color-white); }
.home-services .services-grid--featured > :first-child .service-card__cta:hover { color: var(--color-accent-bright); }
.home-services .services-grid--featured > :first-child[data-featured-label]::after { color: var(--color-white); }
.home-services__more { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-md) var(--space-xl); margin-top: var(--space-2xl); }
.home-services__more p { margin: 0; color: var(--color-muted); font-size: var(--fs-small); }

/* ---- Proof strip: dark band, accent face ---- */
.home-proof.slant-top { padding-top: calc(var(--space-2xl) + 3.5vw); padding-bottom: var(--space-2xl); }
.home-proof.stats-band { color: var(--color-white); border-block: 0; background: linear-gradient(115deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 130%); }
.home-proof .stat-item { border-left-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.home-proof .stat-number { color: var(--color-white); font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem); text-transform: uppercase; }
.home-proof .stat-number span { color: var(--color-accent-bright); }
.home-proof .stat-label { color: color-mix(in srgb, var(--color-white) 72%, transparent); }

/* ---- Signature: what's under a Plymouth lot (strata) ---- */
.home-ground { background: var(--color-paper-2); }
.home-ground__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.home-ground__intro { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); display: grid; gap: var(--space-md); }
.home-ground__intro .answer-block { background: var(--color-surface); margin: 0; }
.home-ground__intro .answer-block p { margin: 0; }
.strata { list-style: none; margin: 0; padding: 0; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); counter-reset: none; }
.strata li { position: relative; display: grid; grid-template-columns: minmax(0, 9rem) minmax(0, 1fr); gap: var(--space-lg); padding: var(--space-lg) var(--space-xl); }
.strata li b { font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .06em; text-transform: uppercase; line-height: 1.1; }
.strata li p { margin: 0; font-size: var(--fs-small); line-height: 1.55; }
.strata__topsoil { background: color-mix(in srgb, var(--color-accent) 22%, var(--color-ink) 50%); color: var(--color-white); }
.strata__sand { background: color-mix(in srgb, var(--color-paper) 62%, var(--color-accent) 22%); color: var(--color-ink); background-image: radial-gradient(circle, color-mix(in srgb, var(--color-ink) 18%, transparent) 1px, transparent 1.6px); background-size: 9px 9px; }
.strata__clay { background: color-mix(in srgb, var(--color-secondary) 45%, var(--color-paper)); color: var(--color-ink); background-image: repeating-linear-gradient(0deg, transparent 0 10px, color-mix(in srgb, var(--color-ink) 9%, transparent) 10px 11px); }
.strata__ledge { background: var(--color-dark-alt); color: var(--color-white); background-image: repeating-linear-gradient(115deg, transparent 0 34px, color-mix(in srgb, var(--color-white) 8%, transparent) 34px 36px); }
.strata__topsoil p, .strata__ledge p { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.strata li + li { border-top: 1px dashed color-mix(in srgb, var(--color-ink) 22%, transparent); }
.strata-note { margin: var(--space-sm) 0 0; font-size: var(--font-size-xs); color: var(--color-muted); }
.rules { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: var(--space-2xl) 0 0; padding: 0; list-style: none; }
.rules li { background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); padding: var(--space-lg); display: grid; gap: var(--space-xs); align-content: start; }
.rules svg { color: var(--color-accent-dark); }
.rules h3 { font-size: var(--font-size-lg); }
.rules p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }

/* ---- About / process: the asymmetric section ---- */
.home-about { background: var(--color-surface); }
.home-about__ring { left: calc(-1 * var(--space-4xl) - var(--space-xl)); top: 12%; }
.home-about .about-split { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); align-items: start; }
.home-about .about-copy h2 { max-width: 22ch; }
.home-about .process-steps { margin-top: var(--space-lg); }
.home-about .process-steps li { background: var(--color-paper); border-radius: var(--radius); padding: var(--space-md); }
.home-about .about-right { margin-top: var(--space-4xl); }
.home-about .about-right::before { content: ""; position: absolute; inset: calc(-1 * var(--space-lg)) var(--space-lg) var(--space-lg) calc(-1 * var(--space-lg)); border: 2px solid var(--color-accent); opacity: .6; border-radius: var(--radius-lg); z-index: 0; }
.company-card {
  position: relative; z-index: 1; display: grid; gap: var(--space-md); padding: var(--space-2xl) var(--space-xl) calc(var(--space-3xl) + var(--space-lg));
  color: var(--color-white); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); isolation: isolate; overflow: hidden;
  background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 130%);
  clip-path: polygon(0 0, 100% 0, 100% calc(100% - var(--space-2xl)), calc(100% - var(--space-2xl)) 100%, 0 100%);
}
.company-card::before { content: ""; position: absolute; inset: 0; z-index: -1; background: repeating-radial-gradient(ellipse 80% 60% at 20% 110%, transparent 0 20px, var(--contour-dark) 20px 21px); }
.company-card__mark { font-family: var(--font-accent); font-size: clamp(3rem, 2rem + 3vw, 4.5rem); line-height: .9; letter-spacing: .04em; color: var(--color-white); }
.company-card__mark span { color: var(--color-accent-bright); }
.company-card h3 { color: var(--color-white); font-size: var(--fs-h3); }
.company-card dl { display: grid; gap: var(--space-sm); margin: 0; }
.company-card dl div { display: grid; grid-template-columns: 1.5rem 1fr; gap: var(--space-sm); align-items: start; }
.company-card dt svg { color: var(--color-accent-bright); margin-top: var(--space-1); }
.company-card dd { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.company-card dd a { color: var(--color-white); text-decoration: none; font-weight: 600; }
.home-about .about-stat-card { left: auto; right: calc(-1 * var(--space-md)); bottom: calc(-1 * var(--space-xl)); display: grid; gap: var(--space-1); border-left: 4px solid var(--color-accent); }
.home-about .about-stat-card b { font-family: var(--font-accent); font-size: var(--fs-h2); line-height: 1; color: var(--color-ink); }
.home-about .about-stat-card span { font-size: var(--fs-small); color: var(--color-muted); }

/* ---- Mid-page CTA band ---- */
.home-cta { color: var(--color-white); }
.home-cta .container-narrow { display: grid; grid-template-columns: minmax(0, 1fr); gap: var(--space-lg); text-align: center; justify-items: center; }
.home-cta h2 { max-width: 24ch; margin: 0; }
.home-cta p { max-width: 58ch; margin: 0; }
.home-cta .actions { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: var(--space-md) var(--space-xl); }
.home-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.home-cta .link-call svg { color: var(--color-accent-bright); }
.home-cta .floating-ring { top: -6rem; right: -5rem; opacity: .1; }

/* ---- Reviews (render only when the feed has written reviews) ---- */
.home-reviews { background: var(--color-paper-2); }

/* ---- FAQ ---- */
.home-faq { background: var(--color-paper); }
.home-faq .section-head--row { margin-bottom: var(--space-xl); }
.home-faq .faq-grid { align-items: start; }
.home-faq .faq summary { min-height: 44px; }
.home-faq .faq[open] summary { color: var(--color-primary); }

/* ---- Estimate section (closing CTA) ---- */
.home-estimate { background: linear-gradient(180deg, var(--color-surface) 0%, var(--color-paper-2) 100%); }
.home-estimate .estimate > .card { border-top: 4px solid var(--color-accent); display: grid; gap: var(--space-md); }
.home-estimate .estimate > .card h2 { margin: 0; }
.home-estimate__aside { display: grid; gap: var(--space-md); padding-top: var(--space-lg); }
.home-estimate__aside h3 { font-size: var(--fs-h3); }
.home-estimate__area { margin: var(--space-md) 0 0; padding-top: var(--space-md); border-top: 1px solid var(--color-line); font-size: var(--fs-small); color: var(--color-muted); }
.estimate-form .btn { margin-top: var(--space-sm); }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .home-ground__grid { grid-template-columns: 1fr; }
  .home-ground__intro { position: static; }
  .rules { grid-template-columns: 1fr; }
}
@media (max-width: 900px) {
  .home-hero__contours { inset: 30% 0 0 0; }
  .home-about .about-split { grid-template-columns: 1fr; }
  .home-about .about-right { margin-top: var(--space-xl); }
  .home-about .about-stat-card { right: var(--space-md); }
}
@media (max-width: 600px) {
  .strata li { grid-template-columns: 1fr; gap: var(--space-xs); padding: var(--space-md) var(--space-lg); }
  .home-services .services-grid--featured > :first-child .service-card__body { padding: calc(var(--space-3xl)) var(--space-lg) var(--space-lg); }
  .home-hero .hero-chips li { font-size: var(--font-size-xs); }
}

/* ---- From the blog (latest registry post, featured card) ---- */
<?php echo blogCardStyles(); ?>
.home-blog { background: var(--color-paper); }
.home-blog__feature { margin-top: var(--space-md); }
.home-blog__more { margin-top: var(--space-xl); display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-md); }
.home-blog__more p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="home">

<!-- ============ HERO (warm-human, no client photo yet -> copy | form card) ============ -->
<section class="hero hero--light home-hero" aria-labelledby="home-hero-title">
  <span class="home-hero__contours" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-text">
        <span class="eyebrow"><?php echo h($homePlace); ?> · <?php echo h($primaryCounty); ?></span>
        <h1 class="hero-title" id="home-hero-title"><span class="text-accent">Site excavation</span> and septic work in Plymouth, MA</h1>
        <p class="hero-answer">Excavation, septic and Title 5 work for Plymouth homes and businesses.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($homeTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('tractor', 16); ?>Residential &amp; commercial</li>
          <li><?php icon('clipboard-list', 16); ?>Septic &amp; Title 5</li>
          <li><?php icon('waves', 16); ?>Sea walls &amp; helical piers</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Get a free estimate</h2>
        <p class="hero-form-tagline">No obligation. Tell us what the ground needs.</p>
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
        <p class="home-hero__hours"><?php icon('clock', 14); ?>Office hours <?php echo h($businessHours); ?></p>
      </aside>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<!-- ============ TICKER ============ -->
<div class="ticker-strip home-ticker" aria-hidden="true">
  <div class="ticker-track">
<?php for ($tickerPass = 0; $tickerPass < 2; $tickerPass++): foreach ($tickerItems as $tickerItem): ?>
    <span><?php icon($tickerItem[0], 18); ?><?php echo h($tickerItem[1]); ?></span>
<?php endforeach; endfor; ?>
  </div>
</div>

<!-- ============ SERVICES (featured grid, 5 cards) ============ -->
<section class="section home-services" id="services" aria-label="Excavation contractor services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>What ground work can <span class="text-accent">BDPM Site Services</span> handle on your Plymouth property?</h2>
      <p class="hero-answer">BDPM Site Services handles five kinds of ground work in Plymouth, MA: site construction and excavation, septic system installation, Massachusetts Title 5 inspections, sea walls and helical piers. One contractor covers the dig, the septic system and the structural support underneath it, so the work runs to one schedule.</p>
    </div>

    <div class="services-grid services-grid--featured">
<?php foreach ($services as $cardIndex => $cardSvc):
    $cardData  = $homeCards[$cardSvc['slug']];
    $cardTint  = ($cardIndex % 3) + 1;
    $cardDelay = ($cardIndex % 3) + 1;
?>
      <article class="service-card-with-image card-tint-<?php echo $cardTint; ?> reveal-up reveal-delay-<?php echo $cardDelay; ?>"<?php echo $cardIndex === 0 ? ' data-featured-label="Core service"' : ''; ?>>
        <div class="service-card__body">
          <div class="service-card__icon"><?php icon($cardData['icon'], 26); ?></div>
          <h3><?php echo h($cardSvc['name']); ?></h3>
          <p class="service-card__desc"><?php echo h($cardData['desc']); ?></p>
          <ul>
<?php foreach ($cardData['bullets'] as $cardBullet): ?>
            <li><?php echo h($cardBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($cardSvc['slug']); ?>/" class="service-card__cta" aria-label="Learn more about <?php echo h($cardSvc['name']); ?>">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>

    <div class="home-services__more reveal-up">
      <a href="/services/" class="btn btn-secondary">View All Services</a>
      <p>Not sure which service fits? Describe the job in the estimate form and we will tell you.</p>
    </div>
  </div>
</section>

<!-- ============ PROOF STRIP (verifiable intake facts only) ============ -->
<section class="stats-band texture-grain slant-top home-proof" aria-label="BDPM Site Services at a glance">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="stats-row">
      <div class="stat-item reveal-up reveal-delay-1"><span class="stat-number">Owner-<span>Run</span></span><span class="stat-label"><?php echo h($ownerName); ?>, owner</span></div>
      <div class="stat-item reveal-up reveal-delay-2"><span class="stat-number"><span><?php echo count($services); ?></span> Services</span><span class="stat-label">Excavation through Title 5</span></div>
      <div class="stat-item reveal-up reveal-delay-3"><span class="stat-number">Beaver Dam <span>Rd</span></span><span class="stat-label">Based in <?php echo h($homePlace . ' ' . $address['zip']); ?></span></div>
      <div class="stat-item reveal-up reveal-delay-4"><span class="stat-number">Mon–Fri <span>7–5</span></span><span class="stat-label">Weekday office &amp; crew hours</span></div>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: what's under a Plymouth lot ============ -->
<section class="section edge-curve-top home-ground" aria-labelledby="home-ground-title">
  <div class="container-wide">
    <div class="home-ground__grid">
      <div class="home-ground__intro reveal-left">
        <span class="eyebrow-label">Plymouth Ground</span>
        <h2 id="home-ground-title">What changes an <span class="text-accent">excavation</span> quote in Plymouth?</h2>
        <div class="answer-block">
          <h3>Short answer</h3>
          <p>Soil, ledge, water and permits change a Plymouth excavation quote most. BDPM Site Services checks all four at the site visit, so the equipment, drainage and disposal plan are priced in before work starts.</p>
        </div>
        <p>Plymouth sites range from sandy and gravelly soils to clay, fill and exposed ledge, and many lots sit near wetlands or open water. Two lots on the same street can need different machines and different approvals.</p>
      </div>

      <div class="reveal-right">
        <ol class="strata" aria-label="Ground conditions BDPM Site Services plans for">
          <li class="strata__topsoil"><b>Topsoil &amp; loam</b><p>Stripped and stockpiled at the start of site work so it can go back on at final grade.</p></li>
          <li class="strata__sand"><b>Sand &amp; gravel</b><p>Common on Plymouth lots. Drains well, but trench walls need shoring or sloping as the dig gets deeper.</p></li>
          <li class="strata__clay"><b>Clay &amp; old fill</b><p>Holds water and may have to be hauled away. Matters for drainage, septic layouts and what can be reused on site.</p></li>
          <li class="strata__ledge"><b>Ledge</b><p>Bedrock at or near the surface. Changes the equipment, the schedule and the price, so it is identified before the quote.</p></li>
        </ol>
        <p class="strata-note">Layers vary lot to lot; not every site has all four.</p>
      </div>
    </div>

    <ul class="rules">
      <li class="reveal-up reveal-delay-1"><?php icon('map-pin', 24); ?><h3>Dig Safe first</h3><p>Massachusetts requires a Dig Safe request (811) at least 72 hours before digging, not counting weekends and holidays, so buried utility lines are marked.</p></li>
      <li class="reveal-up reveal-delay-2"><?php icon('trees', 24); ?><h3>Wetlands review</h3><p>Work in wetland resource areas or their buffer zones often goes before the Plymouth Conservation Commission under the Wetlands Protection Act.</p></li>
      <li class="reveal-up reveal-delay-3"><?php icon('droplets', 24); ?><h3>Board of Health</h3><p>Septic installations follow a design approved by the Plymouth Board of Health and are inspected on the board's schedule.</p></li>
    </ul>
  </div>
</section>

<!-- ============ ABOUT / PROCESS (asymmetric) ============ -->
<section class="section home-about" aria-labelledby="home-about-title">
  <span class="floating-ring float-animate-slow home-about__ring" aria-hidden="true"></span>
  <div class="container">
    <div class="about-split">
      <div class="about-left about-copy reveal-left">
        <span class="eyebrow-label">About BDPM Site Services</span>
        <h2 id="home-about-title">A Plymouth excavation contractor run by its owner, <span class="text-accent"><?php echo h($ownerName); ?></span></h2>
        <p>BDPM Site Services is an excavation contractor based at <?php echo h($address['street']); ?> in <?php echo h($homePlace); ?>, owned by <?php echo h($ownerName); ?>. The company does the ground work most property projects start with: digging and grading a site, installing septic systems, building sea walls, setting helical piers and inspecting septic systems under Massachusetts Title 5.</p>
        <p>Because those jobs share the same ground, the same soil questions and often the same permit reviews, BDPM Site Services handles them as one trade. Every job begins with a site visit and ends with the site graded and the paperwork in order.</p>

        <h3 class="sr-only">How a BDPM Site Services job runs</h3>
        <ol class="process-steps">
          <li><b>Site visit</b><span>We walk the property and look at soil, ledge, access, wetlands and where the water goes.</span></li>
          <li><b>Written estimate</b><span>Scope, price and schedule in writing, based on what the site visit found.</span></li>
          <li><b>Dig Safe &amp; approvals</b><span>Utility lines marked through Dig Safe, and any Conservation Commission or Board of Health steps lined up.</span></li>
          <li><b>Dig, build, grade</b><span>The work is done to plan, inspected where required, and the site is left at final grade.</span></li>
        </ol>
      </div>

      <div class="about-right reveal-right">
        <div class="company-card">
          <span class="company-card__mark" aria-hidden="true">BD<span>PM</span></span>
          <h3><?php echo h($siteName); ?></h3>
          <dl>
            <div><dt><?php icon('users', 18); ?><span class="sr-only">Owner</span></dt><dd><?php echo h($ownerName); ?>, owner</dd></div>
            <div><dt><?php icon('map-pin', 18); ?><span class="sr-only">Address</span></dt><dd><?php echo h($address['street'] . ', ' . $homePlace . ' ' . $address['zip']); ?></dd></div>
            <div><dt><?php icon('clock', 18); ?><span class="sr-only">Hours</span></dt><dd><?php echo h($businessHours); ?></dd></div>
            <div><dt><?php icon('phone', 18); ?><span class="sr-only">Phone</span></dt><dd><a href="<?php echo h($homeTel); ?>"><?php echo h($phone); ?></a></dd></div>
          </dl>
        </div>
        <div class="about-stat-card">
          <b>Est. <?php echo (int) $yearEstablished; ?></b>
          <span><?php echo (int) $yearsInBusiness; ?> years working in <?php echo h($address['city']); ?></span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ MID-PAGE CTA (Title 5 before a sale) ============ -->
<section class="cta-banner texture-grain edge-torn-top home-cta" aria-labelledby="home-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring" aria-hidden="true"></span>
  <div class="container-narrow">
    <span class="eyebrow-label">Selling a home with a septic system?</span>
    <h2 id="home-cta-title">Book the <span class="text-accent">Title 5 inspection</span> before you list</h2>
    <p>Massachusetts Title 5 requires a septic system inspection before most property sales. Booking it early means the report is in hand before buyers ask, and any repair can be planned instead of rushed into a closing date.</p>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request a Title 5 inspection</button>
      <a class="link-call" href="<?php echo h($homeTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$homeReviews = p1_google_reviews($slug, ['heading' => 'What ' . $address['city'] . ' customers say on Google']);
if ($homeReviews !== ''): ?>
<section class="section home-reviews" aria-label="Google reviews"><div class="container"><?php echo $homeReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section home-faq" aria-labelledby="home-faq-title">
  <div class="container-wide">
    <div class="section-head section-head--row reveal-up">
      <div>
        <span class="eyebrow-label">Questions</span>
        <h2 id="home-faq-title">What do Plymouth property owners ask before <span class="text-accent">excavation</span> starts?</h2>
        <p>Plymouth property owners most often ask BDPM Site Services about Dig Safe, wetlands permits, excavation cost, septic and Title 5 work, and soil conditions. The answers below cover each one.</p>
      </div>
      <a class="btn btn-secondary" href="/faq/">All FAQs</a>
    </div>
    <div class="faq-grid">
<?php foreach ($homeFaqs as $faqIndex => $homeFaq): ?>
      <details class="faq reveal-up reveal-delay-<?php echo ($faqIndex % 2) + 1; ?>"<?php echo $faqIndex < 2 ? ' open' : ''; ?>>
        <summary><?php echo h($homeFaq['q']); ?></summary>
        <p><?php echo h($homeFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ FROM THE BLOG (auto-pulls $blogPosts[0]) ============ -->
<?php if (!empty($blogPosts)): ?>
<section class="section home-blog" aria-labelledby="home-blog-title">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">From the Blog</span>
      <h2 id="home-blog-title">What do Plymouth property owners need to know before they dig?</h2>
      <p>Plain answers on excavation costs, permits and coastal banks from BDPM Site Services' Plymouth blog.</p>
    </div>
    <div class="home-blog__feature">
<?php echo blogCard($blogPosts[0], ['featured' => true, 'tint' => 3, 'delay' => 1, 'heading' => 'h3']); ?>
    </div>
    <div class="home-blog__more reveal-up">
      <a class="btn btn-secondary" href="/blog/">View All Articles</a>
      <p><?php echo count($blogPosts); ?> articles so far, each answering one question about ground work in Plymouth.</p>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ ESTIMATE SECTION (closing CTA, full form) ============ -->
<section class="section slant-top home-estimate" id="estimate" aria-labelledby="home-estimate-title">
  <div class="container">
    <div class="estimate">
      <div class="card reveal-scale">
        <span class="eyebrow-label">Free estimate</span>
        <h2 id="home-estimate-title">Tell us about the job</h2>
        <p>Send the address and a few lines about the work. BDPM Site Services will call to set up a site visit.</p>
<?php echo renderEstimateForm('estimate-section', 'est', 'Request my estimate'); ?>
      </div>

      <div class="home-estimate__aside reveal-right">
        <h3>What happens next</h3>
        <ol class="next-steps">
          <li><strong>We call you back</strong>During office hours, <?php echo h($businessHours); ?>, to talk through the job.</li>
          <li><strong>Site visit</strong>We look at soil, ledge, access and any wetlands or water on the property.</li>
          <li><strong>Written estimate</strong>Scope, price and schedule in writing before any work is booked.</li>
        </ol>
        <div class="nap">
          <div><?php icon('phone', 18); ?><a href="<?php echo h($homeTel); ?>"><?php echo h($phone); ?></a></div>
          <div><?php icon('mail', 18); ?><a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a></div>
          <div><?php icon('map-pin', 18); ?><span><?php echo h($address['street'] . ', ' . $homePlace . ' ' . $address['zip']); ?></span></div>
        </div>
        <p class="home-estimate__area">BDPM Site Services is an excavation contractor based in <?php echo h($homePlace); ?>, serving Plymouth and the surrounding area.</p>
      </div>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
