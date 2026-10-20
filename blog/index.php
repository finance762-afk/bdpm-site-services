<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
?>
<?php
/**
 * /blog/ — "Articles are coming soon" placeholder (2026-10-20). The two auto-written launch posts were removed pending
 * client-approved articles; deploy/nginx-redirects.conf 301s their old URLs here. The page is noindex,follow (robots meta
 * via $robotsContent), is left out of sitemap.php / llms.txt, and keeps its nav/footer links so nothing 404s.
 * When the first approved post lands in includes/blog-data.php, restore the registry-driven index (cards via blogCard()).
 */
$pageTitle       = 'Blog | ' . $siteName . ' | Plymouth, MA';
$pageDescription = 'Articles from ' . $siteName . ' on excavation, septic, Title 5, sea walls and helical piers in Plymouth, MA are coming soon. Call ' . $phone . '.';
$canonicalUrl    = $siteUrl . '/blog/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'blog';
$pageType        = 'blog';
$robotsContent   = 'noindex, follow';   // placeholder: keep crawlers following the nav links, keep the page out of the index
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog/'],
];
$blTel = formatPhone($phone, 'tel');
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Blog placeholder — page composition (tokens only).
   ========================================================================== */
.bl h1, .bl h2 { text-wrap: balance; }
.bl p { text-wrap: pretty; }
.bl-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: repeating-linear-gradient(176deg, transparent 0 30px, color-mix(in srgb, var(--color-white) 5%, transparent) 30px 32px),
              radial-gradient(ellipse 55% 70% at 88% 8%, color-mix(in srgb, var(--color-primary) 22%, transparent), transparent 70%);
}
.bl-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.bl-hero .breadcrumb a:hover { color: var(--color-white); }
.bl-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.bl-hero .text-accent { color: var(--color-accent-bright); }
.bl-hero .hero-title { max-width: 20ch; }
.bl-hero .hero-answer { max-width: 62ch; }
.bl-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.bl-hero .link-call svg { color: var(--color-accent-bright); }
.bl-soon { background: var(--color-paper); }
.bl-soon__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.bl-soon .answer-block { margin: 0; background: var(--color-surface); }
.bl-soon__links { display: grid; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; }
.bl-soon__links a { display: flex; align-items: center; gap: var(--space-sm); min-height: 44px; padding: var(--space-sm) var(--space-md); border-radius: var(--radius); background: var(--color-surface); border: 1px solid var(--color-line); color: var(--color-ink); font-weight: 600; text-decoration: none; transition: transform var(--transition), box-shadow var(--transition); }
.bl-soon__links a:hover { transform: translateX(4px); box-shadow: var(--shadow); }
.bl-soon__links svg { color: var(--color-primary-dark); flex: 0 0 auto; }
@media (max-width: 900px) { .bl-soon__grid { grid-template-columns: 1fr; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="bl">

<section class="hero hero--interior bl-hero" aria-labelledby="bl-hero-title">
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li aria-current="page">Blog</li>
        </ol>
      </nav>
      <span class="eyebrow">The <?php echo h($siteName); ?> blog</span>
      <h1 class="hero-title" id="bl-hero-title">Articles are <span class="text-accent">coming soon</span></h1>
      <p class="hero-answer"><?php echo h($siteName); ?> is writing its first articles on excavation, septic systems, Title 5 inspections, sea walls and helical piers in Plymouth, MA. Until they are up, call with your question and we will answer it directly.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="<?php echo h($blTel); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
        <a class="link-call" href="/contact/"><?php icon('send', 18); ?>Send a question</a>
      </div>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<section class="section bl-soon" aria-labelledby="bl-soon-title">
  <div class="container">
    <div class="bl-soon__grid">
      <div class="reveal-left">
        <span class="eyebrow-label">In the meantime</span>
        <h2 id="bl-soon-title">Where can I read about <?php echo h($siteName); ?> work now?</h2>
        <p class="answer-block">Until the blog is live, the service pages carry the detail: what each job includes, the Massachusetts rules that apply, and what changes the price on a Plymouth lot. The FAQ page answers the questions customers ask most before work starts.</p>
      </div>
      <ul class="bl-soon__links reveal-right" aria-label="Pages to read now">
<?php foreach ($services as $blSvc): ?>
        <li><a href="/services/<?php echo h($blSvc['slug']); ?>/"><?php icon('arrow-right', 16); ?><?php echo h($blSvc['name']); ?></a></li>
<?php endforeach; ?>
        <li><a href="/faq/"><?php icon('arrow-right', 16); ?>Frequently asked questions</a></li>
      </ul>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
