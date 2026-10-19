<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /thank-you — landing page after any lead form (every form's _next is {siteUrl}/thank-you; .htaccess maps /thank-you to this file).
 * Noindexed, and keep it disallowed in robots.txt when that file is written. "What to expect" repeats the homepage's "What happens next"
 * (callback in office hours -> site visit -> written estimate); no response-time promise because intake holds none.
 */
$noindex         = true;
$pageTitle       = 'Thank You | ' . $siteName . ' | ' . $address['city'] . ', ' . $address['state'];
$pageDescription = 'Your request reached ' . $siteName . ' in ' . $address['city'] . ', ' . $address['state'] . '. Here is what happens next and where to read more while you wait.';
$canonicalUrl    = $siteUrl . '/thank-you/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'thank-you';
$pageType        = 'other';
$heroPreload     = [];

$tyTel   = formatPhone($phone, 'tel');
$tyCards = serviceCards();

$tySteps = [
    ['phone', 'We call you back', 'During office hours, ' . $businessHours . ', to talk through the job and the address.'],
    ['search', 'Site visit', 'We look at soil, ledge, access and any wetlands or water on the property.'],
    ['clipboard-list', 'Written estimate', 'Scope, price and schedule in writing before any work is booked.'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* Thank-you — confirmation hero, three-step expectation row, service links. Tokens only. */
.ty h1, .ty h2, .ty h3 { text-wrap: balance; }
.ty p { text-wrap: pretty; }
.ty-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 50% 70% at 0% 0%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              radial-gradient(ellipse 40% 60% at 100% 100%, color-mix(in srgb, var(--color-success) 24%, transparent), transparent 70%);
}
.ty-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.ty-hero .hero-copy { max-width: 42rem; }
.ty-hero__check { display: grid; place-items: center; width: 4rem; height: 4rem; border-radius: var(--radius-full); background: color-mix(in srgb, var(--color-success) 30%, transparent); border: 2px solid var(--color-success); color: var(--color-white); }
.ty-hero .hero-title { max-width: 20ch; }
.ty-hero .text-accent { color: var(--color-accent-bright); }
.ty-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.ty-hero .link-call svg { color: var(--color-accent-bright); }

.ty-next { background: var(--color-paper); }
.ty-next .section-head { max-width: 62ch; }
.ty-next .answer-block { margin: 0; background: var(--color-surface); }
.ty-steps { counter-reset: tystep; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ty-steps li { counter-increment: tystep; position: relative; display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-xl) var(--space-lg) var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.ty-steps li:nth-child(1) { background: var(--color-card-tint-1); }
.ty-steps li:nth-child(2) { background: var(--color-card-tint-3); margin-top: var(--space-lg); }
.ty-steps li:nth-child(3) { background: var(--color-card-tint-2); margin-top: var(--space-2xl); }
.ty-steps li::before { content: "Step " counter(tystep); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.ty-steps svg { position: absolute; top: var(--space-lg); right: var(--space-lg); color: var(--color-accent-dark); }
.ty-steps h3 { margin: 0; font-size: var(--font-size-xl); }
.ty-steps p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

.ty-read { background: var(--color-paper-2); }
.ty-read .section-head { max-width: 62ch; }
.ty-read__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ty-read__grid a { display: grid; grid-template-columns: 2.75rem minmax(0, 1fr); gap: var(--space-xs) var(--space-md); align-items: center; height: 100%; min-height: 44px; padding: var(--space-md) var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); color: var(--color-ink); text-decoration: none; box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition); }
.ty-read__grid a:hover { transform: translateY(-3px); box-shadow: var(--shadow); border-color: var(--color-accent); }
.ty-read__icon { grid-row: span 2; display: grid; place-items: center; width: 2.75rem; height: 2.75rem; border-radius: var(--radius-lg); background: var(--color-card-tint-3); color: var(--color-accent-dark); }
.ty-read__grid b { font-family: var(--font-heading); font-weight: 800; font-size: var(--font-size-base); line-height: 1.25; }
.ty-read__grid span { font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.45; }
.ty-read__more { display: flex; flex-wrap: wrap; gap: var(--space-md); margin-top: var(--space-xl); }

@media (min-width: 801px) { .ty-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; } }
.ty-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.ty-cta .link-call svg { color: var(--color-accent-bright); }
.ty-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.ty-cta .floating-ring { right: -5rem; bottom: -9rem; opacity: .1; }

@media (max-width: 1000px) { .ty-read__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 800px) {
  .ty-steps { grid-template-columns: 1fr; }
  .ty-steps li:nth-child(2), .ty-steps li:nth-child(3) { margin-top: 0; }
}
@media (max-width: 600px) { .ty-read__grid { grid-template-columns: 1fr; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="ty">

<section class="hero hero--interior ty-hero" aria-labelledby="ty-title">
  <div class="container">
    <div class="hero-copy">
      <span class="ty-hero__check" aria-hidden="true"><?php icon('check-circle', 32); ?></span>
      <span class="eyebrow">Request received</span>
      <h1 class="hero-title" id="ty-title"><span class="text-accent">Thank you.</span> Your request is in.</h1>
      <p class="hero-answer"><?php echo h($siteName); ?> received your message and will call you back during office hours, <?php echo h($businessHours); ?>.</p>
      <div class="hero-actions">
        <a class="btn btn-accent btn-lg" href="<?php echo h($tyTel); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
        <a class="link-call" href="/"><?php icon('home', 18); ?>Back to the homepage</a>
      </div>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<section class="section ty-next" aria-labelledby="ty-next-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">What to expect</span>
      <h2 id="ty-next-title">What happens after you contact <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">Someone from <?php echo h($siteName); ?> calls you back during office hours, then schedules a site visit at the property. A written estimate with the scope, price and schedule follows the visit.</p>
    </div>
    <ol class="ty-steps">
<?php foreach ($tySteps as $tyI => $tyStep): ?>
      <li class="reveal-up reveal-delay-<?php echo $tyI + 1; ?>"><?php icon($tyStep[0], 26); ?><h3><?php echo h($tyStep[1]); ?></h3><p><?php echo h($tyStep[2]); ?></p></li>
<?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="section slant-top ty-read" aria-labelledby="ty-read-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">While you wait</span>
      <h2 id="ty-read-title">What can I read about my project before the call?</h2>
      <p>Each <?php echo h($siteName); ?> service page covers the rules, the steps and the questions Plymouth property owners ask most.</p>
    </div>
    <ul class="ty-read__grid">
<?php foreach ($services as $tyI => $tySvc): $tyCard = $tyCards[$tySvc['slug']]; ?>
      <li class="reveal-up reveal-delay-<?php echo ($tyI % 3) + 1; ?>"><a href="/services/<?php echo h($tySvc['slug']); ?>/"><span class="ty-read__icon"><?php icon($tyCard['icon'], 22); ?></span><b><?php echo h($tySvc['name']); ?></b><span><?php echo h($tyCard['desc']); ?></span></a></li>
<?php endforeach; ?>
      <li class="reveal-up reveal-delay-3"><a href="/faq/"><span class="ty-read__icon"><?php icon('info', 22); ?></span><b>Common questions answered</b><span>Dig Safe, wetlands, cost and process answers.</span></a></li>
    </ul>
  </div>
</section>

<section class="closing-cta texture-grain edge-wave-top ty-cta" aria-labelledby="ty-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Need us sooner?</span>
      <h2 id="ty-cta-title">Call the office during business hours</h2>
      <p>If the job is urgent or you would rather talk now, <?php echo h($siteName); ?> answers the phone <?php echo h($businessHours); ?>.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="<?php echo h($tyTel); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
      <a class="link-call" href="/services/"><?php icon('arrow-right', 18); ?>Browse services</a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
