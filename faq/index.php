<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /faq/ — Phase 5 FAQ page (directory + index.php; linked from the footer "Company" column and the homepage "All FAQs" button).
 * 18 questions in 4 categories. The six customer questions in build-plan research_brief.faqs are reused with the same facts as the homepage
 * and service pages; the rest repeat facts those pages already publish and source (Title 5 windows, 110 gpd per bedroom, 1978 coastal rule,
 * helical-pier use). Owner/year/residential-commercial/no-cost-estimate statements match the homepage and are listed for confirmation in
 * /content-confirmations.json. No prices, license, insurance or response-time claims because intake holds none.
 * Lead form: ONE mid-page .cta-band after the first category (v6.3 placement rule), form id `cta-band`; no hero form on FAQ.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$pageTitle       = 'FAQ: Excavation, Septic & Title 5 | ' . $siteName;
$pageDescription = 'Answers from ' . $siteName . ' on Dig Safe, wetlands permits, excavation cost, septic, Title 5 inspections, sea walls and helical piers in Plymouth, MA.';
$canonicalUrl    = $siteUrl . '/faq/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'faq';
$pageType        = 'faq';
$faqHeroPhoto = 'site-team-planning-blueprints-table';   // registry name (includes/photos.php) — photo hero, LCP preloaded
$heroPreload     = photoHeroPreload($faqHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'FAQ', 'url' => '/faq/'],
];

$faqTel   = formatPhone($phone, 'tel');
$faqPlace = $address['city'] . ', ' . $address['state'];

