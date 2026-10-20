<?php
/**
 * includes/footer.php — closes <main>, entity block, legal row, bottom bar, partner badge (last inside <footer>),
 * then cookie banner, mobile sticky bar, back-to-top, deferred scripts, </body></html>.
 * Loop variables are prefixed ($footSvc, $footArea, $footHrs) so they never collide with page variables.
 */
$footLogo  = siteLogo();
$footTel   = formatPhone($phone, 'tel');
$footMark  = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $siteName), 0, 2));
$footPlace = $address['city'] . ', ' . $address['state'];
$footAddr  = !empty($addressPublic)
    ? $address['street'] . ', ' . $footPlace . ' ' . $address['zip']
    : $footPlace . ' ' . $address['zip'];

// Group consecutive days with identical hours: Mon–Fri / Sat–Sun
$footHrsRows = [];
foreach ($hours as $footDay => $footTime) {
    $footLast = count($footHrsRows) - 1;
    if ($footLast >= 0 && $footHrsRows[$footLast]['time'] === $footTime) $footHrsRows[$footLast]['last'] = $footDay;
    else $footHrsRows[] = ['first' => $footDay, 'last' => $footDay, 'time' => $footTime];
}
$footSvcNames = array_column($services, 'name');
$footSvcList  = count($footSvcNames) > 1 ? implode(', ', array_slice($footSvcNames, 0, -1)) . ' and ' . end($footSvcNames) : implode('', $footSvcNames);
$footSms = preg_replace('/[^0-9+]/', '', (string) ($textUsNumber ?? ''));
$footHasSms = strlen($footSms) >= 10;
?>
</main>

<footer class="site-footer">
  <div class="footer-top">
    <div class="container">
      <div class="footer-grid">

        <div class="footer-col footer-brand">
          <a class="site-logo footer-logo" href="/" aria-label="<?php echo h($siteName); ?> — home">
<?php if ($footLogo): ?>
            <img src="<?php echo h($footLogo['src']); ?>" alt="<?php echo h($siteName); ?>" width="<?php echo (int) $footLogo['width']; ?>" height="<?php echo (int) $footLogo['height']; ?>" loading="lazy" decoding="async">
<?php else: ?>
            <span class="logo-mark" aria-hidden="true"><?php echo h($footMark); ?></span>
            <span class="logo-text"><span class="brand-name"><?php echo h($siteName); ?></span></span>
<?php endif; ?>
          </a>
<?php if ($tagline !== ''): ?>
          <p class="footer-tagline"><?php echo h($tagline); ?></p>
<?php endif; ?>
          <p><?php echo h($businessDescription); ?></p>
          <div class="footer-badges">
            <span><?php echo h($industryLabel); ?></span>
            <span><?php echo h($footPlace); ?></span>
            <span><?php echo h($businessHours); ?></span>
          </div>
        </div>

        <div class="footer-col">
          <h4>Services</h4>
          <ul>
<?php foreach ($services as $footSvc): ?>
            <li><a href="/services/<?php echo h($footSvc['slug']); ?>/"><?php echo h($footSvc['name']); ?></a></li>
<?php endforeach; ?>
            <li><a href="/services/">View all services</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Service Areas</h4>
          <ul>
<?php foreach ($areaPages as $footArea): ?>
            <li><a href="<?php echo h(areaHref($footArea['slug'])); ?>"><?php echo h($footArea['name'] . ', ' . $footArea['state']); ?></a></li>
<?php endforeach; ?>
            <li><a href="/service-areas/">View all areas</a></li>
          </ul>
          <h4 class="footer-col__spaced">Company</h4>
          <ul>
            <li><a href="/about/">About</a></li>
            <li><a href="/blog/">Blog</a></li>
            <li><a href="/faq/">FAQ</a></li>
            <li><a href="/contact/">Contact</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Contact</h4>
          <div class="footer-nap">
            <div><?php icon('phone', 18); ?><a href="tel:<?php echo h($phoneE164); ?>"><?php echo h($phone); ?></a></div>
            <div><?php icon('mail', 18); ?><a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a></div>
            <div><?php icon('map-pin', 18); ?><span><?php echo h($footAddr); ?></span></div>
            <div class="footer-hours"><?php icon('clock', 18); ?>
              <ul>
<?php foreach ($footHrsRows as $footHrs): ?>
                <li><?php echo h($footHrs['first'] === $footHrs['last'] ? $footHrs['first'] : substr($footHrs['first'], 0, 3) . '–' . substr($footHrs['last'], 0, 3)); ?>: <?php echo h($footHrs['time']); ?></li>
