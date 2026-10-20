<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /about/ — Phase 5 About page (premium editorial structure, warm-human archetype).
 * Photos (2026-10-20): photo hero (.hero--photo, LCP preloaded), a plans photo beside the story, a crew figure beside the owner card and an
 * "at work" three-photo strip, all real photos from includes/photos.php. Intake supplies NO license / insurance / certifications and no team
 * names beyond the owner, so nothing is invented about the people in the photos. Every fact traces to build-plan.json / config.php or repeats a claim the homepage
 * already makes (owner-run, Est. 2021, residential + commercial, site visit -> written estimate -> Dig Safe/approvals -> dig/build/grade). Anything
 * the page wants but intake lacks (founder story, milestones, license, insurance, crew, photos) is listed in /content-confirmations.json.
 * The Credentials section is data-driven: licence / insurance / certification rows print only when config.php holds a value, so nothing is invented
 * and the section fills in by itself once the client supplies them.
 * Lead form: ONE mid-page .cta-band after the first content section (v6.3 placement rule), form id `cta-band`; no hero form on About.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';

$pageTitle       = 'About ' . $siteName . ' | Excavation in Plymouth, MA';
$pageDescription = $siteName . ' is an excavation contractor in Plymouth, MA, owned by ' . $ownerName . '. Septic systems, sea walls, helical piers and Title 5 inspections.';
$canonicalUrl    = $siteUrl . '/about/';
$ogImage         = '/assets/images/og-default.jpg';
$currentPage     = 'about';
$pageType        = 'about';
$abHeroPhoto     = 'site-crew-inspecting-crane-lift';
$heroPreload     = photoHeroPreload($abHeroPhoto, '100vw');
$breadcrumbs     = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'About', 'url' => '/about/'],
];

$abTel   = formatPhone($phone, 'tel');
$abPlace = $address['city'] . ', ' . $address['state'];
$abAddr  = $address['street'] . ', ' . $abPlace . ' ' . $address['zip'];
$abBase  = rtrim($siteUrl, '/');

$schemaMarkup = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        '@id' => $canonicalUrl . '#webpage',
        'url' => $canonicalUrl,
        'name' => $pageTitle,
        'description' => $pageDescription,
        'isPartOf' => ['@type' => 'WebSite', 'url' => $abBase . '/'],
        'about' => ['@id' => $abBase . '/#organization'],
        'mainEntity' => ['@id' => $abBase . '/#organization'],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        '@id' => $abBase . '/about/#owner',
        'name' => $ownerName,
        'jobTitle' => 'Owner',
        'worksFor' => ['@id' => $abBase . '/#organization'],
        'url' => $canonicalUrl,
    ],
];

// Fact sheet (hero) — intake facts only
$abFacts = [
    ['users', 'Owner', $ownerName],
    ['map-pin', 'Based in', $abPlace . ' ' . $address['zip']],
    ['calendar-check', 'Working in Plymouth since', (string) (int) $yearEstablished],
    ['tractor', 'Services', count($services) . ': excavation to Title 5'],
    ['clock', 'Office hours', $businessHours],
];

// Marginalia beside the story
$abNotes = [
    ['map-pin', 'Based at', $address['street'] . ', ' . $abPlace],
    ['hammer', 'Does', 'Excavation, septic installs, sea walls, helical piers, Title 5 inspections'],
    ['home', 'For', 'Residential and commercial properties'],
];

// What the company stands behind — each line repeats a practice the homepage and service pages already state
$abValues = [
    ['search', 'Look before quoting', 'Every job starts with a site visit: soil, ledge, access, wetlands and where the water goes. The written estimate is built on what the visit finds.'],
    ['phone', 'Call 811 first', 'Dig Safe gets at least 72 hours\' notice, and BDPM Site Services confirms the utility markings are in place before any dig.'],
    ['landmark', 'Approvals before the dig', 'Conservation Commission and Board of Health steps are lined up before work is scheduled, and septic systems follow the approved design.'],
    ['check-circle', 'Leave it graded', 'The work is done to plan, inspected where required, and the site is left at final grade.'],
];

