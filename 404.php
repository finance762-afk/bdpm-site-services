<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /404.php — branded error page (.htaccess: ErrorDocument 404 /404.php). Sends a real 404 status, is noindexed, and links ONLY to pages that
 * exist on disk (home, the five service pages, services hub, about, faq, contact) — blog, service-areas and sitemap.xml are not linked until built.
 * The site has no search backend, so the "search suggestion" is a topic finder: what the visitor was probably looking for -> the page that answers it.
 */
http_response_code(404);

$noindex         = true;
$pageTitle       = 'Page Not Found | ' . $siteName . ' | ' . $address['city'] . ', ' . $address['state'];
$pageDescription = 'That page was not found. Find excavation, septic, Title 5, sea wall and helical pier information from ' . $siteName . ' in ' . $address['city'] . ', ' . $address['state'] . '.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = '404';
$pageType        = 'other';
$heroPreload     = [];

$nfTel = formatPhone($phone, 'tel');

// Topic finder — what the visitor was probably after -> the page that answers it
$nfTopics = [
    ['tractor', 'Digging, grading or a foundation', 'Site construction and excavation in Plymouth', '/services/site-construction-excavation/'],
    ['droplets', 'A new or replacement septic system', 'Septic system installation to the approved design', '/services/septic-system-installation/'],
    ['clipboard-list', 'A Title 5 inspection before a sale', 'When it is required and what the results mean', '/services/title-5-inspections/'],
    ['waves', 'Waterfront erosion', 'Sea walls and the Plymouth permit path', '/services/sea-walls/'],
    ['building-2', 'Support for an addition, deck or porch', 'Helical piers for new foundations', '/services/helical-piers/'],
    ['info', 'Quick answers', 'Dig Safe, wetlands, cost and process questions', '/faq/'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* 404 — compact dark hero + topic finder. Tokens only. */
.nf h1, .nf h2, .nf h3 { text-wrap: balance; }
.nf p { text-wrap: pretty; }
.nf-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 50% 70% at 0% 0%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              radial-gradient(ellipse 40% 60% at 100% 100%, color-mix(in srgb, var(--color-secondary) 30%, transparent), transparent 70%);
}
.nf-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.nf-hero__num { position: absolute; right: max(var(--space-md), 6vw); top: 50%; transform: translateY(-50%); z-index: -1; font-family: var(--font-accent); font-size: clamp(8rem, 5rem + 18vw, 18rem); line-height: .8; letter-spacing: .02em; color: color-mix(in srgb, var(--color-white) 6%, transparent); pointer-events: none; user-select: none; }
.nf-hero .hero-copy { max-width: 40rem; }
.nf-hero .hero-title { max-width: 18ch; }
.nf-hero .text-accent { color: var(--color-accent-bright); }
.nf-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.nf-hero .link-call svg { color: var(--color-accent-bright); }

.nf-topics { background: var(--color-paper); }
.nf-topics .section-head { max-width: 62ch; }
.nf-topics__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.nf-topics__grid a { display: grid; grid-template-columns: 3rem minmax(0, 1fr); gap: var(--space-xs) var(--space-md); align-items: center; height: 100%; min-height: 44px; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); color: var(--color-ink); text-decoration: none; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition); }
.nf-topics__grid a:hover { transform: translateY(-3px); box-shadow: var(--shadow); border-color: var(--color-accent); }
.nf-topics__grid li:nth-child(3n+1) a { background: var(--color-card-tint-1); }
.nf-topics__grid li:nth-child(3n+2) a { background: var(--color-card-tint-3); }
.nf-topics__grid li:nth-child(3n) a { background: var(--color-card-tint-2); }
.nf-topics__icon { grid-row: span 2; display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); }
.nf-topics__grid b { font-family: var(--font-heading); font-weight: 800; font-size: var(--font-size-base); line-height: 1.25; }
.nf-topics__grid span { font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.45; }
.nf-topics__more { display: flex; flex-wrap: wrap; gap: var(--space-md); margin-top: var(--space-xl); }

@media (min-width: 801px) { .nf-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; } }
.nf-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.nf-cta .link-call svg { color: var(--color-accent-bright); }
.nf-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.nf-cta .floating-ring { right: -5rem; bottom: -9rem; opacity: .1; }

@media (max-width: 1000px) { .nf-topics__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 640px) { .nf-topics__grid { grid-template-columns: 1fr; } .nf-hero__num { opacity: .6; right: var(--space-md); } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="nf">

<section class="hero hero--interior nf-hero" aria-labelledby="nf-title">
  <span class="nf-hero__num" aria-hidden="true">404</span>
  <div class="container">
    <div class="hero-copy">
      <span class="eyebrow">Error 404 · Page not found</span>
      <h1 class="hero-title" id="nf-title">That page is <span class="text-accent">not on this site</span></h1>
      <p class="hero-answer">The link may be old or mistyped. Pick what you were looking for below, or call <?php echo h($siteName); ?> at <?php echo h($phone); ?>.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="/">Go to the homepage</a>
        <a class="link-call" href="<?php echo h($nfTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<section class="section nf-topics" aria-labelledby="nf-topics-title">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow-label">Looking for something specific?</span>
      <h2 id="nf-topics-title">Which page has what you were looking for?</h2>
      <p>Pick the topic closest to what you searched for. Each link goes to a <?php echo h($siteName); ?> page for Plymouth, MA.</p>
    </div>
    <ul class="nf-topics__grid">
<?php foreach ($nfTopics as $nfTopic): ?>
      <li><a href="<?php echo h($nfTopic[3]); ?>"><span class="nf-topics__icon"><?php icon($nfTopic[0], 24); ?></span><b><?php echo h($nfTopic[1]); ?></b><span><?php echo h($nfTopic[2]); ?></span></a></li>
<?php endforeach; ?>
    </ul>
    <div class="nf-topics__more">
      <a class="btn btn-secondary" href="/services/">See all five services</a>
      <a class="btn btn-secondary" href="/about/">About <?php echo h($siteName); ?></a>
    </div>
  </div>
</section>

<section class="closing-cta texture-grain edge-wave-top nf-cta" aria-labelledby="nf-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Can&rsquo;t find it?</span>
      <h2 id="nf-cta-title">Ask <?php echo h($siteName); ?> directly</h2>
      <p>Call or send the contact form and the office will point you to the right answer, or set up a site visit for your Plymouth property.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="/contact/">Contact BDPM Site Services</a>
      <a class="link-call" href="<?php echo h($nfTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
