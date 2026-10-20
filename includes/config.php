<?php
/**
 * includes/config.php — single source of site-wide variables (BDPM Site Services).
 * Every value below traces to build-plan.json. Values the plan leaves blank (tagline, insurance, license,
 * certifications, social links, map embed, geo, entity type) stay empty and the templates omit anything empty.
 */

// ---- Identity ---------------------------------------------------------------------------------
$slug          = 'bdpm-site-services';                 // exact build directory name
$siteName      = 'BDPM Site Services';                 // build-plan company_name
$tagline       = '';                                   // build-plan tagline is empty — never invent
$industry      = 'excavation-contractor';
$industryLabel = 'Excavation Contractor';              // build-plan industry
$ownerName     = 'Patrick Howard';                     // build-plan owner_name

// ---- Contact ----------------------------------------------------------------------------------
$phone          = '(508) 989-7101';
$phoneRaw       = '5089897101';
$phoneE164      = '+15089897101';
$phoneSecondary = '';                                  // build-plan phone_secondary is empty
$email          = 'patrick@bdpmma.com';
$contactEmail   = $email;
// Lead routing only (server-side, never rendered)
$leadNotificationEmail = 'patrick@bdpmma.com';
$leadNotificationPhone = '(508) 989-7101';

$addressPublic  = true;                                // build-plan address_public
$addressIsPoBox = false;
$address = [
    'street' => '168 Beaver Dam Rd',
    'city'   => 'Plymouth',
    'state'  => 'MA',
    'zip'    => '02360',
];
$primaryCity   = 'Plymouth';
$primaryCounty = 'Plymouth County';                    // Plymouth, MA is in Plymouth County

// ---- Domain / URLs ----------------------------------------------------------------------------
// build-plan has no production_domain (its "domain" field holds only the slug), so default to "${slug}.pageone.cloud".
// The client's current site (web_sources) is https://www.bdpmsiteservices.com/ — switch $domain to it at launch.
$domain  = 'bdpm-site-services.pageone.cloud';
$siteUrl = 'https://' . $domain;
// $canonicalUrl is NOT set here — each page sets its own from $siteUrl + path before including head.php.

// ---- SEO --------------------------------------------------------------------------------------
$primaryKeyword    = 'Site Excavation';                // build-plan seo.primary_keyword
// build-plan seo.secondary_keywords, verbatim (trailing-space duplicate "Excavation Contractor " dropped)
$secondaryKeywords = [
    'title inspections', 'septic systems', 'helical piers', 'Excavation Contractor', 'Excavation Services',
    'Excavation Company', 'Excavation Services Near Me', 'Professional Excavation Contractor',
    'Residential Excavation', 'Commercial Excavation', 'Land Excavation', 'Earthwork Contractor',
    'Drainage Excavation', 'Sewer Excavation', 'Soil Excavation', 'Rock Excavation', 'Pond Excavation',
    'sea wall construction',
];
$serviceRadiusMiles = 25;                              // build-plan seo.target_radius

// ---- Services (5 — build-plan services[], each a solo page per service_grouping) ---------------
// Slugs match build-plan pages[].slug -> /services/{slug}/. Keywords: page primary_keyword + the secondary keywords
// that fit each service. Descriptions are factual one-liners; page copy comes from the copywriter deck.
$services = [
    ['name' => 'Site Construction / Excavation', 'slug' => 'site-construction-excavation',
     'description' => 'Site preparation, excavation and grading for residential and commercial properties in Plymouth, MA.',
     'keywords' => ['site construction / excavation Plymouth MA', 'Site Excavation', 'Excavation Contractor',
                    'Excavation Services', 'Excavation Company', 'Residential Excavation', 'Commercial Excavation',
                    'Land Excavation', 'Earthwork Contractor', 'Drainage Excavation', 'Sewer Excavation',
                    'Soil Excavation', 'Rock Excavation', 'Pond Excavation']],
    ['name' => 'Septic System Installation', 'slug' => 'septic-system-installation',
     'description' => 'Septic system installation for homes and businesses in Plymouth, MA.',
     'keywords' => ['septic system installation Plymouth MA', 'septic systems']],
    ['name' => 'Sea Walls', 'slug' => 'sea-walls',
     'description' => 'Sea wall construction for waterfront properties in Plymouth, MA.',
     'keywords' => ['sea walls Plymouth MA', 'sea wall construction']],
    ['name' => 'Helical Piers', 'slug' => 'helical-piers',
     'description' => 'Helical pier installation for foundations and structures in Plymouth, MA.',
     'keywords' => ['helical piers Plymouth MA', 'helical piers']],
    ['name' => 'Title 5 Inspections', 'slug' => 'title-5-inspections',
     'description' => 'Massachusetts Title 5 septic system inspections in Plymouth, MA.',
     'keywords' => ['title 5 inspections Plymouth MA', 'title inspections']],
];

// ---- Service areas (Premium: /service-areas/{slug}/ per town; the hub is /service-areas/) -------
$serviceAreas = ['Plymouth, MA'];                      // build-plan service_areas
$areaPages = [
    ['slug' => 'plymouth', 'name' => 'Plymouth', 'state' => 'MA'],
];

