<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
?>
<?php
/**
 * /blog/what-drives-excavation-cost-plymouth-ma/ — launch post 1 (cost guide). Metadata comes from the registry entry; nothing here is hardcoded twice.
 * NO dollar figures: intake holds no pricing and the client has approved no range (blog-standard.md §7). The post explains what moves a price instead.
 * Facts and sources (checked 2026-10-19):
 *   Written estimate after a site visit, itemized scope / price / schedule; price drivers (size, soil and ledge, access, haul-away, timeline) — build-plan research_brief.faqs
 *   Dig Safe 811 / 1-888-344-7233, 72 hours not counting weekends and holidays, ticket good for 30 days — https://www.mass.gov/guides/about-dig-safe, 220 CMR 99.00
 *   Frost line 48 in — 780 CMR (10th ed.) Table R301.2(1); trenches 5 ft and deeper need a protective system unless in stable rock — 29 CFR 1926.652
 *   Pinelands, hilly forested west, Myles Standish State Forest — https://en.wikipedia.org/wiki/Plymouth,_Massachusetts
 *   Outwash sand and gravel, kettle ponds below the water table — https://www.wildlandstrust.org/news-blog/tag/Halfway+Pond+Conservation+Area, https://grotontrails.org/our-icy-past/
 *   Conservation Commission review + Plymouth Wetland Bylaw setbacks (50 ft no-build / 35 ft no-touch seen in agendas; current text not retrieved)
 * Author is Page One Insights LLC, never an invented person. The post claims no licence, insurance, years, response time or past-job frequency.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$bpSlug = 'what-drives-excavation-cost-plymouth-ma';
$bpPost = blogPostBySlug($bpSlug);

$pageTitle       = $bpPost['title'];
$pageDescription = 'What moves an excavation price on a Plymouth, MA lot: soil and ledge, machine access, haul-away, Dig Safe and wetlands review, and how to compare estimates.';
$canonicalUrl    = $siteUrl . '/blog/' . $bpSlug . '/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'blog';
$pageType        = 'blog';
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog/'],
    ['name' => $bpPost['title'], 'url' => '/blog/' . $bpSlug . '/'],
];

$bpTel  = formatPhone($phone, 'tel');
$bpBase = rtrim($siteUrl, '/');

$bpFaqs = [
    ['q' => 'How much does excavation cost in Plymouth?',
     'a' => 'Pricing depends on the size of the job, soil and ledge conditions, site access, how much material must be hauled away, and the timeline. BDPM Site Services provides a written estimate after a site visit, with the scope, price and schedule itemized so there are no surprises.'],
    ['q' => 'Can BDPM Site Services quote an excavation job over the phone?',
     'a' => 'BDPM Site Services gives a written estimate after a site visit rather than a number over the phone, because the soil, the ledge, the access and the water on a Plymouth lot are what set the price. Call ' . $phone . ' to book the visit.'],
    ['q' => 'Do I need to call Dig Safe before digging in Plymouth?',
     'a' => 'Yes. In Massachusetts you must contact Dig Safe by calling 811 or 1-888-344-7233 before any excavation. Utility companies then mark their underground lines. Dig Safe requires notice at least 72 hours before digging, not counting weekends and holidays. Ask at your estimate who files the request for your job.'],
];

$bpToc = [
    ['bp-estimate', 'What does a Plymouth excavation estimate include?'],
    ['bp-ground',   'How do Plymouth soils and ledge change the price?'],
    ['bp-access',   'Does access and haul-away matter as much as the digging?'],
    ['bp-approvals', 'How do Dig Safe and wetlands review affect the schedule?'],
    ['bp-compare',  'How do I compare two excavation estimates?'],
    ['bp-faq',      'Common questions about excavation costs in Plymouth'],
];

$schemaMarkup = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        '@id' => $canonicalUrl . '#article',
        'headline' => $bpPost['title'],
        'description' => $pageDescription,
        'datePublished' => $bpPost['dateISO'],
        'dateModified' => $bpPost['dateISO'],
        'keywords' => 'excavation cost Plymouth MA, site excavation, excavation contractor, Dig Safe, soil excavation, rock excavation',
        'inLanguage' => 'en-US',
        'mainEntityOfPage' => $canonicalUrl,
        'author' => ['@type' => 'Organization', 'name' => 'Page One Insights LLC', 'url' => 'https://pageoneinsights.com'],
        'publisher' => ['@id' => $bpBase . '/#organization'],
        'about' => ['@id' => $bpBase . '/#organization'],
    ],
    generateFAQSchema($bpFaqs),
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Post: what drives excavation cost — page composition (tokens only).
   Motif: a cut section of ground (strata lines) behind the hero.
   ========================================================================== */
