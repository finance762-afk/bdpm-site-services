<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
?>
<?php
/**
 * /blog/ — Phase 6 blog index. Registry-driven: every card comes from $blogPosts (includes/blog-data.php). Adding a post to the registry
 * adds it here, on the homepage preview, in related-article blocks and in sitemap.php. The newest post is the featured card.
 */
$pageTitle       = 'Excavation & Septic Blog Plymouth, MA | BDPM Site Services';
$pageDescription = 'Plain-English answers on excavation costs, Dig Safe, wetlands permits, septic systems and coastal banks in Plymouth, MA, from BDPM Site Services.';
$canonicalUrl    = $siteUrl . '/blog/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'blog';
$pageType        = 'blog';
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog/'],
];

$blTel        = formatPhone($phone, 'tel');
$blBase       = rtrim($siteUrl, '/');
$blFeatured   = $blogPosts[0] ?? null;
$blRest       = array_slice($blogPosts, 1);
$blCategories = array_values(array_unique(array_column($blogPosts, 'category')));

$blItems = [];
foreach ($blogPosts as $blIdx => $blPost) {
    $blItems[] = ['@type' => 'ListItem', 'position' => $blIdx + 1, 'name' => $blPost['title'], 'url' => $blBase . '/blog/' . $blPost['slug'] . '/'];
}
$schemaMarkup = [[
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $blBase . '/blog/#webpage',
    'url' => $blBase . '/blog/',
    'name' => $pageTitle,
    'about' => ['@id' => $blBase . '/#organization'],
    'mainEntity' => ['@type' => 'ItemList', 'itemListElement' => $blItems],
]];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Blog index — page composition (tokens only). Cards come from blogCard().
   ========================================================================== */
.bl h1, .bl h2, .bl h3 { text-wrap: balance; }
.bl p { text-wrap: pretty; }
<?php echo blogCardStyles(); ?>

.bl-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: repeating-linear-gradient(176deg, transparent 0 30px, color-mix(in srgb, var(--color-white) 5%, transparent) 30px 32px),
              radial-gradient(ellipse 55% 70% at 88% 8%, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%);
}
.bl-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.bl-hero .breadcrumb a:hover { color: var(--color-white); }
.bl-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.bl-hero .text-accent { color: var(--color-accent-bright); }
.bl-hero .hero-title { max-width: 20ch; }
.bl-hero .hero-answer { max-width: 62ch; }
.bl-cats { display: flex; flex-wrap: wrap; gap: var(--space-xs); margin: var(--space-md) 0 0; padding: 0; list-style: none; }
.bl-cats li { padding: var(--space-1) var(--space-md); border-radius: var(--radius-full); background: color-mix(in srgb, var(--color-white) 8%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 20%, transparent); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .12em; text-transform: uppercase; color: var(--color-white); }

.bl-posts { background: var(--color-paper); }
.bl-posts .section-head { max-width: 62ch; }
.bl-feature { margin-bottom: var(--space-xl); }
.bl-grid { margin-top: var(--space-md); }

.bl-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.bl-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.bl-cta .link-call svg { color: var(--color-accent-bright); }
.bl-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="bl">

<section class="hero hero--interior bl-hero" aria-labelledby="bl-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li aria-current="page">Blog</li>
      </ol>
    </nav>
    <span class="eyebrow">The BDPM Site Services blog</span>
    <h1 class="hero-title" id="bl-hero-title">Excavation, septic and shoreline <span class="text-accent">answers for Plymouth, MA</span></h1>
    <p class="hero-answer">Straight answers on what excavation costs, which permits apply and what to watch on a coastal bank, written for Plymouth property owners.</p>
    <ul class="bl-cats" aria-label="Topics">
<?php foreach ($blCategories as $blCat): ?>
      <li><?php echo h($blCat); ?></li>
<?php endforeach; ?>
    </ul>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<section class="section bl-posts" aria-labelledby="bl-posts-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Latest articles</span>
      <h2 id="bl-posts-title">What are Plymouth property owners asking about excavation?</h2>
      <p class="answer-block">Plymouth property owners weighing ground work usually need three answers: what moves an excavation price, which approvals a lot needs, and how to spot trouble on a coastal bank. Each article from BDPM Site Services answers one of those questions first, then shows the detail behind the answer.</p>
    </div>
<?php if ($blFeatured): ?>
    <div class="bl-feature">
<?php echo blogCard($blFeatured, ['featured' => true, 'tint' => 3, 'delay' => 1, 'heading' => 'h3']); ?>
    </div>
<?php endif; ?>
<?php if ($blRest): ?>
    <div class="blog-grid bl-grid">
<?php foreach ($blRest as $blI => $blPost): ?>
<?php echo blogCard($blPost, ['tint' => ($blI % 2) + 1, 'delay' => ($blI % 3) + 1, 'heading' => 'h3']); ?>
<?php endforeach; ?>
    </div>
<?php endif; ?>
  </div>
</section>

<section class="closing-cta texture-grain edge-torn-top bl-cta" aria-labelledby="bl-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Free estimate</span>
      <h2 id="bl-cta-title">Have a Plymouth lot that needs ground work?</h2>
      <p>Send the address and a few lines about the job. BDPM Site Services will walk the lot and send a written estimate with the scope, price and schedule.</p>
    </div>
    <div class="actions">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a free estimate</button>
      <a class="link-call" href="<?php echo h($blTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
