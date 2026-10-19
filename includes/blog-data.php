<?php
/**
 * includes/blog-data.php — single source of truth for all blog post metadata.
 * Newest post FIRST. The blog index, the homepage "From the Blog" card, the related-articles blocks and sitemap.php all read
 * this array. Never hardcode a post list anywhere else. Adding a post = one entry here + one /blog/{slug}/index.php.
 *
 * 'image' is '' on both launch posts: the intake supplied no client photos (build-plan assets.images = []), so there is no
 * /assets/images/ file to point at. blogCard() prints a typographic header instead. When photos arrive, set 'image' to the
 * -960.webp path and 'alt' to a description; the cards, the post hero and the sitemap pick it up with no other change.
 */

$blogPosts = [
    [
        'slug'     => 'what-drives-excavation-cost-plymouth-ma',
        'title'    => 'What Drives Excavation Costs on a Plymouth, MA Lot?',
        'excerpt'  => 'Soil, ledge, access, haul-away, wetlands review and the Dig Safe wait all move an excavation price in Plymouth. Here is how each one works.',
        'image'    => '',
        'alt'      => '',
        'date'     => 'October 19, 2026',
        'dateISO'  => '2026-10-19',
        'category' => 'Excavation',
        'readtime' => '6 min read',
    ],
    [
        'slug'     => 'nor-easter-season-plymouth-coastal-bank',
        'title'    => "Nor'easter Season: Check Your Plymouth Coastal Bank",
        'excerpt'  => 'Four warning signs to look for on a Plymouth sea wall or coastal bank, and why the repair has to start with the Conservation Commission.',
        'image'    => '',
        'alt'      => '',
        'date'     => 'October 19, 2026',
        'dateISO'  => '2026-10-19',
        'category' => 'Waterfront',
        'readtime' => '6 min read',
    ],
];

if (!function_exists('blogPostBySlug')) {
    /** The registry entry for a slug, or null. */
    function blogPostBySlug(string $slug): ?array {
        foreach ((array) ($GLOBALS['blogPosts'] ?? []) as $blogRow) {
            if ($blogRow['slug'] === $slug) return $blogRow;
        }
        return null;
    }
}

if (!function_exists('blogRelated')) {
    /** Up to $limit other posts: same category first, then most recent. */
    function blogRelated(string $slug, int $limit = 3): array {
        $current = blogPostBySlug($slug);
        $same = []; $rest = [];
        foreach ((array) ($GLOBALS['blogPosts'] ?? []) as $blogRow) {
            if ($blogRow['slug'] === $slug) continue;
            if ($current && $blogRow['category'] === $current['category']) $same[] = $blogRow; else $rest[] = $blogRow;
        }
        return array_slice(array_merge($same, $rest), 0, $limit);
    }
}

if (!function_exists('blogImageExists')) {
    /** True only when the registry image is a real file under the document root (cards never point at a 404). */
    function blogImageExists(array $post): bool {
        $img = (string) ($post['image'] ?? '');
        return $img !== '' && $img[0] === '/' && is_file(rtrim((string) $_SERVER['DOCUMENT_ROOT'], '/') . $img);
    }
}

if (!function_exists('blogCard')) {
    /**
     * One editorial card (framework.css .blog-card). $opts: tint (1-3), delay (1-4), featured (bool), heading (h2|h3), lazy (bool).
     * Without a photo the card header is a typographic panel carrying the category and the read time.
     */
    function blogCard(array $post, array $opts = []): string {
        $tint     = (int) ($opts['tint'] ?? 1);
        $delay    = (int) ($opts['delay'] ?? 1);
        $heading  = in_array(($opts['heading'] ?? 'h3'), ['h2', 'h3'], true) ? $opts['heading'] : 'h3';
        $featured = !empty($opts['featured']);
        $url      = '/blog/' . $post['slug'] . '/';
        ob_start(); ?>
<a class="blog-card blog-card--tint-<?php echo $tint; ?><?php echo $featured ? ' blog-card--featured' : ''; ?> reveal-up reveal-delay-<?php echo $delay; ?>" href="<?php echo h($url); ?>">
  <div class="blog-card__image<?php echo blogImageExists($post) ? '' : ' blog-card__image--type'; ?>">
<?php if (blogImageExists($post)): ?>
    <img src="<?php echo h($post['image']); ?>" alt="<?php echo h($post['alt']); ?>" width="960" height="600" loading="lazy" decoding="async">
<?php else: ?>
    <span class="blog-card__mark" aria-hidden="true"><?php echo h($post['category']); ?></span>
    <span class="blog-card__mark-sub" aria-hidden="true"><?php echo h($post['readtime']); ?></span>
<?php endif; ?>
  </div>
  <div class="blog-card__body">
    <span class="blog-card__category"><?php echo h($post['category']); ?></span>
    <<?php echo $heading; ?> class="blog-card__title"><?php echo h($post['title']); ?></<?php echo $heading; ?>>
    <p class="blog-card__excerpt"><?php echo h($post['excerpt']); ?></p>
    <span class="blog-card__meta"><time datetime="<?php echo h($post['dateISO']); ?>"><?php echo h($post['date']); ?></time> · <?php echo h($post['readtime']); ?></span>
    <span class="blog-card__cta">Read Article <span aria-hidden="true">&rarr;</span></span>
  </div>
</a>
<?php
        return (string) ob_get_clean();
    }
}