.bp h1, .bp h2, .bp h3 { text-wrap: balance; }
<?php echo blogPostStyles(); ?>
<?php echo blogCardStyles(); ?>

.bp-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: repeating-linear-gradient(178deg, transparent 0 22px, color-mix(in srgb, var(--color-white) 6%, transparent) 22px 24px, transparent 24px 52px, color-mix(in srgb, var(--color-accent) 20%, transparent) 52px 53px),
              radial-gradient(ellipse 55% 70% at 88% 6%, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%);
  -webkit-mask: linear-gradient(180deg, var(--color-black) 30%, transparent 100%); mask: linear-gradient(180deg, var(--color-black) 30%, transparent 100%);
}
.bp-steps { counter-reset: bpstep; list-style: none; padding: 0; margin: var(--space-md) 0; }
.bp-steps li { counter-increment: bpstep; position: relative; padding: var(--space-md) var(--space-lg) var(--space-md) 3.5rem; border-radius: var(--radius); background: var(--color-card-tint-1); border-left: 4px solid var(--color-accent); }
.bp-steps li:nth-child(even) { background: var(--color-card-tint-3); }
.bp-steps li::before { content: counter(bpstep); position: absolute; left: var(--space-md); top: var(--space-md); width: 1.9rem; height: 1.9rem; display: grid; place-items: center; border-radius: var(--radius-full); background: var(--color-primary); color: var(--color-white); font-family: var(--font-accent); font-weight: 700; }
.bp-facts { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-sm); margin: var(--space-md) 0; padding: 0; list-style: none; }
.bp-facts li { padding: var(--space-md); border-radius: var(--radius); background: var(--color-surface); border: 1px solid var(--color-line); border-bottom: 3px solid var(--color-secondary); font-size: var(--fs-small); }
.bp-facts li b { display: block; font-family: var(--font-heading); color: var(--color-ink); }
@media (max-width: 600px) { .bp-facts { grid-template-columns: 1fr; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="bp">

<!-- ============ HERO ============ -->
<section class="hero hero--interior bp-hero" aria-labelledby="bp-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li><a href="/blog/">Blog</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li aria-current="page">Excavation costs</li>
      </ol>
    </nav>
    <span class="eyebrow bp-hero__cat"><?php echo h($bpPost['category']); ?></span>
    <h1 class="hero-title blog-post__title" id="bp-title"><?php echo h($bpPost['title']); ?></h1>
    <p class="blog-post__meta"><span><time datetime="<?php echo h($bpPost['dateISO']); ?>"><?php echo h($bpPost['date']); ?></time></span><span><?php echo h($bpPost['readtime']); ?></span><span>Published by Page One Insights LLC</span></p>
    <div class="hero-actions">
      <button type="button" class="btn btn-primary btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="link-call" href="<?php echo h($bpTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<article class="blog-post" aria-labelledby="bp-title">

<!-- ============ PART A: answer-first intro + first H2 ============ -->
<section class="bp-body" aria-label="Article introduction">
  <div class="container-wide">
    <div class="bp-layout">
      <div class="blog-post__content">
        <p class="answer-block">Five things set the price of excavation on a Plymouth lot: how much ground moves, the soil and ledge, machine access, how much material is hauled away, and the approvals needed. BDPM Site Services prices them in writing after a site visit.</p>
        <p>This guide gives no dollar figures on purpose. A Plymouth lot in the pinelands and a lot on a coastal bank can need the same hole and cost very different amounts to dig, and a number quoted before anyone has seen the ground is a guess. What you can compare is whether an estimate spells out those five things.</p>

        <h2 id="bp-estimate">What does a Plymouth excavation estimate include?</h2>
        <p>A <a href="/services/site-construction-excavation/">site construction and excavation</a> estimate from BDPM Site Services comes after a site visit and is written down with three parts itemized: the scope, the price and the schedule.</p>
        <ul>
          <li><strong>Scope</strong> is what gets dug and where: the footprint, the depth, what is backfilled, what leaves the site and what the lot looks like when the crew is done.</li>
          <li><strong>Price</strong> is itemized, so you can see which part of the job carries the cost rather than one lump number.</li>
          <li><strong>Schedule</strong> is a start window and the steps it depends on, such as the Dig Safe wait and any Conservation Commission or Board of Health review.</li>
        </ul>
        <p>The visit comes first because the estimate depends on what the crew finds: soil, ledge, access and water. Everything below explains how each one moves the price.</p>
      </div>
      <aside class="bp-aside bp-aside--toc" aria-label="Article navigation">
        <nav class="bp-toc" aria-labelledby="bp-toc-title">
          <h2 id="bp-toc-title">In this article</h2>
          <ol>
<?php foreach ($bpToc as $bpT): ?>
            <li><a href="#<?php echo h($bpT[0]); ?>"><?php echo h($bpT[1]); ?></a></li>
<?php endforeach; ?>
          </ol>
        </nav>
      </aside>
    </div>
  </div>
</section>

<!-- ============ MID-PAGE ESTIMATE BAND (the one lead form on this page, id cta-band) ============ -->
<section class="cta-band texture-grain edge-torn-top" id="estimate" aria-labelledby="cta-band-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-band__grid">
      <div class="cta-band__copy">
        <span class="eyebrow-label">Free estimate</span>
        <h2 id="cta-band-title">Want a written estimate for your lot?</h2>
        <p>Send the basics and <?php echo h($siteName); ?> will call you back during office hours.</p>
        <a class="link-call" href="<?php echo h($bpTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
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
          <div class="field field--btn"><button type="submit" class="btn btn-primary btn-lg">Get my free estimate</button></div>
          <label class="consent" for="cta-terms"><input id="cta-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <p class="cta-band__note">Office hours <?php echo h($businessHours); ?>.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============ PART B: remaining sections ============ -->
<section class="bp-body bp-body--b" aria-label="Article body">
  <div class="container-wide">
    <div class="bp-layout">
      <div class="blog-post__content">

        <h2 id="bp-ground">How do Plymouth soils and ledge change the price?</h2>
        <p class="answer-block">Soil and ledge change the price because they decide the equipment, the speed and the support a trench needs. Sand digs fast but caves; clay and fill dig slower; ledge needs different equipment and cannot be priced until it is found.</p>
        <p>Plymouth is the largest town in Massachusetts by area, and the ground is not one thing. Much of the inland town sits in the Plymouth Pinelands, hilly and forested, on sand and gravel that retreating glaciers left about 14,000 years ago. Ponds mark where buried ice melted, and a low lot beside one can hold water close to the surface. Closer to the coast, and on lots built up decades ago, the same depth can turn up clay, buried fill or boulders.</p>
        <ul class="bp-facts" aria-label="How ground conditions affect an excavation price">
          <li><b>Loose sand and gravel</b>Quick to dig. Deep trenches still need support, and trenches 5 feet deep or more generally need a protective system under federal OSHA rules unless they are cut in stable rock.</li>
          <li><b>Clay, fill and boulders</b>Slower to dig and harder to predict, and fill can hide old debris that has to be hauled away.</li>
          <li><b>Ledge</b>Solid rock needs different equipment and more time, and it often cannot be confirmed until the ground is probed or opened.</li>
          <li><b>Frost depth</b>Footings in Massachusetts go below a 48-inch frost line, which sets a minimum depth for a foundation dig.</li>
        </ul>
        <p>That is why BDPM Site Services will not price the dig from a phone call. Describe the lot, then let the site visit confirm what the ground is.</p>

        <h2 id="bp-access">Does access and haul-away matter as much as the digging?</h2>
        <p class="answer-block">Often it matters as much. The price follows the machine hours and truck trips, so a tight driveway, a long carry to the dig or a lot that cannot keep its own spoil adds cost that the hole alone does not show.</p>
        <p>Three questions shape that part of the estimate. Can an excavator and a dump truck reach the work without damaging a septic system, a well or a stand of trees? How much of the material dug out can stay on the lot for grading, and how much must leave? And what has to come back in: gravel, loam or a drainage layer? A <a href="/services/septic-system-installation/">septic system installation</a> adds its own version of the same question, because the old soil, the new fill and the final grade all have to line up with the approved design.</p>

        <h2 id="bp-approvals">How do Dig Safe and wetlands review affect the schedule?</h2>
        <p class="answer-block">They change the start date more than the price. Dig Safe needs notice at least 72 hours before digging, not counting weekends and holidays, and work near wetlands or a coastal bank can add Conservation Commission review before any machine arrives.</p>
        <p>In Massachusetts a Dig Safe request goes in through 811 or 1-888-344-7233, and utilities then mark their underground lines. The ticket is good for 30 days, and digging outside the marked area breaks the law, so the request has to match the work. BDPM Site Services confirms the markings before any work begins.</p>
        <p>Wetlands are a separate track. Work in a wetland resource area or its buffer zone can require a filing with the Plymouth Conservation Commission, and Plymouth's local wetland bylaw has its own setbacks beyond the state rules, so read the current text for your lot. The same review applies at the water's edge, which is why a <a href="/blog/nor-easter-season-plymouth-coastal-bank/">coastal bank repair starts at the Conservation Commission</a> rather than with a machine. Septic work goes through the Plymouth Board of Health, which inspects a new system before it is backfilled. None of these steps is a price line by itself, but each one can hold the start date, and an estimate that ignores them has a schedule that will move. The <a href="/service-areas/plymouth/">Plymouth service area page</a> walks through all three.</p>

        <h2 id="bp-compare">How do I compare two excavation estimates?</h2>
        <p class="answer-block">Compare scope before price. Two estimates are only comparable when they dig the same footprint to the same depth and include the same haul-away, backfill and final grade.</p>
        <ol class="bp-steps">
          <li><strong>Same scope?</strong> Match the footprint, depth and what the lot looks like when the crew leaves.</li>
          <li><strong>Haul-away and fill.</strong> Ask whether trucking material off the lot and bringing gravel or loam in are included.</li>
          <li><strong>Ledge and surprises.</strong> Ask what happens to the price if rock, buried fill or water turns up, and how a change is agreed in writing.</li>
          <li><strong>Dig Safe and permits.</strong> Ask who files the Dig Safe request and who handles any Conservation Commission or Board of Health paperwork.</li>
          <li><strong>Schedule.</strong> Ask for a start window and what it depends on.</li>
        </ol>
        <p>An estimate that answers those five points can be compared line by line. One that does not is a number without a job attached. To see what the full list of work looks like under one contractor, read about <a href="/services/">BDPM Site Services' five ground trades</a>.</p>

        <section class="bp-faq" aria-labelledby="bp-faq">
          <h2 id="bp-faq">Common questions about excavation costs in Plymouth</h2>
<?php foreach ($bpFaqs as $bpFaq): ?>
          <details class="faq">
            <summary><?php echo h($bpFaq['q']); ?></summary>
            <p class="faq-answer"><?php echo h($bpFaq['a']); ?></p>
          </details>
<?php endforeach; ?>
        </section>

        <p class="bp-byline">Published by Page One Insights LLC for <?php echo h($siteName); ?>. Last updated <?php echo h($bpPost['date']); ?>. General information, not engineering or legal advice; confirm requirements for your lot with the Plymouth Conservation Commission and Board of Health.</p>
      </div>

      <aside class="bp-aside" aria-label="Contact and related pages">
        <div class="bp-side-cta">
          <h2>Talk to a Plymouth excavator</h2>
          <p><?php echo h($siteName); ?> sends a written estimate after a site visit. Office hours <?php echo h($businessHours); ?>.</p>
          <button type="button" class="btn btn-accent" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="<?php echo h($bpTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        </div>
        <nav class="bp-side-links" aria-labelledby="bp-side-links-title">
          <h2 id="bp-side-links-title">Related pages</h2>
          <ul>
            <li><a href="/services/site-construction-excavation/">Site construction &amp; excavation</a></li>
            <li><a href="/service-areas/plymouth/">Excavation in Plymouth, MA</a></li>
            <li><a href="/faq/">Frequently asked questions</a></li>
          </ul>
        </nav>
      </aside>
    </div>
  </div>
</section>

<!-- ============ RELATED SERVICES + RELATED ARTICLES ============ -->
<section class="bp-more" aria-label="Related services and articles">
  <div class="container">
    <div class="blog-post__related-services">
      <h2>Which services go with excavation?</h2>
      <ul class="bp-related-svcs">
        <li><a href="/services/site-construction-excavation/"><?php icon('tractor', 26); ?><b>Site construction &amp; excavation</b><span>Foundation digs, grading and trenches in Plymouth.</span></a></li>
        <li><a href="/services/septic-system-installation/"><?php icon('droplets', 26); ?><b>Septic system installation</b><span>New and replacement systems built to the approved design.</span></a></li>
        <li><a href="/service-areas/plymouth/"><?php icon('map-pin', 26); ?><b>Excavation in Plymouth, MA</b><span>The ground, the permits and the services by part of town.</span></a></li>
      </ul>
    </div>
<?php $bpRelated = blogRelated($bpSlug, 3); if ($bpRelated): ?>
    <div class="blog-post__related-articles">
      <h2>More from the blog</h2>
      <div class="blog-grid">
<?php foreach ($bpRelated as $bpRI => $bpRP): ?>
<?php echo blogCard($bpRP, ['tint' => ($bpRI % 3) + 1, 'delay' => ($bpRI % 3) + 1, 'heading' => 'h3']); ?>
<?php endforeach; ?>
      </div>
    </div>
<?php endif; ?>
  </div>
</section>

<!-- ============ CLOSING CTA ============ -->
<section class="closing-cta texture-grain edge-wave-top bp-end" aria-labelledby="bp-end-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="bp-end-title">Ready for a written excavation estimate in Plymouth?</h2>
      <p>BDPM Site Services will walk the lot and send the scope, the price and the schedule in writing.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="link-call" href="<?php echo h($bpTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</article>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
