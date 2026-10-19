<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /terms/ — legal page (legal-compliance.md terms template, adapted for an excavation contractor).
 * Left out of the template on purpose: "Insurance Claim Work" (BDPM does no insurance work), workers' comp / "licensed and insured"
 * statements (intake holds no license or insurance data — never invent), deposit / cancellation percentages and financing
 * (none in intake; the contract governs). Governing law is Massachusetts ($companyState), venue Plymouth County ($companyCounty).
 * Entity type is blank in intake — legalName() falls back to the company name until $companyEntityType is set in config.php.
 */
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: bump when the text changes
$pageTitle       = 'Terms of Service | ' . $companyName . ' | ' . $address['city'] . ', ' . $address['state'];
$pageDescription = 'Terms for using the ' . $companyName . ' website and for estimates and excavation, septic, sea wall and helical pier work in ' . $address['city'] . ', ' . $address['state'] . '.';
$canonicalUrl    = $siteUrl . '/terms/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Terms of Service', 'url' => '/terms/'],
];
$schemaMarkup    = [legalPageSchema('Terms of Service', $pageDescription, $canonicalUrl)];
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
        <li aria-current="page">Terms of Service</li>
      </ol>
    </nav>
    <span class="eyebrow">Legal</span>
    <h1 id="legal-title">Terms of Service</h1>
    <p class="legal-hero__updated">Last Updated: <?php echo h($lastUpdated); ?></p>
  </div>
</section>

<section class="section legal-body" aria-label="Terms of Service">
  <div class="container">
    <article class="content-narrow legal-prose">

      <h2>1. Agreement to Terms</h2>
      <p>By using <?php echo h($domain); ?> or asking <?php echo h(legalName()); ?> (&ldquo;we&rdquo;, &ldquo;us&rdquo;, &ldquo;our&rdquo;) for an estimate or for work, you agree to these Terms of Service. If you do not agree, please do not use this site or our services. Our <a href="/privacy-policy/">Privacy Policy</a> explains how we handle your information.</p>

      <h2>2. Use of This Website</h2>
      <ul>
        <li>You may use this site for personal, non-commercial purposes: to learn about our services and to contact us.</li>
        <li>You may not use the site for unlawful purposes, try to reach non-public systems, copy or scrape content without written permission, submit false information through our forms, or use automated tools to extract data or send spam.</li>
      </ul>

      <h2>3. Informational Content</h2>
      <p>Pages on this site describe Massachusetts and Plymouth requirements such as Dig Safe, Title 5 and wetlands review in general terms. They are not legal, engineering or permitting advice, and rules change. Your site visit, your septic designer or engineer, and the Plymouth Board of Health, Conservation Commission and other agencies decide what applies to your property.</p>

      <h2>4. Estimates and Quotes</h2>
      <p>Our estimates are based on the information you give us and the conditions we can see at the site visit. Excavation is work in the ground, so the price can change if the scope changes or if conditions turn out different from what was visible: ledge, boulders, buried debris or old fill, groundwater, unmarked utilities, or a permit or inspection condition that was not known at the time. A verbal quote is not binding. Only a written estimate or contract that we have both agreed to sets the final terms.</p>

      <h2>5. Project Work</h2>
      <ul>
        <li>Work is governed by a written estimate or contract specific to your job.</li>
        <li>Digging begins only after a Dig Safe request has been made and utility markings are in place.</li>
        <li>Work that needs a permit, inspection or approval from a town or state agency cannot start until it is issued, and the schedule depends on those agencies.</li>
        <li>We perform work in line with applicable Massachusetts and local requirements, and to the plans or designs approved for the job.</li>
        <li>Results of a Title 5 inspection reflect the condition of the system on the day of the inspection and are filed as required; the Board of Health makes any determination that belongs to it.</li>
      </ul>

      <h2>6. Warranties</h2>
      <p>Any workmanship warranty is stated in your written estimate or contract. Manufacturer warranties on materials are provided by those manufacturers. Warranties do not cover damage from neglect, alteration or repair by others, or conditions that existed before our work and were disclosed to you.</p>

      <h2>7. Payment and Cancellation</h2>
      <p>Payment terms, deposits, schedules and cancellation terms are stated in your written estimate or contract. Past-due balances may be subject to charges as permitted by Massachusetts law and as stated in your contract.</p>

      <h2>8. Limitation of Liability</h2>
      <p>To the maximum extent permitted by Massachusetts law, our total liability for any claim related to this site or our services will not exceed the amount you paid for the specific service that gave rise to the claim. We are not liable for indirect, incidental, special or consequential damages. Nothing in these Terms limits liability that cannot be limited by law.</p>

      <h2>9. Intellectual Property</h2>
      <p>The text, graphics, photographs and logos on this site are owned by <?php echo h($companyName); ?> or used with permission, and are protected by copyright. You may not copy, distribute or create derivative works from them without our written permission.</p>

      <h2>10. Governing Law and Disputes</h2>
      <p>These Terms are governed by the laws of the Commonwealth of <?php echo h($companyState); ?>, without regard to conflict-of-laws principles. Any dispute will be resolved in the state courts located in <?php echo h($companyCounty); ?>, <?php echo h($companyState); ?>, or the federal court with jurisdiction over that county.</p>

      <h2>11. Changes to These Terms</h2>
      <p>We may update these Terms at any time. The &ldquo;Last Updated&rdquo; date above shows the latest version. Continued use of the site after an update means you accept the revised Terms.</p>

      <h2>12. Contact Us</h2>
      <?php echo legalContactBlock(); ?>

    </article>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
