<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /privacy-policy/ — legal page (legal-compliance.md privacy template, adapted to this site's real data flows).
 * Data flows described below trace to the code: forms POST to the Page One leads endpoint ($formAction), first-touch
 * attribution cookie p1_ft (includes/attribution.php), GA4 once the measurement ID is set (config.php), cookie bar flag in
 * localStorage (assets/js/main.js). No Formsubmit, no photo-upload field, no payment collection exist on this site.
 * Entity type is blank in intake ($companyEntityType) — legalName() falls back to the company name until it is set.
 */
$lastUpdated     = 'October 19, 2026';   // fixed on purpose: bump when the text changes (never date('F j, Y'), which would re-date the policy on every visit)
$pageTitle       = 'Privacy Policy | ' . $companyName . ' | ' . $address['city'] . ', ' . $address['state'];
$pageDescription = 'How ' . $companyName . ' in ' . $address['city'] . ', ' . $address['state'] . ' collects, uses and protects information from its website and estimate forms, plus your privacy rights.';
$canonicalUrl    = $siteUrl . '/privacy-policy/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'legal';
$pageType        = 'other';
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Privacy Policy', 'url' => '/privacy-policy/'],
];
$schemaMarkup    = [legalPageSchema('Privacy Policy', $pageDescription, $canonicalUrl)];
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
        <li aria-current="page">Privacy Policy</li>
      </ol>
    </nav>
    <span class="eyebrow">Legal</span>
    <h1 id="legal-title">Privacy Policy</h1>
    <p class="legal-hero__updated">Last Updated: <?php echo h($lastUpdated); ?></p>
  </div>
</section>

