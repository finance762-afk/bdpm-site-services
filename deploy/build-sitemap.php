<?php
// deploy/build-sitemap.php — BDPM Site Services. Regenerates the static /sitemap.xml from sitemap.php and keeps the Sitemap
// line in /robots.txt pointed at $siteUrl (includes/config.php). nginx serves static files and does not apply the .htaccess
// /sitemap.xml -> sitemap.php rewrite, so the static file is what the preview/nginx host serves; Apache/Hostinger keeps
// using the rewrite. Re-run after adding a page or changing $siteUrl. The blog is excluded on purpose (2026-10-20:
// /blog/ is a noindex,follow placeholder), and the guard below refuses to write a sitemap that lists any /blog URL.
// Usage (repo root): php deploy/build-sitemap.php
$root = dirname(__DIR__);
$_SERVER['DOCUMENT_ROOT'] = $root;
ob_start();
include $root . '/sitemap.php';
$xml = ob_get_clean();
if (strpos($xml, '<urlset') === false) { fwrite(STDERR, "sitemap.php produced no urlset\n"); exit(1); }
if (preg_match('#<loc>[^<]*/blog(/[^<]*)?</loc>#', $xml)) { fwrite(STDERR, "sitemap contains /blog; refusing\n"); exit(1); }
file_put_contents($root . '/sitemap.xml', $xml);
echo "wrote sitemap.xml (" . substr_count($xml, '<loc>') . " URLs)\n";

// robots.txt: keep existing crawl rules; if it points to a sitemap, set that line from $siteUrl.
if (empty($siteUrl)) { require $root . '/includes/config.php'; }
$path = $root . '/robots.txt';
if (is_file($path)) {
    $robots = file_get_contents($path);
    $line = 'Sitemap: ' . rtrim($siteUrl, '/') . '/sitemap.xml';
    if (preg_match('/^Sitemap:.*$/mi', $robots)) {
        $robots = preg_replace('/^Sitemap:.*$/mi', $line, $robots, 1);
        file_put_contents($path, $robots);
        echo "updated robots.txt ($line)\n";
    }
}
