<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /contact/ — Phase 5 contact page (full estimate form, three unbundled consent checkboxes).
 * Form contract: posts to $formAction (build-plan form_action, verbatim) with _next, _honey, attribution, consent_version/consent_page,
 * and the legacy-named twins _consent_version/_consent_page/_honeypot the Phase 5 brief asked for (harmless extras; the leads endpoint
 * reads the unprefixed names). The service select is named `service` (the field the endpoint stores), not service_requested.
 * Map: integrations.gbp_map_embed is null, so no iframe is printed; the Find Us band shows the address, hours and a Get Directions link
 * and renders .map-embed automatically once config.php $gbp['embed_src'] holds the embed URL.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$pageTitle       = 'Contact ' . $siteName . ' | Excavation in Plymouth, MA';
$pageDescription = 'Call ' . $phone . ' or send the estimate form to ' . $siteName . ' at ' . $address['street'] . ', Plymouth, MA. Excavation, septic, sea walls, helical piers and Title 5.';
$canonicalUrl    = $siteUrl . '/contact/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'contact';
$pageType        = 'contact';
$heroPreload     = [];
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Contact', 'url' => '/contact/'],
];

$ctTel   = formatPhone($phone, 'tel');
$ctPlace = $address['city'] . ', ' . $address['state'];
$ctAddr  = $address['street'] . ', ' . $ctPlace . ' ' . $address['zip'];

// Hours grouped by identical consecutive days (Mon–Fri / Sat–Sun), same grouping the footer uses
$ctHours = [];
foreach ($hours as $ctDay => $ctTime) {
    $ctLast = count($ctHours) - 1;
    if ($ctLast >= 0 && $ctHours[$ctLast]['time'] === $ctTime) $ctHours[$ctLast]['last'] = $ctDay;
    else $ctHours[] = ['first' => $ctDay, 'last' => $ctDay, 'time' => $ctTime];
}

$schemaMarkup = [[
    '@context' => 'https://schema.org',
    '@type' => 'ContactPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => $pageTitle,
    'description' => $pageDescription,
    'isPartOf' => ['@type' => 'WebSite', 'url' => rtrim($siteUrl, '/') . '/'],
    'about' => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
    'mainEntity' => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
]];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Contact — page composition (tokens only). Motif: the survey stake — a
   flagged marker line down the form card and a plotted "you are here" band.
   ========================================================================== */
.contact h1, .contact h2, .contact h3 { text-wrap: balance; }
.contact p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + contour field ---- */
.contact-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 50% 70% at 0% 0%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              radial-gradient(ellipse 40% 60% at 100% 100%, color-mix(in srgb, var(--color-secondary) 30%, transparent), transparent 70%);
}
.contact-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.contact-hero__contours {
  position: absolute; inset: 0 0 0 45%; z-index: -1; pointer-events: none;
  background: repeating-radial-gradient(ellipse 60% 48% at 70% 50%, transparent 0 26px, color-mix(in srgb, var(--color-white) 7%, transparent) 26px 27px);
  -webkit-mask: radial-gradient(closest-side at 70% 50%, var(--color-black) 55%, transparent 100%);
  mask: radial-gradient(closest-side at 70% 50%, var(--color-black) 55%, transparent 100%);
}
.contact-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.contact-hero .breadcrumb a:hover { color: var(--color-white); }
.contact-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.contact-hero .hero-copy { max-width: 44rem; }
.contact-hero .hero-title { max-width: 22ch; }
.contact-hero .text-accent { color: var(--color-accent-bright); }
.contact-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.contact-hero .link-call svg { color: var(--color-accent-bright); }
.contact-hero .link-call:hover { color: var(--color-white); }
.contact-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 7%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.contact-hero .hero-chips svg { color: var(--color-accent-bright); }