if (!function_exists('blogCardStyles')) {
    /**
     * CSS for the typographic card header + tints that framework.css' .blog-card does not cover (tokens only).
     * Echo inside the consuming page's <style> block so every card on every page is styled from one place.
     */
    function blogCardStyles(): string {
        return <<<'CSS'
.blog-card { position: relative; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.blog-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.blog-card--tint-1 { background: var(--color-card-tint-1); }
.blog-card--tint-2 { background: var(--color-card-tint-2); }
.blog-card--tint-3 { background: var(--color-card-tint-3); }
.blog-card__image--type { position: relative; display: grid; align-content: end; gap: var(--space-1); padding: var(--space-lg); aspect-ratio: 16 / 9; color: var(--color-white); background: linear-gradient(135deg, var(--color-dark) 0%, var(--color-primary-deep) 100%); isolation: isolate; }
.blog-card--tint-3 .blog-card__image--type { background: linear-gradient(135deg, var(--color-dark) 0%, color-mix(in srgb, var(--color-accent) 38%, var(--color-dark)) 130%); }
.blog-card__image--type::before { content: ""; position: absolute; inset: 0; z-index: -1; background: repeating-linear-gradient(135deg, transparent 0 14px, color-mix(in srgb, var(--color-white) 5%, transparent) 14px 15px); }
.blog-card__mark { font-family: var(--font-heading); font-weight: 800; font-size: var(--fs-h2); line-height: 1; letter-spacing: -.018em; text-wrap: balance; }
.blog-card__mark-sub { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .16em; text-transform: uppercase; color: var(--color-accent-bright); }
.blog-card__title { text-wrap: balance; }
.blog-card__cta { color: var(--color-accent-dark); text-decoration: underline; text-underline-offset: .18em; min-height: 44px; display: inline-flex; align-items: center; }
.blog-card--featured { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr); }
.blog-card--featured .blog-card__image { aspect-ratio: auto; min-height: 280px; }
.blog-card--featured .blog-card__body { align-content: center; padding: var(--space-xl); gap: var(--space-sm); }
.blog-card--featured .blog-card__title { font-size: var(--fs-h2); line-height: 1.12; }
@media (max-width: 800px) { .blog-card--featured { grid-template-columns: 1fr; } .blog-card--featured .blog-card__image { min-height: 0; aspect-ratio: 16 / 9; } }
CSS;
    }
}

