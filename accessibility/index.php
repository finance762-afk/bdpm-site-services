<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /accessibility/ — legal page (legal-compliance.md accessibility template). The feature list is limited to what the scaffold ships:
 * skip link + <main id="main-content"> (header.php), :focus-visible ring, prefers-reduced-motion block (framework.css), aria-expanded
 * on the menu button + Escape to close (main.js), labelled form fields, landmarks. The template's PDF known-issue is dropped (the site has no PDFs)
 * and its fixed "5 business days" response promise is softened to office hours (nothing in intake commits the client to that SLA).
 */
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: bump when the text changes
$pageTitle       = 'Accessibility Statement | ' . $companyName . ' | ' . $address['city'] . ', ' . $address['state'];
$pageDescription = $companyName . ' is working toward WCAG 2.1 Level AA on this website. See the accessibility features, known limits and how to reach us about a barrier.';
$canonicalUrl    = $siteUrl . '/accessibility/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Accessibility Statement', 'url' => '/accessibility/'],
];
$schemaMarkup    = [legalPageSchema('Accessibility Statement', $pageDescription, $canonicalUrl)];
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
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="legal-page">

<section class="hero hero--legal legal-hero" aria-labelledby="legal-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="breadcrumb-sep" aria-hidden="true">/</li>
        <li aria-current="page">Accessibility Statement</li>
      </ol>
    </nav>
    <span class="eyebrow">Legal</span>
    <h1 id="legal-title">Accessibility Statement</h1>
    <p class="legal-hero__updated">Last Updated: <?php echo h($lastUpdated); ?></p>
  </div>
</section>

<section class="section legal-body" aria-label="Accessibility Statement">
  <div class="container">
    <article class="content-narrow legal-prose">

      <h2>1. Our Commitment</h2>
      <p><?php echo h(legalName()); ?> wants everyone to be able to read this website and reach us, including people who use screen readers, keyboards, voice control or magnification. We apply recognized accessibility standards to <?php echo h($domain); ?> and fix problems as we find them.</p>

      <h2>2. Conformance Status</h2>
      <p>This site is designed to meet the Web Content Accessibility Guidelines (WCAG) 2.1 Level AA. WCAG sets requirements that make web content more usable for people with disabilities. Some content may not yet meet the standard in every respect, and we are working to address any gaps we find.</p>

      <h2>3. Accessibility Features</h2>
      <ul>
        <li>Semantic HTML5 with landmark regions: header, navigation, main content and footer</li>
        <li>A &ldquo;Skip to main content&rdquo; link at the top of every page</li>
        <li>A visible focus outline on links, buttons and form fields for keyboard users</li>
        <li>A mobile menu and estimate form window that work with a keyboard, with the menu button announcing whether it is open</li>
        <li>Form fields with labels attached to them, and plain-language consent text</li>
        <li>Text alternatives on meaningful images</li>
        <li>Text and button colors chosen for readable contrast</li>
        <li>A layout that adapts to phones, tablets, desktops and browser zoom</li>
        <li>Reduced animation for visitors whose devices ask for reduced motion</li>
      </ul>

      <h2>4. Known Limits</h2>
      <ul>
        <li>Content supplied by other companies, such as a Google map or review feed, may not meet WCAG in every respect. If you cannot use something, call or email us and we will give you the same information another way.</li>
        <li>Government forms and documents we link to, such as the Massachusetts Title 5 inspection form, are published by the agency and may not be fully accessible.</li>
      </ul>

      <h2>5. Feedback and Reporting Issues</h2>
      <p>If you run into an accessibility barrier on this site, please tell us which page and what happened. We read accessibility reports during our office hours, <?php echo h($businessHours); ?>, and respond as soon as we can.</p>

      <h2>6. Other Ways to Reach Us</h2>
      <p>If any part of this site is not accessible to you, you can reach us by phone, email or mail using the details below. We can give you service information in another format on request.</p>

      <h2>7. Changes to This Statement</h2>
      <p>We update this statement as the site changes. The &ldquo;Last Updated&rdquo; date above shows the latest version.</p>

      <h2>8. Contact Us</h2>
      <?php echo legalContactBlock(); ?>

    </article>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