// ---- Hours ------------------------------------------------------------------------------------
// build-plan business_hours: "Mon-Fri 7am-5pm, Sat-Sun closed"
$hours = [
    'Monday'    => '7:00 AM – 5:00 PM',
    'Tuesday'   => '7:00 AM – 5:00 PM',
    'Wednesday' => '7:00 AM – 5:00 PM',
    'Thursday'  => '7:00 AM – 5:00 PM',
    'Friday'    => '7:00 AM – 5:00 PM',
    'Saturday'  => 'Closed',
    'Sunday'    => 'Closed',
];
$businessHours = 'Mon–Fri 7am–5pm, Sat–Sun closed';   // one-line form for the v8 components
// schema.org openingHoursSpecification source
$openingHours = [
    ['days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'], 'opens' => '07:00', 'closes' => '17:00'],
];

// ---- Brand ------------------------------------------------------------------------------------
// build-plan design.colors holds no hex values and assets.logo is null; these match the tokens the scaffold wrote into
// framework.css (:root --color-primary/secondary/accent). Replace with logo-analysis values once a logo is supplied.
$colors = ['primary' => '#4f8a8b', 'secondary' => '#222831', 'accent' => '#fbd46d'];   // old-site palette (2026-10-20): teal, charcoal, yellow; light gray #eeeeee + white in framework.css
// Founded 1993 per the client's previous site (2026-10-20 revision; build-plan content.years = 5 was a placeholder guess).
$yearEstablished = 1993;
$yearsInBusiness = (int) date('Y') - $yearEstablished;

// ---- Credentials ------------------------------------------------------------------------------
$licenseNumber  = '';                                  // none in build-plan — never invent
$insurance      = '';                                  // build-plan content.insurance is empty
$certifications = [];                                  // build-plan content.certifications is empty

// Short factual description for schema / AEO (build-plan content.description)
$businessDescription = 'BDPM Site Services is an excavation contractor based in Plymouth, MA. Services include site construction and excavation, septic system installation, sea walls, helical piers and Title 5 inspections.';

// ---- Legal identity (used by the four legal pages) ----------------------------------------------
// build-plan has no entity type or formation state. State is the state of operation — confirm entity type and
// formation state with the client before launch (intake question, legal-compliance.md).
$companyName       = 'BDPM Site Services';
$companyEntityType = '';                               // PLACEHOLDER: unconfirmed
$companyState      = 'Massachusetts';
$companyCounty     = 'Plymouth County';
$companyEmail      = $email;
$companyPhone      = $phone;
$companyPhoneE164  = $phoneE164;
$companyAddress    = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];

// ---- Google Business Profile ------------------------------------------------------------------
$gbp = [
    'place_id'      => 'ChIJnTb84wix5IkRgsX6SoWtC94',  // integrations.gbp_place_id
    'share_url'     => 'https://maps.google.com/?cid=16000072889164023170',   // google_business_profile_url (tracking params dropped)
    'url'           => 'https://maps.google.com/?cid=16000072889164023170',
    'directions'    => 'https://www.google.com/maps/dir/?api=1&destination=place_id:ChIJnTb84wix5IkRgsX6SoWtC94',
    'review_url'    => 'https://search.google.com/local/writereview?placeid=ChIJnTb84wix5IkRgsX6SoWtC94',
    'embed_src'     => '',                             // integrations.gbp_map_embed is null — no map embed
    'reviews_count' => 0,                              // build-plan reviews[] is empty: no ratings, never AggregateRating
];
$geo = [];                                             // integrations.geo is null — omit GeoCoordinates

// ---- Social / analytics -----------------------------------------------------------------------
$socialLinks       = [];                               // none provided — footer renders icons only for platforms the client uses
$googleAnalyticsId = 'G-XXXXXXXXXX';                   // placeholder until the client's GA4 measurement ID is set

// ---- Forms ------------------------------------------------------------------------------------
$formAction      = 'https://db.pageone.cloud/functions/v1/leads/bdpm-site-services';   // build-plan form_action, verbatim
// HMAC secret for the spam-shield `_ft` field. Blank in the repo: the real value is injected by
// ~/crm/scripts/patch-leads-spamshield.py at promote time. p1-form-helpers.php skips the shield when empty.
$leadsFormSecret = '';

// ---- v8 components (written exactly as build-plan integrations holds them) ---------------------
$estimateTool   = [];   // integrations.estimate_tool.authorized is false
$bookingWindows = [];   // integrations.booking.authorized is false
$textUsNumber   = '';   // integrations.text_us_number is null (accepts_sms false) -> two-button sticky bar
$financing      = [];   // integrations.financing is null
$serviceZips    = [];   // integrations.service_zips not provided

$cssVersion = '6';      // the SINGLE framework.css cache-bust; bump here on every framework.css / critical.css change

// ---- Lead attribution (first-touch cookie + p1_attribution_fields()) — must stay last, before any output ----
require_once __DIR__ . '/attribution.php';