// Timeline stations
$abStations = [
    ['mark' => (string) (int) $yearEstablished, 'title' => 'Founded in Plymouth', 'text' => $siteName . ' begins working in ' . $abPlace . ', led by ' . $ownerName . '.', 'state' => 'start'],
    ['mark' => 'Today', 'title' => count($services) . ' services, one contractor', 'text' => 'Site construction and excavation, septic system installation, Title 5 inspections, sea walls and helical piers.', 'state' => 'now'],
    ['mark' => 'Next', 'title' => 'Your site visit', 'text' => 'A walk across your lot, then a written estimate with the scope, price and schedule.', 'state' => 'next'],
];

// Credentials — verifiable listings always; licence / insurance / certifications only when config.php holds them
$abCreds = [
    ['map', 'Google Business Profile', 'The BDPM Site Services listing on Google Maps shows the Plymouth address, phone number and hours.', $gbp['url'], 'View the listing'],
    ['phone', 'A Plymouth office that answers', $abAddr . '. Phone ' . $phone . ', ' . $businessHours . '.', $abTel, 'Call ' . $phone],
    ['users', 'Owner-run', $ownerName . ' owns and runs ' . $siteName . '.', '', ''],
];
if (trim((string) $licenseNumber) !== '') {
    $abCreds[] = ['badge-check', 'License', (string) $licenseNumber, '', ''];
}
if (trim((string) $insurance) !== '') {
    $abCreds[] = ['shield-check', 'Insurance', (string) $insurance, '', ''];
}
foreach ((array) $certifications as $abCert) {
    $abCredName = is_array($abCert) ? (string) ($abCert['name'] ?? '') : (string) $abCert;
    if ($abCredName === '') continue;
    $abCreds[] = ['award', 'Certification', $abCredName, is_array($abCert) ? (string) ($abCert['url'] ?? '') : '', is_array($abCert) && !empty($abCert['url']) ? 'Verify it' : ''];
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   About — page composition (tokens only). Motif: the survey tag and the
   station line — a fact sheet in the hero, a founded-to-your-lot line below.
   ========================================================================== */
.about h1, .about h2, .about h3 { text-wrap: balance; }
.about p { text-wrap: pretty; }

/* ---- Hero: layered gradient + noise + contour field + fact sheet ---- */
.about-hero::before {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none;
  background: radial-gradient(ellipse 50% 70% at 0% 0%, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%),
              radial-gradient(ellipse 40% 60% at 100% 100%, color-mix(in srgb, var(--color-secondary) 30%, transparent), transparent 70%);
}
.about-hero::after {
  content: ""; position: absolute; inset: 0; z-index: -1; pointer-events: none; opacity: .3; mix-blend-mode: overlay;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.6'/%3E%3C/svg%3E");
}
.about-hero .hero-bg img { object-position: 50% 35%; }
.about-hero__contours {
  position: absolute; inset: 0 0 0 40%; z-index: -1; pointer-events: none;
  background: repeating-radial-gradient(ellipse 60% 48% at 70% 50%, transparent 0 26px, color-mix(in srgb, var(--color-white) 7%, transparent) 26px 27px);
  -webkit-mask: radial-gradient(closest-side at 70% 50%, var(--color-black) 55%, transparent 100%);
  mask: radial-gradient(closest-side at 70% 50%, var(--color-black) 55%, transparent 100%);
}
.about-hero .breadcrumb { color: color-mix(in srgb, var(--color-white) 70%, transparent); margin-bottom: var(--space-sm); }
.about-hero .breadcrumb a:hover { color: var(--color-white); }
.about-hero .breadcrumb li { display: inline-flex; align-items: center; min-height: 44px; }
.about-hero .hero-title { max-width: 20ch; }
.about-hero .text-accent { color: var(--color-accent-bright); }
.about-hero .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.about-hero .link-call svg { color: var(--color-accent-bright); }
.about-hero .link-call:hover { color: var(--color-white); }
.about-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 7%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.about-hero .hero-chips svg { color: var(--color-accent-bright); }
.ab-sheet { position: relative; display: grid; gap: var(--space-md); padding: var(--space-xl); border-radius: var(--radius-lg); background: color-mix(in srgb, var(--color-white) 6%, transparent); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); border-top: 4px double var(--color-accent-bright); box-shadow: var(--shadow-lg); }
.ab-sheet h2 { margin: 0; font-family: var(--font-accent); font-size: var(--font-size-xl); letter-spacing: .1em; text-transform: uppercase; color: var(--color-white); }
.ab-sheet dl { display: grid; gap: 0; margin: 0; }
.ab-sheet dl > div { display: grid; grid-template-columns: 1.5rem minmax(0, 1fr); gap: 0 var(--space-sm); padding: var(--space-sm) 0; border-top: 1px dashed color-mix(in srgb, var(--color-white) 18%, transparent); }
.ab-sheet dt { display: contents; font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.ab-sheet dt svg { grid-row: span 2; margin-top: 2px; color: var(--color-accent-bright); }
.ab-sheet dd { grid-column: 2; margin: 0; font-size: var(--fs-body); color: var(--color-white); }

/* ---- Story: prose + marginalia ---- */
.ab-story { background: var(--color-paper); }
.ab-story__grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, .65fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.ab-story__copy { display: grid; gap: var(--space-md); }
.ab-story__copy .answer-block { margin: 0; background: var(--color-surface); }
.ab-story__copy > p:not(.answer-block) { margin: 0; max-width: 62ch; color: var(--color-ink-2); }
.ab-story__copy a { color: var(--color-accent-dark); font-weight: 600; text-decoration: underline; text-underline-offset: .15em; }
.ab-story__copy > p:nth-of-type(2)::first-letter { font-family: var(--font-heading); font-weight: 800; font-size: 3.4em; line-height: .85; float: left; padding: .08em .12em 0 0; color: var(--color-accent-dark); }
.ab-story__side { position: sticky; top: calc(var(--nav-height) + var(--space-xl)); display: grid; gap: var(--space-lg); }
.ab-story__fig { margin: 0; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); background: var(--color-surface); }
.ab-story__fig img { width: 100%; height: auto; aspect-ratio: 4 / 3; object-fit: cover; }
.ab-story__fig figcaption { padding: var(--space-sm) var(--space-md); font-size: var(--font-size-xs); color: var(--color-muted); border-top: 1px solid var(--color-line); }
.ab-notes { display: grid; gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ab-notes li { position: relative; display: grid; gap: var(--space-1); padding: var(--space-md) var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-left: 4px solid var(--color-accent); border-radius: 0 var(--radius-lg) var(--radius-lg) 0; box-shadow: var(--shadow-sm); }
.ab-notes li:nth-child(odd) { background: var(--color-card-tint-3); }
.ab-notes li:nth-child(2) { margin-left: var(--space-lg); }
.ab-notes b { font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); display: flex; align-items: center; gap: var(--space-xs); }
.ab-notes span { font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.5; }