// Categories: id, label, icon, intro (answer-first, names the company), questions
$faqCats = [
    ['id' => 'general', 'label' => 'General', 'icon' => 'info',
     'title' => 'Who is BDPM Site Services and where does it work?',
     'intro' => 'BDPM Site Services is an owner-run excavation contractor in Plymouth, MA. These answers cover where the company works, what it does and how to reach it.',
     'items' => [
        ['q' => 'Where is BDPM Site Services located and what area does it serve?',
         'a' => 'BDPM Site Services is an excavation contractor based at ' . $address['street'] . ' in ' . $faqPlace . ' ' . $address['zip'] . ', and it serves Plymouth and the surrounding area. If your property is in a nearby town, call ' . $phone . ' and ask whether the job is within reach.'],
        ['q' => 'What services does BDPM Site Services offer?',
         'a' => 'BDPM Site Services offers five services in Plymouth: site construction and excavation, septic system installation, Massachusetts Title 5 inspections, sea walls and helical piers. All five are ground work, so one contractor can handle the dig, the septic system and the support underneath it.',
         'link' => ['/services/', 'See all five services']],
        ['q' => 'Does BDPM Site Services work on residential and commercial properties?',
         'a' => 'Yes. BDPM Site Services takes on residential and commercial properties in Plymouth. Describe the property and the work when you call or fill out the form, and the site visit confirms whether the job is a fit.'],
        ['q' => 'Who owns and runs BDPM Site Services?',
         'a' => $ownerName . ' owns BDPM Site Services, and the company is owner-run. It has worked in Plymouth since ' . (int) $yearEstablished . '.',
         'link' => ['/about/', 'About BDPM Site Services']],
        ['q' => 'What are the office hours and how do I reach BDPM Site Services?',
         'a' => 'BDPM Site Services is open ' . $businessHours . '. Call ' . $phone . ', email ' . $email . ', or use the form on the contact page.',
         'link' => ['/contact/', 'Go to the contact page']],
     ]],
    ['id' => 'services', 'label' => 'Services', 'icon' => 'tractor',
     'title' => 'What can BDPM Site Services build, install and inspect?',
     'intro' => 'BDPM Site Services handles septic systems, Title 5 inspections, sea walls and helical piers along with general excavation. Each answer below links to the full service page.',
     'items' => [
        ['q' => 'Do you install septic systems and do Title 5 inspections?',
         'a' => 'Yes. BDPM Site Services installs septic systems and performs Massachusetts Title 5 inspections in Plymouth. Installations follow the system design approved by the Plymouth Board of Health, and the work is inspected on the board\'s schedule.',
         'link' => ['/services/septic-system-installation/', 'Septic system installation']],
        ['q' => 'When is a Title 5 inspection required in Massachusetts?',
         'a' => 'A Title 5 inspection is required before most Massachusetts property transfers that involve a septic system. It must be done within two years before the sale, or within three years if the tank has been pumped every year and the records are kept. Transfers between close family members generally do not need one.',
         'link' => ['/services/title-5-inspections/', 'Title 5 inspections']],
        ['q' => 'What types of soil and site conditions does BDPM Site Services deal with?',
         'a' => 'Plymouth sites vary widely, from sandy and gravelly soils to clay, fill and exposed ledge. BDPM Site Services assesses each site during the estimate so the right equipment, drainage and disposal plan are included in the quote before work begins.',
         'link' => ['/services/site-construction-excavation/', 'Site construction and excavation']],
        ['q' => 'Can I get a sea wall on my Plymouth waterfront property?',
         'a' => 'Possibly, but a new sea wall is allowed only in specific cases. Massachusetts permits a new wall at a coastal bank mainly to protect a building built before August 10, 1978, and the Plymouth Conservation Commission reviews the project. BDPM Site Services looks at the shoreline during the estimate and explains what review is likely.',
         'link' => ['/services/sea-walls/', 'Sea walls']],
        ['q' => 'What is a helical pier and when is it used instead of a concrete footing?',
         'a' => 'A helical pier is a steel shaft with helical plates that is screwed into the ground until it reaches firm soil. It is the better choice when the soil at footing depth is loose, wet or old fill, when access is tight, or when the job cannot wait for concrete to cure.',
         'link' => ['/services/helical-piers/', 'Helical piers']],
     ]],
    ['id' => 'pricing', 'label' => 'Pricing', 'icon' => 'clipboard-list',
     'title' => 'How does BDPM Site Services price excavation and septic work?',
     'intro' => 'BDPM Site Services prices each job in writing after a site visit, because the ground on your lot sets the price. These answers explain what moves the number.',
     'items' => [
        ['q' => 'How much does excavation cost in Plymouth?',
         'a' => 'Excavation pricing depends on the size of the job, soil and ledge conditions, site access, how much material must be hauled away, and the timeline. BDPM Site Services gives a written estimate after a site visit, with the scope, price and schedule spelled out.'],
        ['q' => 'Are estimates from BDPM Site Services free?',
         'a' => 'Yes. BDPM Site Services gives free estimates for excavation, septic, sea wall and helical pier work in Plymouth. The estimate starts with a site visit, so the price reflects the soil, access and permits on your lot. For a Title 5 inspection, ask for the fee when you call.'],
        ['q' => 'What does a written estimate from BDPM Site Services include?',
         'a' => 'A written estimate from BDPM Site Services states the scope of work, the price and the schedule, based on what the site visit found about soil, ledge, access and water. You receive it in writing before any work is booked.'],
        ['q' => 'Why does the price of a septic or excavation job change from lot to lot?',
         'a' => 'Two lots on the same street can need different machines and different approvals. Ledge, groundwater, clay or old fill, and the distance to a well or wetland all change the work. Under Title 5, a septic system is sized by bedroom count at 110 gallons per day per bedroom, so the house changes the system as much as the soil does.'],
     ]],
    ['id' => 'process', 'label' => 'Process', 'icon' => 'route',
     'title' => 'What happens between the first call and final grade?',
     'intro' => 'A BDPM Site Services job runs from a site visit to final grade, with Dig Safe and any permit reviews in between. These answers cover the steps owners ask about most.',
     'items' => [
        ['q' => 'Do I need to call Dig Safe before digging in Plymouth?',
         'a' => 'Yes. In Massachusetts, you must contact Dig Safe by calling 811 or 1-888-344-7233 before any excavation, and utility companies then mark their underground lines. Dig Safe requires notice at least 72 hours before digging, not counting weekends and holidays. BDPM Site Services confirms the markings are in place before any work begins.'],
        ['q' => 'Will my project need a wetlands or conservation permit in Plymouth?',
         'a' => 'It may. Work within wetland resource areas or their buffer zones is regulated under the Massachusetts Wetlands Protection Act and local bylaws, which often means review by the Plymouth Conservation Commission. Tell BDPM Site Services about the property during your estimate and we will explain what review is likely before any work is scheduled.'],
        ['q' => 'What happens during an excavation job, from first call to final grade?',
         'a' => 'A BDPM Site Services job has four steps: a site visit, a written estimate, Dig Safe and any approvals, then the dig, build and grade. The work is inspected where required, and the site is left at final grade.'],
        ['q' => 'Do I need a septic design before BDPM Site Services can install a system?',
         'a' => 'Yes. A Plymouth septic installation starts with a soil test and a design from a licensed professional, approved by the Board of Health before any digging. BDPM Site Services builds to that approved plan, and the town inspects the system before it is backfilled.'],
     ]],
];