/* ---- Form + aside ---- */
.contact-main { background: var(--color-paper); }
.contact-main .estimate { grid-template-columns: minmax(0, 1.25fr) minmax(0, .75fr); }
.contact-form-card { position: relative; display: grid; gap: var(--space-md); padding: var(--space-xl); background: var(--color-surface); border: 1px solid var(--color-line); border-top: 4px solid var(--color-accent); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); }
.contact-form-card h2 { margin: 0; }
.contact-form-card > p { margin: 0; color: var(--color-ink-2); }
.contact-form-card .answer-block { margin: 0; background: var(--color-paper-2); }
.contact-form-card .answer-block p { margin: 0; }
.contact-form-card .field label small { font-weight: 500; color: var(--color-muted); }
.contact-form-card .form-consent-fieldset { display: grid; gap: var(--space-xs); padding: var(--space-md); background: var(--color-paper-2); border-radius: var(--radius); }
.contact-form-card .form-consent-item { margin: 0; }
.contact-form-card .form-consent-item .consent-label { font-size: var(--font-size-xs); line-height: 1.5; color: var(--color-ink-2); }
.contact-form-card .form-consent-required .consent-label { font-size: var(--fs-small); color: var(--color-ink); }
.contact-form-card .required-star { color: var(--color-accent-dark); font-weight: 800; }
.contact-form-card .form-consent-item a { text-decoration: underline; text-underline-offset: .15em; }
.contact-form-card .btn { margin-top: var(--space-xs); }

.contact-aside { display: grid; gap: var(--space-lg); padding-top: var(--space-lg); align-content: start; }
.contact-aside h2, .contact-aside h3 { margin: 0; font-size: var(--fs-h3); }
.contact-aside .next-steps { margin-top: 0; }
.contact-call { display: grid; gap: var(--space-xs); padding: var(--space-lg); border-radius: var(--radius-lg); color: var(--color-white); background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 130%); box-shadow: var(--shadow); }
.contact-call span { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.contact-call a { color: var(--color-white); font-family: var(--font-heading); font-weight: 800; font-size: var(--fs-h2); line-height: 1.1; text-decoration: none; min-height: 44px; display: inline-flex; align-items: center; }
.contact-call a:hover { color: var(--color-accent-bright); }
.contact-call p { margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 78%, transparent); }

/* ---- Find us: dark band, plotted address + hours (+ map once an embed exists) ---- */
.contact-find .section-head { max-width: 62ch; }
.contact-find .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.contact-find__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: start; }
.contact-find__grid--solo { grid-template-columns: minmax(0, 1fr); }
.contact-find__card { display: grid; gap: var(--space-lg); padding: var(--space-xl); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }
.contact-find__facts { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-lg); margin: 0; }
.contact-find__facts div { display: grid; grid-template-columns: 1.5rem 1fr; gap: var(--space-xs) var(--space-sm); align-content: start; }
.contact-find__facts dt { display: contents; }
.contact-find__facts dt svg { color: var(--color-accent-bright); margin-top: 2px; }
.contact-find__facts dt b { font-family: var(--font-accent); font-size: var(--font-size-lg); letter-spacing: .08em; text-transform: uppercase; color: var(--color-white); }
.contact-find__facts dd { grid-column: 2; margin: 0; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 82%, transparent); }
.contact-find__facts dd a { color: var(--color-white); }
.contact-find__facts dd span { display: block; }
.contact-find__actions { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-md) var(--space-xl); }
.contact-find .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.contact-find .link-call svg { color: var(--color-accent-bright); }
.contact-find .map-embed { box-shadow: var(--shadow-lg); border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent); }

