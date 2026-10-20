<?php
/**
 * includes/head.php — doctype, <head> and <body> open. Include once per page, before header.php.
 *
 * Pages set (all optional — defaults come from config.php) BEFORE including this file:
 *   $pageTitle, $pageDescription, $canonicalUrl, $ogImage, $noindex, $robotsContent ('noindex, follow' placeholders), $currentPage, $pageType, $serviceSlug,
 *   $citySlug, $breadcrumbs [['name'=>'Home','url'=>'/'], ...], $schemaMarkup (JSON string, array, or list of either),
 *   $heroPreload ['srcset' => '...avif 480w, ...', 'sizes' => '100vw'] (photo-hero pages only).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$pageType = $pageType ?? 'other';
$noindex  = !empty($noindex);

// ---- Title / description / canonical ------------------------------------------------------------------
$headCity = $address['city'] . ', ' . $address['state'];
if (empty($pageTitle)) $pageTitle = $primaryKeyword . ' in ' . $headCity . ' | ' . $siteName;
if (empty($pageDescription)) {
    $pageDescription = $siteName . ' provides ' . $primaryKeyword . ' in ' . $headCity
        . ', plus septic systems, sea walls, helical piers and Title 5 inspections. Call ' . $phone . '.';
}
if (empty($canonicalUrl)) $canonicalUrl = requestCanonical($siteUrl);
elseif ($canonicalUrl[0] === '/') $canonicalUrl = rtrim($siteUrl, '/') . $canonicalUrl;

// ---- Social image: only emitted when the file exists on disk (no 404 targets) ---------------------------
$headOg = '';
$headOgCandidate = !empty($ogImage) ? (string) $ogImage : '/assets/images/og-default.jpg';
if ($headOgCandidate[0] === '/' && is_file(rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $headOgCandidate)) {
    $headOg = rtrim($siteUrl, '/') . $headOgCandidate;
} elseif (preg_match('#^https?://#', $headOgCandidate)) {
    $headOg = $headOgCandidate;
}

// ---- Schema graph: LocalBusiness on every page (same @id), WebSite on home, BreadcrumbList elsewhere ----
$headGraph = [localBusinessSchema()];
if ($pageType === 'home') {
    $headGraph[] = ['@type' => 'WebSite', '@id' => rtrim($siteUrl, '/') . '/#website', 'url' => rtrim($siteUrl, '/') . '/', 'name' => $siteName,
                    'publisher' => ['@id' => rtrim($siteUrl, '/') . '/#organization']];
}
if (!empty($breadcrumbs)) $headGraph[] = generateBreadcrumbSchema($breadcrumbs);

$headLogo = siteLogo();
$headGaLive = !empty($googleAnalyticsId) && $googleAnalyticsId !== 'G-XXXXXXXXXX';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo generateMetaTags($pageTitle, $pageDescription, $canonicalUrl, ['image' => $headOg, 'noindex' => $noindex, 'robots' => $robotsContent ?? '']); ?>
<meta name="theme-color" content="<?php echo h($colors['primary']); ?>">
<?php if (!empty($gscVerification)): ?>
<meta name="google-site-verification" content="<?php echo h($gscVerification); ?>">
<?php else: ?>
<!-- <meta name="google-site-verification" content="GSC-TOKEN-GOES-HERE"> -->
<?php endif; ?>

<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">

<link rel="preload" href="/assets/fonts/unbounded.woff2" as="font" type="font/woff2" crossorigin>
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/critical.css'; ?></style>
<link rel="preload" href="/assets/css/framework.css?v=<?php echo h($cssVersion); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo h($cssVersion); ?>"></noscript>
<?php if ($headLogo): ?>
<style>:root{--nav-height:<?php echo (int) $headLogo['navHeight']; ?>px}@media(max-width:1000px){:root{--nav-height:96px}}</style>
<?php endif; ?>
<?php if (!empty($heroPreload['srcset'])): ?>
<link rel="preload" as="image" type="image/avif" imagesrcset="<?php echo h($heroPreload['srcset']); ?>" imagesizes="<?php echo h($heroPreload['sizes'] ?? '100vw'); ?>" fetchpriority="high">
<?php endif; ?>

<?php if ($headGaLive): ?>
<script defer src="https://www.googletagmanager.com/gtag/js?id=<?php echo h($googleAnalyticsId); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo h($googleAnalyticsId); ?>');</script>
<?php else: ?>
<!-- Google Analytics 4 — placeholder. Replace G-XXXXXXXXXX with the client's measurement ID in config.php ($googleAnalyticsId); this block then goes live.
<script defer src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-XXXXXXXXXX');</script>
-->
<?php endif; ?>

<?php
if (!empty($schemaMarkup)) {
    foreach ((is_array($schemaMarkup) && isset($schemaMarkup[0])) ? $schemaMarkup : [$schemaMarkup] as $headSchemaItem) {
        echo schemaJson($headSchemaItem);
    }
}
?>
<script type="application/ld+json">
<?php echo json_encode(['@context' => 'https://schema.org', '@graph' => $headGraph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT); ?>
</script>
</head>
<body class="page-<?php echo h($pageType); ?>">