if (!function_exists('blogPostStyles')) {
    /**
     * Shared layout CSS for /blog/{slug}/ posts (tokens only): post hero meta, two-column body with a sticky aside, the mid-page
     * .cta-band lead form, related-services links. Each post adds only its own hero motif on top. Echo inside the post's <style>.
     */
    function blogPostStyles(): string {
        return <<<'CSS'
.bp h1, .bp h2, .bp h3 { text-wrap: balance; }
.bp p, .bp li { text-wrap: pretty; }
.bp-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.bp-hero .breadcrumb a:hover { color: var(--color-white); }
.bp-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.bp-hero .text-accent { color: var(--color-accent-bright); }
.bp-hero .hero-title { max-width: 24ch; }
.bp-hero .btn-primary { background: var(--color-accent); border-color: var(--color-accent); color: var(--color-white); }
.bp-hero .btn-primary:hover { background: var(--color-accent-dark); border-color: var(--color-accent-dark); }
.bp-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.bp-hero .link-call svg { color: var(--color-accent-bright); }
.bp-hero .link-call:hover { color: var(--color-white); }
.bp-hero__cat { display: inline-flex; align-items: center; gap: var(--space-xs); }
.bp-hero .blog-post__meta { display: flex; flex-wrap: wrap; gap: var(--space-xs) var(--space-md); margin: var(--space-sm) 0 var(--space-md); color: color-mix(in srgb, var(--color-white) 78%, transparent); font-size: var(--fs-small); }
.bp-body { background: var(--color-paper); padding-block: clamp(2.5rem, 6vw, 4.5rem); }
.bp-body--b { background: var(--color-surface); }
.bp-layout { display: grid; grid-template-columns: minmax(0, 1fr) 300px; gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.bp-layout .blog-post__content { max-width: var(--measure); }
.bp-layout .blog-post__content p, .bp-layout .blog-post__content li { color: var(--color-ink-2); }
.bp-layout .blog-post__content a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }
.bp-layout .blog-post__content h2 { scroll-margin-top: calc(var(--nav-height) + var(--space-lg)); }
.bp-layout .blog-post__content .answer-block { color: var(--color-ink); font-size: var(--fs-lead); }
.bp-layout .blog-post__content ol, .bp-layout .blog-post__content ul { display: grid; gap: var(--space-xs); }
.bp-aside { position: sticky; top: calc(var(--nav-height) + var(--space-lg)); display: grid; gap: var(--space-md); }
.bp-toc, .bp-side-cta, .bp-side-links { padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.bp-toc { background: var(--color-card-tint-3); border-top: 5px solid var(--color-accent); }
.bp-toc h2, .bp-side-links h2 { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); margin-bottom: var(--space-sm); }
.bp-toc ol { margin: 0; padding-left: var(--space-lg); display: grid; gap: var(--space-xs); }
.bp-toc a, .bp-side-links a { display: inline-flex; align-items: center; min-height: 44px; color: var(--color-ink); text-decoration: none; font-size: var(--fs-small); font-weight: 600; line-height: 1.35; }
.bp-toc a:hover, .bp-side-links a:hover { color: var(--color-accent-dark); text-decoration: underline; text-underline-offset: .15em; }
.bp-side-cta { background: var(--color-dark); color: var(--color-white); border-color: var(--color-dark); display: grid; gap: var(--space-sm); }
.bp-side-cta h2 { font-size: var(--font-size-xl); color: var(--color-white); }
.bp-side-cta p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.bp-side-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.bp-side-cta .link-call svg { color: var(--color-accent-bright); }
.bp-side-links { background: var(--color-card-tint-1); }
.bp-side-links ul { list-style: none; margin: 0; padding: 0; display: grid; }
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
.bp-faq .faq { border-bottom: 1px solid var(--color-line); }
.bp-faq .faq summary { min-height: 44px; }
.bp-byline { margin-top: var(--space-xl); padding-top: var(--space-md); border-top: 1px solid var(--color-line); font-size: var(--font-size-sm); color: var(--color-muted); }
.bp-more { background: var(--color-paper-2); padding-block: clamp(2.5rem, 6vw, 4.5rem); }
.bp-more .blog-post__related-services, .bp-more .blog-post__related-articles { margin-top: 0; }
.bp-more .blog-post__related-articles { margin-top: var(--space-2xl); }
.bp-related-svcs { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: var(--space-md) 0 0; padding: 0; list-style: none; }
.bp-related-svcs a { display: grid; gap: var(--space-xs); height: 100%; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); text-decoration: none; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.bp-related-svcs a:hover { transform: translateY(-3px); box-shadow: var(--shadow); }
.bp-related-svcs svg { color: var(--color-accent-dark); }
.bp-related-svcs b { font-family: var(--font-heading); font-size: var(--font-size-lg); color: var(--color-ink); }
.bp-related-svcs span { font-size: var(--fs-small); color: var(--color-ink-2); }
.bp-end .container { grid-template-columns: minmax(0, 1.3fr) auto; }
.bp-end .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.bp-end .link-call svg { color: var(--color-accent-bright); }
.bp-end .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
@media (max-width: 1000px) {
  .bp-layout { grid-template-columns: 1fr; }
  .bp-aside { position: static; }
  .bp-layout > .bp-aside--toc { order: -1; }
  .bp-related-svcs { grid-template-columns: 1fr; }
  .cta-band__grid { grid-template-columns: 1fr; }
}
@media (max-width: 700px) {
  .cta-band__form { grid-template-columns: 1fr; }
  .cta-band__form .field--btn, .cta-band__form .consent { grid-column: auto; }
}
CSS;
    }
}