/* ---- Closing CTA ---- */
@media (min-width: 801px) { .contact-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; } }
.contact-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.contact-cta .link-call svg { color: var(--color-accent-bright); }
.contact-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.contact-cta .floating-ring { right: -5rem; bottom: -9rem; opacity: .1; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .contact-main .estimate { grid-template-columns: 1fr; }
  .contact-find__grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
  .contact-form-card { padding: var(--space-lg); }
  .contact-find__facts { grid-template-columns: 1fr; }
  .contact-find__card { padding: var(--space-lg); }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="contact">

<!-- ============ HERO (interior, no form: the full form is the next section) ============ -->
<section class="hero hero--interior contact-hero" aria-labelledby="contact-hero-title">
  <span class="contact-hero__contours" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li aria-current="page">Contact</li>
        </ol>
      </nav>
      <span class="eyebrow">Contact · <?php echo h($ctPlace); ?></span>
      <h1 class="hero-title" id="contact-hero-title">Contact <span class="text-accent"><?php echo h($siteName); ?></span> in Plymouth, MA</h1>
      <p class="hero-answer">Call <?php echo h($phone); ?> or send the form below. <?php echo h($siteName); ?> replies during office hours, Monday to Friday, 7am to 5pm.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="<?php echo h($ctTel); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
        <a class="link-call" href="mailto:<?php echo h($email); ?>"><?php icon('mail', 18); ?><?php echo h($email); ?></a>
      </div>
      <ul class="hero-chips" aria-label="At a glance">
        <li><?php icon('clock', 16); ?><?php echo h($businessHours); ?></li>
        <li><?php icon('map-pin', 16); ?><?php echo h($address['street']); ?></li>
        <li><?php icon('clipboard-list', 16); ?>Free estimates</li>
      </ul>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<!-- ============ FORM + WHAT HAPPENS NEXT ============ -->
<section class="section contact-main" id="estimate" aria-labelledby="contact-form-title">
  <div class="container">
    <div class="estimate">

      <div class="contact-form-card reveal-left">
        <span class="eyebrow-label">Free estimate</span>
        <h2 id="contact-form-title">How do I request an estimate from BDPM Site Services?</h2>
        <div class="answer-block"><p>Fill out the form with your name, phone number and a few lines about the job, or call <a href="<?php echo h($ctTel); ?>"><?php echo h($phone); ?></a>. BDPM Site Services calls back during office hours to set up a site visit at the property.</p></div>

        <form action="<?php echo h($formAction); ?>" method="POST" class="estimate-form" id="contact-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="text" name="_honeypot" style="display:none" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="contact">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <input type="hidden" name="_consent_version" value="v2.1">
          <input type="hidden" name="_consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <input type="hidden" name="address_state" value="<?php echo h($address['state']); ?>">
          <?php echo p1_attribution_fields('contact'); ?>

          <div class="form-grid">
            <div class="field"><label for="contact-name">Your name *</label><input id="contact-name" type="text" name="name" autocomplete="name" required></div>
            <div class="field"><label for="contact-phone">Phone *</label><input id="contact-phone" type="tel" name="phone" autocomplete="tel" required></div>
            <div class="field full"><label for="contact-email">Email *</label><input id="contact-email" type="email" name="email" autocomplete="email" required></div>
            <div class="field full"><label for="contact-service">Service needed</label><select id="contact-service" name="service"><?php echo p1_service_options(); ?></select></div>
            <div class="field"><label for="contact-street">Job street address <small>(optional)</small></label><input id="contact-street" type="text" name="address_street" autocomplete="street-address"></div>
            <div class="field"><label for="contact-city">Town <small>(optional)</small></label><input id="contact-city" type="text" name="address_city" autocomplete="address-level2"></div>
            <div class="field full"><label for="contact-message">About the job</label><textarea id="contact-message" name="message" rows="5"></textarea></div>
          </div>

          <fieldset class="form-consent-fieldset">
            <legend class="form-consent-legend">Communication Consent</legend>
            <label class="form-consent-item" for="contact-email-opt">
              <input id="contact-email-opt" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo h($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email or by emailing <?php echo h($contactEmail); ?>. Message frequency varies.</span>
            </label>
            <label class="form-consent-item" for="contact-sms-opt">
              <input id="contact-sms-opt" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo h($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
            </label>
            <label class="form-consent-item form-consent-required" for="contact-terms">
              <input id="contact-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
              <span class="consent-label">I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. <span class="required-star">*</span></span>
            </label>
          </fieldset>

          <button type="submit" class="btn btn-primary btn-lg btn-block">Send my estimate request</button>
        </form>
      </div>

      <aside class="contact-aside reveal-right" aria-label="Contact details and next steps">
        <div class="contact-call">
          <span>Prefer to talk?</span>
          <a href="<?php echo h($ctTel); ?>"><?php echo h($phone); ?></a>
          <p>Office hours <?php echo h($businessHours); ?>.</p>
        </div>
        <div>
          <h3>What happens after you send the form</h3>
          <ol class="next-steps">
            <li><strong>We call you back</strong>During office hours, to talk through the job.</li>
            <li><strong>Site visit</strong>We look at soil, ledge, access and any wetlands or water on the property.</li>
            <li><strong>Written estimate</strong>Scope, price and schedule in writing before any work is booked.</li>
          </ol>
        </div>
        <div class="nap">
          <div><?php icon('mail', 18); ?><a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a></div>
          <div><?php icon('map-pin', 18); ?><span><?php echo h($ctAddr); ?></span></div>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- ============ FIND US (dark band) ============ -->
<?php $ctHasMap = !empty($gbp['embed_src']); ?>
<section class="section texture-grain edge-torn-top contact-find" aria-labelledby="contact-find-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Find us</span>
      <h2 id="contact-find-title">Where is BDPM Site Services located in Plymouth, MA?</h2>
      <p class="answer-block"><?php echo h($siteName); ?> is at <?php echo h($ctAddr); ?>. The office and crew work Monday to Friday, 7am to 5pm, and the company serves Plymouth and the surrounding area.</p>
    </div>
    <div class="contact-find__grid<?php echo $ctHasMap ? '' : ' contact-find__grid--solo'; ?>">
      <div class="contact-find__card reveal-up">
        <dl class="contact-find__facts">
          <div><dt><?php icon('map-pin', 20); ?><b>Address</b></dt><dd><span><?php echo h($address['street']); ?></span><span><?php echo h($ctPlace . ' ' . $address['zip']); ?></span></dd></div>
          <div><dt><?php icon('clock', 20); ?><b>Hours</b></dt><dd>
<?php foreach ($ctHours as $ctRow): ?>
            <span><?php echo h($ctRow['first'] === $ctRow['last'] ? $ctRow['first'] : substr($ctRow['first'], 0, 3) . '–' . substr($ctRow['last'], 0, 3)); ?>: <?php echo h($ctRow['time']); ?></span>
<?php endforeach; ?>
          </dd></div>
          <div><dt><?php icon('phone', 20); ?><b>Phone</b></dt><dd><a href="<?php echo h($ctTel); ?>"><?php echo h($phone); ?></a></dd></div>
          <div><dt><?php icon('mail', 20); ?><b>Email</b></dt><dd><a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a></dd></div>
        </dl>
        <div class="contact-find__actions">
          <a class="btn btn-accent btn-lg" href="<?php echo h($gbp['directions']); ?>" target="_blank" rel="noopener"><?php icon('route', 20); ?>Get Directions</a>
          <a class="link-call" href="<?php echo h($gbp['url']); ?>" target="_blank" rel="noopener"><?php icon('external-link', 18); ?>View on Google Maps</a>
        </div>
      </div>
<?php if ($ctHasMap): ?>
      <div class="map-embed reveal-up reveal-delay-2">
        <iframe src="<?php echo h($gbp['embed_src']); ?>" title="Map showing the location of <?php echo h($siteName); ?> in <?php echo h($ctPlace); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ CLOSING CTA ============ -->
<section class="closing-cta texture-grain edge-wave-top contact-cta" aria-labelledby="contact-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Ready when you are</span>
      <h2 id="contact-cta-title">Have a Plymouth lot that needs work?</h2>
      <p>Call or send the form and BDPM Site Services will set up a site visit. The written estimate follows what the visit finds.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="<?php echo h($ctTel); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
      <a class="link-call" href="#estimate"><?php icon('send', 18); ?>Send the form</a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