// Flat list for the FAQPage schema — every visible question, same wording
$faqAll = [];
// 'Are estimates ... free?' is left out of the schema: intake does not confirm the no-cost estimate yet (content-confirmations.json). Visible copy is unchanged.
foreach ($faqCats as $faqCatRow) foreach ($faqCatRow['items'] as $faqItemRow) {
    if (preg_match('/estimates?\b.*\bfree\b/i', $faqItemRow['q'])) continue;
    $faqAll[] = ['q' => $faqItemRow['q'], 'a' => $faqItemRow['a']];
}

$schemaMarkup = [
    generateFAQSchema($faqAll),
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => $canonicalUrl . '#webpage',
        'url' => $canonicalUrl,
        'name' => $pageTitle,
        'description' => $pageDescription,
        'isPartOf' => ['@type' => 'WebSite', 'url' => rtrim($siteUrl, '/') . '/'],
        'about' => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   FAQ — page composition (tokens only). Motif: the index tab — each category
   is a tabbed file section with its own question stack.
   ========================================================================== */
.faqpage h1, .faqpage h2, .faqpage h3 { text-wrap: balance; }
.faqpage p, .faqpage summary { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + ruled lines ---- */
.faq-hero .hero-bg img { object-position: 50% 40%; }
.faq-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 50% 70% at 0% 0%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              radial-gradient(ellipse 40% 60% at 100% 100%, color-mix(in srgb, var(--color-secondary) 30%, transparent), transparent 70%);
}
.faq-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.faq-hero__lines { position: absolute; inset: 0; z-index: -1; pointer-events: none; background: repeating-linear-gradient(180deg, transparent 0 31px, color-mix(in srgb, var(--color-white) 6%, transparent) 31px 32px); -webkit-mask: linear-gradient(90deg, transparent 35%, var(--color-black) 80%); mask: linear-gradient(90deg, transparent 35%, var(--color-black) 80%); }
.faq-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.faq-hero .breadcrumb a:hover { color: var(--color-white); }
.faq-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.faq-hero .hero-copy { max-width: 46rem; }
.faq-hero .hero-title { max-width: 26ch; }
.faq-hero .text-accent { color: var(--color-accent-bright); }
.faq-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.faq-hero .link-call svg { color: var(--color-accent-bright); }
.faq-hero .link-call:hover { color: var(--color-white); }
.faq-hero .hero-chips a { display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; color: inherit; text-decoration: none; }
.faq-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 7%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); transition: background var(--transition), border-color var(--transition); }
.faq-hero .hero-chips li:hover { background: color-mix(in srgb, var(--color-white) 14%, transparent); border-color: var(--color-accent-bright); }
.faq-hero .hero-chips svg { color: var(--color-accent-bright); }