/* ---- Mid-page estimate band (compact lead form, v6.3 placement: after the first content section) ---- */
.cta-band { padding-block: clamp(2.5rem, 6vw, 4rem); }
.cta-band__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 2fr); gap: clamp(1.5rem, 4vw, 3rem); align-items: center; }
.cta-band__copy { display: grid; gap: var(--space-sm); align-content: center; }
.cta-band__copy h2 { margin: 0; font-size: var(--fs-h3); }
.cta-band__copy p { margin: 0; font-size: var(--fs-small); }
.cta-band .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.cta-band .link-call svg { color: var(--color-accent-bright); }
.cta-band .cta-band__card { padding: var(--space-lg); border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-ink); border-top: 4px solid var(--color-accent); box-shadow: var(--shadow-lg); }
.cta-band .cta-band__card p, .cta-band .cta-band__card label { color: var(--color-ink-2); }
.cta-band__form { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-sm) var(--space-md); align-items: end; }
.cta-band__form .field { min-width: 0; }
.cta-band__form .field--btn { grid-column: span 2; }
.cta-band__form .btn { width: 100%; }
.cta-band__form .consent { grid-column: span 2; margin: 0; font-size: var(--font-size-xs); }
.cta-band__form .consent a { text-decoration: underline; text-underline-offset: .15em; }
.cta-band__form .cta-band__note { margin: 0; font-size: var(--font-size-xs); }
.cta-band .cta-band__card .cta-band__note { color: var(--color-muted); }