<?php endforeach; ?>
              </ul>
            </div>
          </div>
          <a class="btn btn-accent footer-cta" href="/contact/">Request an Estimate</a>
        </div>

      </div>

      <?php /* AEO entity block — same @id as the head.php LocalBusiness node so the two merge into one entity */ ?>
      <div class="footer-entity" itemscope itemtype="https://schema.org/LocalBusiness" itemid="<?php echo h(rtrim($siteUrl, '/') . '/#organization'); ?>">
        <meta itemprop="name" content="<?php echo h($siteName); ?>">
        <meta itemprop="url" content="<?php echo h(rtrim($siteUrl, '/') . '/'); ?>">
        <meta itemprop="telephone" content="<?php echo h($phoneE164); ?>">
        <meta itemprop="email" content="<?php echo h($email); ?>">
        <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" hidden>
<?php if (!empty($addressPublic) && !empty($address['street'])): ?>
          <meta itemprop="streetAddress" content="<?php echo h($address['street']); ?>">
<?php endif; ?>
          <meta itemprop="addressLocality" content="<?php echo h($address['city']); ?>">
          <meta itemprop="addressRegion" content="<?php echo h($address['state']); ?>">
          <meta itemprop="postalCode" content="<?php echo h($address['zip']); ?>">
          <meta itemprop="addressCountry" content="US">
        </span>
        <p><?php echo h($siteName); ?> is an <?php echo h(strtolower($industryLabel)); ?> based in <?php echo h($footPlace); ?>, serving <?php echo h($address['city']); ?> and the surrounding area with <?php echo h($footSvcList); ?>. Call <a href="<?php echo h($footTel); ?>"><?php echo h($phone); ?></a> or email <a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a>.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <?php /* Legal utility row — sits above the copyright line (compliance: privacy, terms, cookies, accessibility, CCPA opt-out, sitemap) */ ?>
    <nav class="footer-legal-row footer-legal-links" aria-label="Legal">
      <a href="/privacy-policy/">Privacy Policy</a>
      <span class="divider footer-legal-divider" aria-hidden="true">|</span>
      <a href="/terms/">Terms of Service</a>
      <span class="divider footer-legal-divider" aria-hidden="true">|</span>
      <a href="/cookie-policy/">Cookie Policy</a>
      <span class="divider footer-legal-divider" aria-hidden="true">|</span>
      <a href="/accessibility/">Accessibility</a>
      <span class="divider footer-legal-divider" aria-hidden="true">|</span>
      <a href="/privacy-policy/#ccpa-rights">Do Not Sell or Share My Personal Information</a>
      <span class="divider footer-legal-divider" aria-hidden="true">|</span>
      <a href="/sitemap.xml">Sitemap</a>
    </nav>
  </div>

  <div class="footer-bottom-bar">
    <div class="container footer-bottom-inner">
      <span class="footer-copy">&copy; <?php echo date('Y'); ?> <?php echo h($siteName); ?>. All rights reserved.</span>
      <span class="footer-credit"><a href="https://pageoneinsights.com" rel="dofollow" target="_blank">Web Design & Hosting by Page One Insights, LLC</a></span>
    </div>
  </div>
  <?php include __DIR__ . '/partner-badge.php'; ?>
</footer>

<div class="cookie-banner" id="cookie-banner" role="region" aria-label="Cookie notice">
  <p class="cookie-banner__text">This site uses cookies to measure traffic and improve your visit. <a href="/cookie-policy/">Cookie Policy</a></p>
  <button type="button" class="cookie-banner__dismiss">Got it</button>
</div>

<?php /* Estimate dialog — every [data-open-estimate] button opens it (main.js). One instance per page, form_location="dialog". */ ?>
<dialog class="estimate-dialog" id="estimate-dialog" aria-labelledby="estimate-dialog-title">
  <div class="dialog-head">
    <div>
      <h3 id="estimate-dialog-title">Request an estimate</h3>
      <p class="footnote">We reply during business hours, <?php echo h($businessHours); ?>.</p>
    </div>
    <button type="button" class="dialog-close" aria-label="Close" data-close-estimate><?php icon('x', 20); ?></button>
  </div>
  <div class="dialog-body">
<?php echo renderEstimateForm('dialog', 'dlg', 'Request my estimate'); ?>
  </div>
</dialog>

<div class="mobile-cta-bar<?php echo $footHasSms ? ' mobile-cta-bar--3' : ''; ?>" role="region" aria-label="Quick contact">
  <a class="mobile-cta-bar__call" href="tel:<?php echo h($phoneE164); ?>"><?php icon('phone', 18); ?>Call Now</a>
<?php if ($footHasSms): ?>
  <a class="mobile-cta-bar__text" href="sms:<?php echo h($footSms); ?>"><?php icon('mail', 18); ?>Text Us</a>
<?php endif; ?>
  <a class="mobile-cta-bar__estimate" href="/contact/" data-open-estimate>Get Estimate</a>
</div>

<button class="back-to-top" type="button" aria-label="Back to top"><?php icon('chevron-down', 20, 'rot-180'); ?></button>

<script src="/assets/js/main.js?v=<?php echo h($cssVersion); ?>" defer></script>
<script src="/assets/js/animations.js?v=<?php echo h($cssVersion); ?>" defer></script>
<script src="/assets/js/effects.js?v=<?php echo h($cssVersion); ?>" defer></script>
</body>
</html>