/* ---- Category sections: intro (sticky) beside the question stack, sides alternate ---- */
.faq-cat { scroll-margin-top: var(--nav-height); }
.faq-cat--paper { background: var(--color-paper); }
.faq-cat--paper-2 { background: var(--color-paper-2); }
.faq-cat__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.faq-cat--flip .faq-cat__grid { grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); }
.faq-cat--flip .faq-cat__intro { order: 2; }
.faq-cat__intro { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); display: grid; gap: var(--space-md); }
.faq-cat__intro .answer-block { margin: 0; background: var(--color-surface); }
.faq-cat__tab { display: inline-flex; align-items: center; gap: var(--space-xs); width: fit-content; padding: var(--space-1) var(--space-md) var(--space-1) var(--space-sm); border-radius: var(--radius-full); background: var(--color-card-tint-3); border: 1px solid color-mix(in srgb, var(--color-accent) 30%, var(--color-line)); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.faq-cat__count { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .1em; text-transform: uppercase; color: var(--color-muted); }
.faq-cat__stack { display: grid; gap: var(--space-sm); }
.faq-cat details.faq { padding: 0; background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: box-shadow var(--transition), border-color var(--transition); }
.faq-cat details.faq:hover { box-shadow: var(--shadow); }
.faq-cat details.faq[open] { border-color: color-mix(in srgb, var(--color-accent) 40%, var(--color-line)); border-left: 4px solid var(--color-accent); }
.faq-cat details.faq summary { min-height: 56px; padding: var(--space-md) var(--space-lg); }
.faq-cat details.faq[open] summary { color: var(--color-primary); }
.faq-cat details.faq p { margin: 0; padding: 0 var(--space-lg) var(--space-sm); }
.faq-cat details.faq .faq-more { display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; margin: 0 var(--space-lg) var(--space-sm); color: var(--color-accent-dark); font-weight: 700; font-size: var(--fs-small); text-decoration: underline; text-underline-offset: .15em; }

/* ---- Mid-page estimate band (compact lead form, v6.3 placement: after the first content section) ---- */
.cta-band { padding-block: clamp(2.5rem, 6vw, 4rem); }
.cta-band__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 2fr); gap: clamp(1.5rem, 4vw, 3rem); align-items: center; }
.cta-band__copy { display: grid; gap: var(--space-sm); align-content: center; }
.cta-band__copy h2 { margin: 0; font-size: var(--fs-h3); }
.cta-band__copy p { margin: 0; font-size: var(--fs-small); }
.cta-band .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.cta-band .link-call svg { color: var(--color-accent-bright); }
.cta-band .cta-band__card { padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-ink); border-top: 4px solid var(--color-accent); box-shadow: var(--shadow-lg); }
.cta-band .cta-band__card p, .cta-band .cta-band__card label { color: var(--color-ink-2); }
.cta-band__form { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm) var(--space-md); align-items: end; }
.cta-band__form .field { min-width: 0; }
.cta-band__form .field--btn { grid-column: span 2; }
.cta-band__form .btn { width: 100%; }
.cta-band__form .consent { grid-column: span 2; margin: 0; font-size: var(--font-size-xs); }
.cta-band__form .consent a { text-decoration: underline; text-underline-offset: .15em; }
.cta-band__form .cta-band__note { margin: 0; font-size: var(--font-size-xs); color: var(--color-muted); }
.cta-band .cta-band__card .cta-band__note { color: var(--color-muted); }