/* ---- Values + owner ---- */
.ab-values { background: var(--color-paper-2); }
.ab-values__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.ab-values__intro { display: grid; gap: var(--space-md); }
.ab-values__intro .answer-block { margin: 0; background: var(--color-surface); }
.ab-owner { position: relative; display: grid; gap: var(--space-md); justify-items: start; padding: var(--space-xl) var(--space-xl) calc(var(--space-2xl) + var(--space-md)); color: var(--color-white); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); isolation: isolate; overflow: hidden; background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 130%); clip-path: polygon(0 0, 100% 0, 100% calc(100% - var(--space-xl)), calc(100% - var(--space-xl)) 100%, 0 100%); }
.ab-owner::before { content: ""; position: absolute; inset: 0; z-index: -1; background: repeating-radial-gradient(ellipse 80% 60% at 110% 0%, transparent 0 20px, color-mix(in srgb, var(--color-white) 7%, transparent) 20px 21px); }
.ab-owner__mono { display: grid; place-items: center; width: 4.5rem; height: 4.5rem; border-radius: var(--radius-full); background: var(--color-accent); font-family: var(--font-accent); font-size: var(--font-size-3xl); letter-spacing: .04em; color: var(--color-ink); box-shadow: 0 0 0 6px color-mix(in srgb, var(--color-accent) 30%, transparent); }
.ab-owner h3 { margin: 0; color: var(--color-white); font-size: var(--fs-h3); }
.ab-owner__role { margin: 0; font-family: var(--font-accent); font-size: var(--font-size-lg); letter-spacing: .1em; text-transform: uppercase; color: var(--color-accent-bright); }
.ab-owner ul { display: grid; gap: var(--space-xs); margin: 0; padding: 0; list-style: none; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.ab-owner li { display: grid; grid-template-columns: 1.4rem minmax(0, 1fr); gap: var(--space-xs); align-items: start; }
.ab-owner li svg { color: var(--color-accent-bright); margin-top: 2px; }
.ab-owner a { color: var(--color-white); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; min-height: 44px; }
.ab-crew { position: relative; margin: 0; display: grid; justify-items: center; padding: var(--space-lg) var(--space-lg) 0; border-radius: var(--radius-lg); overflow: hidden; background: linear-gradient(160deg, var(--color-card-tint-1) 0%, var(--color-card-tint-3) 100%); border: 1px solid var(--color-line); }
.ab-crew::before { content: ""; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, transparent 0 14px, color-mix(in srgb, var(--color-ink) 4%, transparent) 14px 15px); pointer-events: none; }
.ab-crew img { position: relative; width: auto; max-width: 100%; height: auto; max-height: 340px; object-fit: contain; }
.ab-crew figcaption { position: absolute; left: var(--space-md); top: var(--space-md); font-family: var(--font-accent); font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.ab-values__list { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-md); }
.ab-values__list li { display: grid; grid-template-columns: 3.25rem minmax(0, 1fr); gap: var(--space-md); padding: var(--space-lg); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); transition: transform var(--transition), box-shadow var(--transition); }
.ab-values__list li:hover { transform: translateX(4px); box-shadow: var(--shadow); }
.ab-values__list li:nth-child(odd) { background: var(--color-card-tint-1); }
.ab-values__list li:nth-child(even) { margin-left: var(--space-xl); background: var(--color-card-tint-3); }
.ab-values__icon { display: grid; place-items: center; width: 3.25rem; height: 3.25rem; border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); }
.ab-values__list h3 { margin: 0 0 var(--space-1); font-size: var(--font-size-lg); }
.ab-values__list p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }

/* ---- Timeline: the station line (dark band) ---- */
.ab-time .section-head { max-width: 66ch; }
.ab-time .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 88%, transparent); margin: 0; }
.ab-line { position: relative; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); margin: var(--space-3xl) 0 0; padding: 0; list-style: none; }
.ab-line::before { content: ""; position: absolute; left: 0; right: 0; top: 1.4rem; height: 6px; border-radius: var(--radius-full); background: linear-gradient(90deg, var(--color-accent-bright) 0%, var(--color-accent) 55%, color-mix(in srgb, var(--color-white) 18%, transparent) 100%); }
.ab-line::after { content: ""; position: absolute; left: 0; right: 0; top: 2.4rem; height: var(--space-sm); background: repeating-linear-gradient(90deg, color-mix(in srgb, var(--color-white) 30%, transparent) 0 1px, transparent 1px 24px); }
.ab-line li { position: relative; display: grid; gap: var(--space-xs); justify-items: center; text-align: center; padding: 0 var(--space-md); }
.ab-line i { position: relative; z-index: 1; width: 2.9rem; height: 2.9rem; border-radius: var(--radius-full); background: var(--color-dark); border: 3px solid var(--color-accent-bright); }
.ab-line .is-now i { background: var(--color-accent); border-color: var(--color-white); box-shadow: 0 0 0 8px color-mix(in srgb, var(--color-accent) 30%, transparent); }
.ab-line .is-next i { border-style: dashed; border-color: color-mix(in srgb, var(--color-white) 45%, transparent); }
.ab-line b { margin-top: var(--space-sm); font-family: var(--font-accent); font-size: var(--font-size-2xl); letter-spacing: .06em; text-transform: uppercase; color: var(--color-white); }
.ab-line h3 { margin: 0; font-size: var(--font-size-lg); color: var(--color-white); }
.ab-line p { margin: 0; max-width: 30ch; font-size: var(--fs-small); color: color-mix(in srgb, var(--color-white) 76%, transparent); }

