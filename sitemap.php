<?php
/**
 * sitemap.php — dynamic XML sitemap, served at /sitemap.xml by the .htaccess rewrite.
 * Page registry below is the only hand-kept list; blog posts come from the $blogPosts registry (includes/blog-data.php), service pages from
 * config.php $services and area pages from config.php $areaPages (only when the page exists on disk, so the sitemap never lists a 404).
 * Excluded on purpose: /thank-you (noindex), /404.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';

header('Content-Type: application/xml; charset=UTF-8');

$smBase = rtrim($siteUrl, '/');
$smRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

/** lastmod from a file's mtime (YYYY-MM-DD), or today when the file is missing. */
$smMod = function (string $relPath) use ($smRoot): string {
    $file = $smRoot . $relPath;
    return date('Y-m-d', is_file($file) ? (int) filemtime($file) : time());
};

// [path, file used for lastmod, changefreq, priority]
$smUrls = [
    ['/',               '/index.php',                 'weekly',  '1.0'],
    ['/services/',      '/services/index.php',        'monthly', '0.9'],
];
foreach ($services as $smSvc) {
    $smUrls[] = ['/services/' . $smSvc['slug'] . '/', '/services/' . $smSvc['slug'] . '/index.php', 'monthly', '0.8'];
}
$smUrls[] = ['/service-areas/', '/service-areas/index.php', 'monthly', '0.8'];
foreach ($areaPages as $smArea) {
    $smRel = '/service-areas/' . $smArea['slug'] . '/index.php';
    if (is_file($smRoot . $smRel)) $smUrls[] = ['/service-areas/' . $smArea['slug'] . '/', $smRel, 'monthly', '0.8'];
}
$smUrls[] = ['/about/',   '/about/index.php',   'monthly', '0.6'];
$smUrls[] = ['/faq/',     '/faq/index.php',     'monthly', '0.6'];
$smUrls[] = ['/contact/', '/contact/index.php', 'yearly',  '0.7'];
$smUrls[] = ['/blog/',    '/blog/index.php',    'weekly',  '0.7'];
foreach ($blogPosts as $smPost) {
    $smUrls[] = ['/blog/' . $smPost['slug'] . '/', '/blog/' . $smPost['slug'] . '/index.php', 'monthly', '0.6', $smPost['dateISO'], $smPost];
}
foreach (['privacy-policy', 'terms', 'cookie-policy', 'accessibility'] as $smLegal) {
    $smUrls[] = ['/' . $smLegal . '/', '/' . $smLegal . '/index.php', 'yearly', '0.3'];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($smUrls as $smRow): ?>
  <url>
    <loc><?php echo htmlspecialchars($smBase . $smRow[0], ENT_XML1); ?></loc>
    <lastmod><?php echo htmlspecialchars($smRow[4] ?? $smMod($smRow[1]), ENT_XML1); ?></lastmod>
    <changefreq><?php echo $smRow[2]; ?></changefreq>
    <priority><?php echo $smRow[3]; ?></priority>
<?php if (!empty($smRow[5]) && blogImageExists($smRow[5])): ?>
    <image:image>
      <image:loc><?php echo htmlspecialchars($smBase . $smRow[5]['image'], ENT_XML1); ?></image:loc>
      <image:title><?php echo htmlspecialchars($smRow[5]['title'], ENT_XML1); ?></image:title>
      <image:caption><?php echo htmlspecialchars($smRow[5]['alt'], ENT_XML1); ?></image:caption>
    </image:image>
<?php endif; ?>
  </url>
<?php endforeach; ?>
</urlset>