<section class="section legal-body" aria-label="Privacy Policy">
  <div class="container">
    <article class="content-narrow legal-prose">

      <h2>1. Introduction</h2>
      <p>This Privacy Policy explains how <?php echo h(legalName()); ?> (&ldquo;we&rdquo;, &ldquo;us&rdquo;, &ldquo;our&rdquo;) collects, uses and protects personal information when you visit <?php echo h($domain); ?>, fill out an estimate form, or contact us about excavation, septic, sea wall, helical pier or Title 5 inspection work in <?php echo h($address['city']); ?>, <?php echo h($address['state']); ?>.</p>

      <h2>2. Information We Collect</h2>
      <ul>
        <li><strong>Information you provide:</strong> your name, phone number, email address, job address and town, the service you need and any project details you type into our forms, send by email, or give us by phone or at a site visit.</li>
        <li><strong>Consent records:</strong> which consent boxes you checked, the version of our consent language, and the page you submitted from.</li>
        <li><strong>Collected automatically:</strong> IP address, browser type, device type, pages viewed, referring website, and any campaign parameters in the link you used (such as UTM tags or a Google Ads click ID).</li>
        <li><strong>First-visit cookie:</strong> the first time you visit, we set a first-party cookie that records the page you landed on, where you came from and a random session ID, so we can tell which page led to your inquiry. See our <a href="/cookie-policy/">Cookie Policy</a>.</li>
      </ul>

      <h2>3. How We Use Your Information</h2>
      <ul>
        <li>Respond to your inquiry and schedule a site visit or inspection</li>
        <li>Prepare estimates and carry out the work you hire us for</li>
        <li>Communicate with you during an active project</li>
        <li>Send calls, texts or emails where you have given the matching consent (see Sections 6 and 7)</li>
        <li>Understand which pages and searches bring in inquiries, and improve this website</li>
        <li>Prevent spam and abuse of our forms</li>
        <li>Meet legal, licensing, tax and recordkeeping obligations</li>
      </ul>

      <h2>4. How We Share Your Information</h2>
      <ul>
        <li>We do <strong>not</strong> sell personal information.</li>
        <li><strong>Lead handling:</strong> form submissions are received by a lead system run by Page One Insights, LLC, our web design and hosting partner. It stores the submission, filters spam, and emails it to us. A copy goes to Page One Insights customer service so a lost or misrouted inquiry can be traced.</li>
        <li><strong>Analytics and hosting:</strong> Google (Google Analytics 4) and our website hosting provider process visitor data on our behalf.</li>
        <li><strong>Project professionals and agencies:</strong> when your job needs a filing or a hand-off, such as a Title 5 inspection report filed with the Board of Health, or plans shared with your septic designer or engineer, we share the details that filing or hand-off needs.</li>
        <li><strong>Subcontractors and suppliers:</strong> as needed to complete your project.</li>
        <li><strong>Legal compliance:</strong> where required by Massachusetts or federal law, a court order, or to protect our rights.</li>
        <li><strong>Business transfers:</strong> if the business is merged, sold or reorganized, your information may transfer with it.</li>
      </ul>

      <h2>5. Your Privacy Rights</h2>

      <h3 id="state-rights">Massachusetts Residents</h3>
      <p>You may ask us what personal information we hold about you, ask us to correct it, or ask us to delete it. Contact us using the details in Section 12. We will confirm your identity and respond within a reasonable time, and we will honor your request as far as the law and our recordkeeping obligations allow.</p>

      <h3 id="ccpa-rights">California Residents (CCPA / CPRA)</h3>
      <p>If you are a California resident, you have these rights under the California Consumer Privacy Act (CCPA) and California Privacy Rights Act (CPRA):</p>
      <ul>
        <li><strong>Right to know</strong> what personal information we collect, use and disclose.</li>
        <li><strong>Right to delete</strong> personal information we collected from you, subject to legal exceptions.</li>
        <li><strong>Right to correct</strong> inaccurate personal information.</li>
        <li><strong>Right to opt out of sale or sharing</strong> of personal information. We do not sell personal information, but you may submit an opt-out request for our records.</li>
        <li><strong>Right to limit use</strong> of sensitive personal information.</li>
        <li><strong>Right to non-discrimination</strong> for exercising any of these rights.</li>
      </ul>
      <p><strong>How to exercise your rights:</strong> email <a href="mailto:<?php echo h($companyEmail); ?>"><?php echo h($companyEmail); ?></a> or call <a href="tel:<?php echo h($companyPhoneE164); ?>"><?php echo h($companyPhone); ?></a>. We respond to verified requests within 45 days.</p>

      <h3>Residents of Other States</h3>
      <p>Residents of Colorado, Virginia, Connecticut, Utah, Texas and other states with privacy laws have similar rights. Contact us the same way to exercise them.</p>

      <h2>6. Phone Calls and Text Messages (TCPA)</h2>
      <p>Checking the optional SMS box on a form means you agree to receive text messages from <?php echo h($companyName); ?> at the number you gave us. Message types may include appointment reminders, service updates and offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe or HELP for help. <strong>Consent is not a condition of purchase.</strong> You can also stop texts by emailing <a href="mailto:<?php echo h($companyEmail); ?>"><?php echo h($companyEmail); ?></a>. Calls to the number you provide about your request are covered by your submission; ask us to stop at any time and we will.</p>

      <h2>7. Email Communications</h2>
      <p>Checking the optional email box means you agree to receive emails from <?php echo h($companyName); ?> about your inquiry, services, promotions and news. Every marketing email includes an unsubscribe link, or you can write to <a href="mailto:<?php echo h($companyEmail); ?>"><?php echo h($companyEmail); ?></a>. Replies about your own estimate or project are not marketing email.</p>

      <h2>8. Data Retention</h2>
      <p>We keep form submissions, estimates and job records for as long as needed to provide our services, answer follow-up questions, and meet legal, tax and recordkeeping obligations. When the information is no longer needed, we delete it or de-identify it.</p>

      <h2>9. Data Security</h2>
      <p>This site and its forms use HTTPS encryption, and we limit access to submissions to the people who need them. No method of transmission or storage is completely secure, so we cannot guarantee absolute security, but we work to reduce the risks.</p>

      <h2>10. Children&rsquo;s Privacy</h2>
      <p>This site is not directed to children under 13, and we do not knowingly collect information from them. If you believe a child has sent us information, contact us and we will delete it.</p>

      <h2>11. Third-Party Links and Changes</h2>
      <p>This site links to outside websites such as our Google Business Profile and government agencies. We are not responsible for their privacy practices, so read their policies separately. We may update this Privacy Policy from time to time; the &ldquo;Last Updated&rdquo; date above shows the latest version, and material changes will be posted on this page.</p>

      <h2>12. Contact Us</h2>
      <p>For privacy questions or to exercise your rights:</p>
      <?php echo legalContactBlock(); ?>

    </article>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