/* ---- At work: three-photo strip ---- */
.ab-work { background: var(--color-paper); }
.ab-work__grid { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.4fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.ab-work__intro { display: grid; gap: var(--space-md); }
.ab-work__intro .answer-block { margin: 0; background: var(--color-surface); }
.ab-work .sp-gallery-grid { margin: 0; }
.ab-work .sp-gallery-item { box-shadow: var(--shadow); }

/* ---- Credentials ---- */
.ab-creds { background: var(--color-surface); }
.ab-creds .section-head { max-width: 66ch; }
.ab-creds .answer-block { margin: 0; }
.ab-creds__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-md); margin: 0; padding: 0; list-style: none; }
.ab-creds__grid li { display: grid; gap: var(--space-xs); align-content: start; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.ab-creds__grid li:nth-child(3n+1) { background: var(--color-card-tint-1); }
.ab-creds__grid li:nth-child(3n+2) { background: var(--color-card-tint-3); }
.ab-creds__grid li:nth-child(3n) { background: var(--color-card-tint-2); }
.ab-creds__icon { display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: var(--radius-lg); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); }
.ab-creds__grid h3 { margin: var(--space-xs) 0 0; font-size: var(--font-size-lg); }
.ab-creds__grid p { margin: 0; font-size: var(--fs-small); color: var(--color-ink-2); line-height: 1.55; }
.ab-creds__grid a { display: inline-flex; align-items: center; gap: var(--space-xs); min-height: 44px; margin-top: var(--space-xs); color: var(--color-accent-dark); font-weight: 700; font-size: var(--fs-small); text-decoration: underline; text-underline-offset: .15em; }

/* ---- Closing CTA ---- */
@media (min-width: 801px) { .ab-cta .container { grid-template-columns: minmax(0, 1.3fr) auto; } }
.ab-cta .link-call { color: color-mix(in srgb, var(--color-white) 90%, transparent); }
.ab-cta .link-call svg { color: var(--color-accent-bright); }
.ab-cta .actions { align-items: center; gap: var(--space-md) var(--space-xl); }
.ab-cta .floating-ring { right: -5rem; bottom: -9rem; opacity: .1; }

