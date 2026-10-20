<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /cookie-policy/ — legal page (legal-compliance.md cookie template, rewritten to what this site actually sets).
 * Verified against the code: p1_ft first-party cookie (includes/attribution.php: 30 days, httponly, SameSite=Lax, holds landing page,
 * referrer, UTM, gclid, session id, device); cookie-bar flag cookieBannerDismissed_v1 in localStorage (assets/js/main.js); GA4 loads only
 * once $googleAnalyticsId is set (head.php); fonts are self-hosted (no font-provider request); the contact page embeds a Google Maps iframe
 * ($gbp['embed_src'], set 2026-10-20), disclosed under "Third-party content". The policy describes GA4 as in use because it goes live at launch.
 */
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: bump when the text changes
$pageTitle       = 'Cookie Policy | ' . $companyName . ' | ' . $address['city'] . ', ' . $address['state'];
$pageDescription = 'The cookies and similar technologies the ' . $companyName . ' website uses, why, and how to control or opt out of them.';
$canonicalUrl    = $siteUrl . '/cookie-policy/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Cookie Policy', 'url' => '/cookie-policy/'],
];
$schemaMarkup    = [legalPageSchema('Cookie Policy', $pageDescription, $canonicalUrl)];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* Legal page — solid 40vh hero, narrow reading column, no reveals. Tokens only. */
.legal-page h1, .legal-page h2, .legal-page h3 { text-wrap: balance; }
.legal-page p, .legal-page li { text-wrap: pretty; }
.legal-hero { min-height: 40vh; display: flex; align-items: center; }
.legal-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 45% 90% at 100% 0%, color-mix(in srgb, var(--color-accent) 18%, transparent), transparent 70%);
}
.legal-hero .container { display: grid; gap: var(--space-sm); }
.legal-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-xs); }
.legal-hero .breadcrumb a:hover { color: var(--color-white); }
.legal-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.legal-hero h1 { max-width: 20ch; }
.legal-hero__updated { margin: 0; font-family: var(--font-accent); font-size: var(--font-size-lg); letter-spacing: .08em; text-transform: uppercase; color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.legal-body { background: var(--color-paper); }
.legal-page .legal-prose { margin-inline: auto; }
.legal-prose a { color: var(--color-accent-dark); text-decoration: underline; text-underline-offset: .15em; }
.legal-prose ul { padding-left: var(--space-lg); }
.legal-prose li { margin-bottom: var(--space-xs); }
.legal-table-wrap { overflow-x: auto; margin: var(--space-md) 0 var(--space-lg); border: 1px solid var(--color-line); border-radius: var(--radius); background: var(--color-surface); }
.legal-table { width: 100%; min-width: 34rem; border-collapse: collapse; font-size: var(--fs-small); }
.legal-table th, .legal-table td { padding: var(--space-sm) var(--space-md); text-align: left; vertical-align: top; line-height: 1.5; border-bottom: 1px solid var(--color-line); }
.legal-table thead th { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-muted); background: var(--color-paper-2); }
.legal-table tbody tr:last-child th, .legal-table tbody tr:last-child td { border-bottom: 0; }
.legal-table code { font-size: .92em; word-break: break-word; }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="legal-page">

<section class="hero hero--legal legal-hero" aria-labelledby="legal-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li aria-current="page">Cookie Policy</li>
      </ol>
    </nav>
    <span class="eyebrow">Legal</span>
    <h1 id="legal-title">Cookie Policy</h1>
    <p class="legal-hero__updated">Last Updated: <?php echo h($lastUpdated); ?></p>
  </div>
</section>

<section class="section legal-body" aria-label="Cookie Policy">
  <div class="container">
    <article class="content-narrow legal-prose">

      <h2>1. What Are Cookies?</h2>
      <p>Cookies are small text files a website stores on your device. Websites use them to work properly and to tell the site owner how visitors use the site. Similar technologies, such as your browser&rsquo;s local storage, do the same kind of job. This policy covers the website of <?php echo h(legalName()); ?> at <?php echo h($domain); ?>.</p>

      <h2>2. What This Site Stores on Your Device</h2>
      <div class="legal-table-wrap">
        <table class="legal-table">
          <caption class="sr-only">Cookies and similar technologies used on this site</caption>
          <thead>
            <tr><th scope="col">Name</th><th scope="col">Type</th><th scope="col">What it does</th><th scope="col">How long</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row"><code>p1_ft</code></th><td>First-party cookie</td><td>Records the first page you landed on, where you came from, any campaign tags in the link, a random session ID and your device type (phone, tablet or desktop). It is sent with an estimate form so we can tell which page led to your inquiry.</td><td>30 days</td></tr>
            <tr><th scope="row"><code>cookieBannerDismissed_v1</code></th><td>Local storage</td><td>Remembers that you closed the cookie notice so it does not appear again.</td><td>Until you clear site data</td></tr>
            <tr><th scope="row"><code>_ga</code>, <code>_ga_&lt;ID&gt;</code></th><td>Google Analytics 4 cookies</td><td>Tell us how many people visit, which pages they view and how they found the site.</td><td>Up to 2 years</td></tr>
          </tbody>
        </table>
      </div>

      <h3>Strictly necessary</h3>
      <p>The site works without cookies. Forms submit and pages load whether or not any cookie is stored.</p>

      <h3>Attribution (first-party)</h3>
      <p>The <code>p1_ft</code> cookie is set by our own server, not by an advertiser. It is flagged HTTP-only so scripts in your browser cannot read it, and it is not used to follow you to other websites.</p>

      <h3>Analytics (Google Analytics 4)</h3>
      <p>We use Google Analytics 4 to understand how visitors use the site. It reports pages viewed, approximate location, device and browser, and referring site. Google processes this data under its own <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">privacy policy</a>.</p>

      <h3>Third-party content</h3>
      <p>This site links to our Google Business Profile, embeds a Google Maps view of our location on the contact page, and may show other content from Google, such as reviews. Content loaded from Google can set its own cookies, which we do not control. Our fonts are hosted on this site, so no font provider receives your request.</p>

      <h2>3. How to Control Cookies</h2>
      <p>Most browsers let you view, delete or block cookies. You can block third-party cookies only, or block all cookies, though some features of other websites may stop working. Instructions are available from Google Chrome, Mozilla Firefox, Apple Safari and Microsoft Edge. To clear the local-storage setting for the cookie notice, clear this site&rsquo;s data in your browser.</p>

      <h2>4. Opt Out of Google Analytics</h2>
      <p>You can opt out of Google Analytics on all websites by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google Analytics Opt-out Browser Add-on</a>.</p>

      <h2>5. Our Cookie Notice</h2>
      <p>A short notice appears the first time you scroll the site. Once you select &ldquo;Got it,&rdquo; your browser remembers the choice and the notice does not return. Clearing this site&rsquo;s data in your browser brings it back.</p>

      <h2>6. Changes to This Policy</h2>
      <p>We may update this Cookie Policy as the site changes. The &ldquo;Last Updated&rdquo; date above shows the latest version. See our <a href="/privacy-policy/">Privacy Policy</a> for how we handle personal information.</p>

      <h2>7. Contact Us</h2>
      <?php echo legalContactBlock(); ?>

    </article>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