/* ---- Closing CTA ---- */
@media (min-width: 801px) { .faq-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; } }
.faq-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.faq-cta .link-call svg { color: var(--color-accent-bright); }
.faq-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.faq-cta .floating-ring { right: -5rem; bottom: -9rem; opacity: .1; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .faq-cat__grid, .faq-cat--flip .faq-cat__grid { grid-template-columns: 1fr; }
  .faq-cat--flip .faq-cat__intro { order: 0; }
  .faq-cat__intro { position: static; }
  .cta-band__grid { grid-template-columns: 1fr; }
}
@media (max-width: 700px) {
  .cta-band__form { grid-template-columns: 1fr; }
  .cta-band__form .field--btn, .cta-band__form .consent { grid-column: auto; }
  .faq-cat details.faq summary { padding: var(--space-md); }
  .faq-cat details.faq p { padding-inline: var(--space-md); }
  .faq-cat details.faq .faq-more { margin-inline: var(--space-md); }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="faqpage">

<!-- ============ HERO (interior, no form — the estimate band sits after the first category) ============ -->
<section class="hero hero--interior hero--photo faq-hero" aria-labelledby="faq-hero-title">
  <div class="hero-bg"><?php echo photoPicture($faqHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <span class="faq-hero__lines" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li aria-current="page">FAQ</li>
        </ol>
      </nav>
      <span class="eyebrow">FAQ · <?php echo h($faqPlace); ?></span>
      <h1 class="hero-title" id="faq-hero-title">Plymouth <span class="text-accent">excavation, septic and Title 5</span> questions, answered</h1>
      <p class="hero-answer">Answers from <?php echo h($siteName); ?> to <?php echo count($faqAll); ?> common questions about excavation, septic systems, Title 5 inspections, sea walls and helical piers in Plymouth, MA.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="<?php echo h($faqTel); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
        <a class="link-call" href="/contact/"><?php icon('send', 18); ?>Ask your own question</a>
      </div>
      <ul class="hero-chips" aria-label="Jump to a category">
<?php foreach ($faqCats as $faqCatChip): ?>
        <li><a href="#faq-<?php echo h($faqCatChip['id']); ?>"><?php icon($faqCatChip['icon'], 16); ?><?php echo h($faqCatChip['label']); ?> · <?php echo count($faqCatChip['items']); ?></a></li>
<?php endforeach; ?>
      </ul>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<?php foreach ($faqCats as $faqCatI => $faqCat): ?>
<!-- ============ <?php echo strtoupper($faqCat['label']); ?> ============ -->
<section class="section faq-cat <?php echo $faqCatI % 2 === 0 ? 'faq-cat--paper' : 'faq-cat--paper-2 faq-cat--flip'; ?><?php echo $faqCatI === 1 ? ' slant-top' : ($faqCatI === 3 ? ' edge-curve-top' : ''); ?>" id="faq-<?php echo h($faqCat['id']); ?>" aria-labelledby="faq-<?php echo h($faqCat['id']); ?>-title">
  <div class="container-wide">
    <div class="faq-cat__grid">
      <div class="faq-cat__intro <?php echo $faqCatI % 2 === 0 ? 'reveal-left' : 'reveal-right'; ?>">
        <span class="faq-cat__tab"><?php icon($faqCat['icon'], 16); ?><?php echo h($faqCat['label']); ?></span>
        <h2 id="faq-<?php echo h($faqCat['id']); ?>-title"><?php echo h($faqCat['title']); ?></h2>
        <p class="answer-block"><?php echo h($faqCat['intro']); ?></p>
        <span class="faq-cat__count"><?php echo count($faqCat['items']); ?> questions</span>
      </div>
      <div class="faq-cat__stack">
<?php foreach ($faqCat['items'] as $faqI => $faqItem): ?>
        <details class="faq reveal-up reveal-delay-<?php echo ($faqI % 3) + 1; ?>"<?php echo $faqI === 0 ? ' open' : ''; ?>>
          <summary><?php echo h($faqItem['q']); ?></summary>
          <p><?php echo h($faqItem['a']); ?></p>
<?php if (!empty($faqItem['link'])): ?>
          <a class="faq-more" href="<?php echo h($faqItem['link'][0]); ?>"><?php echo h($faqItem['link'][1]); ?> <?php icon('arrow-right', 16); ?></a>
<?php endif; ?>
        </details>
<?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php if ($faqCatI === 0): ?>

<!-- ============ MID-PAGE ESTIMATE BAND (one lead form on this page, id cta-band) ============ -->
<section class="cta-band texture-grain edge-torn-top" id="estimate" aria-labelledby="cta-band-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-band__grid">
      <div class="cta-band__copy">
        <span class="eyebrow-label">Written estimate</span>
        <h2 id="cta-band-title">Have a question about your lot?</h2>
        <p>Send the basics and <?php echo h($siteName); ?> will call you back during office hours.</p>
        <a class="link-call" href="<?php echo h($faqTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
      <div class="cta-band__card">
        <form action="<?php echo h($formAction); ?>" method="POST" class="estimate-form cta-band__form" id="cta-band-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="cta-band">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('cta-band'); ?>
          <div class="field"><label for="cta-name">Name *</label><input id="cta-name" type="text" name="name" autocomplete="name" required></div>
          <div class="field"><label for="cta-phone">Phone *</label><input id="cta-phone" type="tel" name="phone" autocomplete="tel" required></div>
          <div class="field"><label for="cta-email">Email *</label><input id="cta-email" type="email" name="email" autocomplete="email" required></div>
          <div class="field"><label for="cta-service">Service needed</label><select id="cta-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <div class="field field--btn"><button type="submit" class="btn btn-primary btn-lg">Send my request</button></div>
          <label class="consent" for="cta-terms"><input id="cta-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <p class="cta-band__note">Office hours <?php echo h($businessHours); ?>.</p>
        </form>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
<?php endforeach; ?>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-wave-top faq-cta" aria-labelledby="faq-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Still have a question?</span>
      <h2 id="faq-cta-title">Ask BDPM Site Services about your Plymouth property</h2>
      <p>Every lot is different. Call or send the contact form and BDPM Site Services will answer for your lot, not a generic one.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="/contact/">Contact BDPM Site Services</a>
      <a class="link-call" href="<?php echo h($faqTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