/* ---- Responsive ---- */
@media (max-width: 1000px) {
  .ab-story__grid, .ab-values__grid, .cta-band__grid, .ab-work__grid { grid-template-columns: 1fr; }
  .ab-story__side { position: static; }
  .ab-creds__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 760px) {
  .ab-line { grid-template-columns: 1fr; gap: var(--space-lg); padding-left: var(--space-xl); margin-top: var(--space-2xl); }
  .ab-line::before { left: .9rem; right: auto; top: 0; bottom: 0; width: 6px; height: auto; background: linear-gradient(180deg, var(--color-accent-bright), var(--color-accent) 60%, color-mix(in srgb, var(--color-white) 18%, transparent)); }
  .ab-line::after { display: none; }
  .ab-line li { grid-template-columns: 2.9rem minmax(0, 1fr); justify-items: start; text-align: left; gap: 0 var(--space-md); margin-left: calc(-1 * var(--space-xl)); padding: 0; }
  .ab-line i { grid-row: span 3; }
  .ab-line b { margin-top: 0; }
  .ab-line p { max-width: none; }
}
@media (max-width: 700px) {
  .cta-band__form { grid-template-columns: 1fr; }
  .cta-band__form .field--btn, .cta-band__form .consent { grid-column: auto; }
  .ab-values__list li:nth-child(even) { margin-left: 0; }
  .ab-notes li:nth-child(2) { margin-left: 0; }
  .ab-creds__grid { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
  .ab-values__list li { grid-template-columns: 1fr; }
  .ab-sheet { padding: var(--space-lg); }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="about">

<!-- ============ HERO (photo hero + fact sheet, no form) ============ -->
<section class="hero hero--interior hero--photo about-hero" aria-labelledby="about-hero-title">
  <div class="hero-bg"><?php echo photoPicture($abHeroPhoto, '100vw', ['eager' => true]); ?></div>
  <div class="hero-overlay" aria-hidden="true"></div>
  <span class="about-hero__contours" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-grid">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li aria-current="page">About</li>
          </ol>
        </nav>
        <span class="eyebrow">About · <?php echo h($abPlace); ?></span>
        <h1 class="hero-title" id="about-hero-title">An <span class="text-accent">owner-run excavation contractor</span> in Plymouth, MA</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> is an excavation contractor at <?php echo h($address['street']); ?> in <?php echo h($abPlace); ?>, owned by <?php echo h($ownerName); ?>. It handles five kinds of ground work.</p>
        <div class="hero-actions">
          <a class="btn btn-accent btn-lg" href="/contact/" data-open-estimate>Get a free estimate</a>
          <a class="link-call" href="<?php echo h($abTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips" aria-label="At a glance">
          <li><?php icon('users', 16); ?>Owner-run</li>
          <li><?php icon('map-pin', 16); ?>Plymouth, MA</li>
          <li><?php icon('clock', 16); ?><?php echo h($businessHours); ?></li>
        </ul>
      </div>

      <aside class="ab-sheet" aria-labelledby="ab-sheet-title">
        <h2 id="ab-sheet-title">Company fact sheet</h2>
        <dl>
<?php foreach ($abFacts as $abFact): ?>
          <div><dt><?php icon($abFact[0], 18); ?><?php echo h($abFact[1]); ?></dt><dd><?php echo h($abFact[2]); ?></dd></div>
<?php endforeach; ?>
        </dl>
      </aside>
    </div>
  </div>
  <span class="grain" aria-hidden="true"></span>
</section>

<!-- ============ STORY (long version) ============ -->
<section class="section ab-story" aria-labelledby="ab-story-title">
  <div class="container">
    <div class="ab-story__grid">
      <div class="ab-story__copy reveal-left">
        <span class="eyebrow-label">Our story</span>
        <h2 id="ab-story-title">Who is <span class="text-accent"><?php echo h($siteName); ?></span> and what does the company do in Plymouth?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> is an excavation contractor based in <?php echo h($abPlace); ?> and owned by <?php echo h($ownerName); ?>. The company has worked in Plymouth since <?php echo (int) $yearEstablished; ?> on the ground work most property projects start with: digging and grading, septic systems, sea walls, helical piers and Title 5 inspections.</p>
        <p><?php echo h($siteName); ?> works from <?php echo h($address['street']); ?> in <?php echo h($abPlace); ?> and is run by its owner, <?php echo h($ownerName); ?>. The company takes on five kinds of work: <a href="/services/site-construction-excavation/">site construction and excavation</a>, <a href="/services/septic-system-installation/">septic system installation</a>, <a href="/services/title-5-inspections/">Title 5 inspections</a>, <a href="/services/sea-walls/">sea walls</a> and <a href="/services/helical-piers/">helical piers</a>, for residential and commercial properties.</p>
        <p>Those five jobs share the same ground. A septic system, a sea wall and a pier foundation all start with the same questions about soil, ledge and groundwater, and often the same reviews by the Plymouth Board of Health or Conservation Commission. Handling them as one trade keeps a project on one schedule, and a Title 5 inspection that turns up a failed system can lead straight to the replacement without bringing in a second contractor.</p>
        <p>Plymouth lots range from sandy and gravelly soils to clay, fill and exposed ledge, and many sit near wetlands or open water. Two lots on the same street can need different machines and different approvals, which is why every <?php echo h($siteName); ?> job begins with a site visit and a written estimate instead of a number guessed over the phone.</p>
      </div>
      <div class="ab-story__side reveal-right">
        <figure class="ab-story__fig">
          <?php echo photoPicture('reviewing-site-plans-laptop-hard-hat', '(max-width: 1000px) 92vw, 420px'); ?>
          <figcaption>Every job starts on paper: the plan, the soil results and the permit steps before the site visit.</figcaption>
        </figure>
        <ul class="ab-notes" aria-label="Company notes">
<?php foreach ($abNotes as $abNote): ?>
          <li><b><?php icon($abNote[0], 16); ?><?php echo h($abNote[1]); ?></b><span><?php echo h($abNote[2]); ?></span></li>
<?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ MID-PAGE ESTIMATE BAND (one lead form on this page, id cta-band) ============ -->
<section class="cta-band texture-grain edge-torn-top" id="estimate" aria-labelledby="cta-band-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-band__grid">
      <div class="cta-band__copy">
        <span class="eyebrow-label">Free estimate</span>
        <h2 id="cta-band-title">Ready to talk about your lot?</h2>
        <p>Send the basics and <?php echo h($siteName); ?> will call you back during office hours.</p>
        <a class="link-call" href="<?php echo h($abTel); ?>"><?php icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
      <div class="cta-band__card">
        <form action="<?php echo h($formAction); ?>" method="POST" class="estimate-form cta-band__form" id="cta-band-form">
          <input type="hidden" name="_next" value="<?= htmlspecialchars($siteUrl) ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="cta-band">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <?php echo p1_attribution_fields('cta-band'); ?>
          <div class="field"><label for="cta-name">Name *</label><input id="cta-name" type="text" name="name" autocomplete="name" required></div>
          <div class="field"><label for="cta-phone">Phone *</label><input id="cta-phone" type="tel" name="phone" autocomplete="tel" required></div>
          <div class="field"><label for="cta-email">Email *</label><input id="cta-email" type="email" name="email" autocomplete="email" required></div>
          <div class="field"><label for="cta-service">Service needed</label><select id="cta-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <div class="field field--btn"><button type="submit" class="btn btn-primary btn-lg">Get my free estimate</button></div>
          <label class="consent" for="cta-terms"><input id="cta-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <p class="cta-band__note">Office hours <?php echo h($businessHours); ?>.</p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ============ VALUES + OWNER ============ -->
<section class="section slant-top ab-values" aria-labelledby="ab-values-title">
  <div class="container-wide">
    <div class="ab-values__grid">
      <div class="ab-values__intro reveal-left">
        <span class="eyebrow-label">How we work</span>
        <h2 id="ab-values-title">What does <span class="text-accent"><?php echo h($siteName); ?></span> stand behind on every job?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> stands behind four habits on every Plymouth job: look at the site before quoting, call Dig Safe before digging, line up approvals before work starts, and leave the site at final grade.</p>
        <div class="ab-owner">
          <span class="ab-owner__mono" aria-hidden="true"><?php echo h(strtoupper(substr($ownerName, 0, 1) . substr(strrchr($ownerName, ' ') ?: ' ', 1, 1))); ?></span>
          <div>
            <h3><?php echo h($ownerName); ?></h3>
            <p class="ab-owner__role">Owner, <?php echo h($siteName); ?></p>
          </div>
          <ul>
            <li><?php icon('phone', 16); ?><a href="<?php echo h($abTel); ?>"><?php echo h($phone); ?></a></li>
            <li><?php icon('mail', 16); ?><a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a></li>
            <li><?php icon('map-pin', 16); ?><span><?php echo h($abAddr); ?></span></li>
          </ul>
        </div>
        <figure class="ab-crew">
          <?php echo photoPicture('bdpm-crew-member-hard-hat-safety-vest', '(max-width: 1000px) 60vw, 300px'); ?>
          <figcaption>On site</figcaption>
        </figure>
      </div>
      <ol class="ab-values__list" aria-label="How BDPM Site Services works">
<?php foreach ($abValues as $abValI => $abValue): ?>
        <li class="<?php echo $abValI % 2 === 0 ? 'reveal-right' : 'reveal-up'; ?> reveal-delay-<?php echo ($abValI % 3) + 1; ?>">
          <span class="ab-values__icon"><?php icon($abValue[0], 24); ?></span>
          <div><h3><?php echo h($abValue[1]); ?></h3><p><?php echo h($abValue[2]); ?></p></div>
        </li>
<?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ============ TIMELINE (dark band) ============ -->
<section class="section texture-grain edge-curve-top ab-time" aria-labelledby="ab-time-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Timeline</span>
      <h2 id="ab-time-title">When did <?php echo h($siteName); ?> start, and where does it stand today?</h2>
      <p class="answer-block"><?php echo h($siteName); ?> started working in Plymouth, MA in <?php echo (int) $yearEstablished; ?> and now handles <?php echo count($services); ?> kinds of ground work: excavation, septic systems, Title 5 inspections, sea walls and helical piers. The next station on the line is a site visit to your property.</p>
    </div>
    <ol class="ab-line reveal-up" aria-label="BDPM Site Services timeline">
<?php foreach ($abStations as $abStation): ?>
      <li class="is-<?php echo h($abStation['state']); ?>"><i aria-hidden="true"></i><b><?php echo h($abStation['mark']); ?></b><h3><?php echo h($abStation['title']); ?></h3><p><?php echo h($abStation['text']); ?></p></li>
<?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ============ AT WORK (three registry photos) ============ -->
<section class="section ab-work" aria-labelledby="ab-work-title">
  <div class="container-wide">
    <div class="ab-work__grid">
      <div class="ab-work__intro reveal-left">
        <span class="eyebrow-label">At work</span>
        <h2 id="ab-work-title">What does a job with <span class="text-accent"><?php echo h($siteName); ?></span> look like from the first meeting?</h2>
        <p class="answer-block">A job with <?php echo h($siteName); ?> starts at a table with the plans, moves to a handshake on the scope and price, and ends with the crew checking the layout beside the machine. These photos show those three points on a Plymouth project.</p>
      </div>
      <div class="sp-gallery-grid reveal-right">
      <figure class="sp-gallery-item reveal-up reveal-delay-1"><?php echo photoPicture('site-team-planning-blueprints-table', '(max-width: 700px) 92vw, 520px'); ?><figcaption>Plans, calculator and tape measure on the table</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-2"><?php echo photoPicture('contractor-client-handshake-estimate', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Agreeing the scope and the written estimate</figcaption></figure>
      <figure class="sp-gallery-item reveal-up reveal-delay-3"><?php echo photoPicture('excavation-contractor-blueprints-excavator', '(max-width: 700px) 92vw, 380px'); ?><figcaption>Checking the layout beside the excavator</figcaption></figure>
      </div>
    </div>
  </div>
</section>

<!-- ============ CREDENTIALS ============ -->
<section class="section edge-parallelogram-top ab-creds" aria-labelledby="ab-creds-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow-label">Credentials</span>
      <h2 id="ab-creds-title">How can I check out <?php echo h($siteName); ?> before I hire?</h2>
      <p class="answer-block">Before you hire, check <?php echo h($siteName); ?>&rsquo;s Plymouth address, phone number and hours on its Google Business Profile, then call the office directly with any question about the job.</p>
    </div>
    <ul class="ab-creds__grid">
<?php foreach ($abCreds as $abCredI => $abCred): ?>
      <li class="reveal-up reveal-delay-<?php echo ($abCredI % 3) + 1; ?>">
        <span class="ab-creds__icon"><?php icon($abCred[0], 24); ?></span>
        <h3><?php echo h($abCred[1]); ?></h3>
        <p><?php echo h($abCred[2]); ?></p>
<?php if ($abCred[3] !== ''): ?>
        <a href="<?php echo h($abCred[3]); ?>"<?php echo strpos($abCred[3], 'http') === 0 ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo h($abCred[4]); ?> <?php icon('arrow-right', 16); ?></a>
<?php endif; ?>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<?php
// ============ GOOGLE REVIEWS (prints nothing until the client has written reviews in the feed) ============
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$abReviews = p1_google_reviews($slug, ['heading' => 'What do Plymouth customers say about BDPM Site Services on Google?']);
if ($abReviews !== ''): ?>
<section class="section reviews-section" aria-label="Google reviews"><div class="container"><?php echo $abReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FINAL CTA ============ -->
<section class="closing-cta texture-grain edge-wave-top ab-cta" aria-labelledby="ab-cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div>
      <span class="eyebrow-label">Work with <?php echo h($siteName); ?></span>
      <h2 id="ab-cta-title">Ready for a site visit in Plymouth?</h2>
      <p>Call <?php echo h($ownerName); ?>&rsquo;s office or send the contact form. The written estimate follows what the visit finds.</p>
    </div>
    <div class="actions">
      <a class="btn btn-accent btn-lg" href="/contact/">Contact BDPM Site Services</a>
      <a class="link-call" href="<?php echo h($abTel); ?>"><?php icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
