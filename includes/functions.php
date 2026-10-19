<?php
/**
 * includes/functions.php — shared helpers for head.php / header.php / footer.php and every page.
 * Loaded with require_once from head.php (after config.php). Everything is function_exists-guarded.
 * Loop variables inside these functions are local, so they cannot collide with page variables.
 */

if (!function_exists('h')) {
    /** HTML-escape for attribute and text output. */
    function h($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

/* ---- Navigation state --------------------------------------------------------------------------- */

if (!function_exists('isActivePage')) {
    /** True when the page set $currentPage to $page (home, services, service-areas, about, blog, faq, contact, legal). */
    function isActivePage(string $page): bool {
        return isset($GLOBALS['currentPage']) && $GLOBALS['currentPage'] === $page;
    }
}

if (!function_exists('ariaCurrent')) {
    /** ' aria-current="page"' when $page is the active page, else ''. */
    function ariaCurrent(string $page): string {
        return isActivePage($page) ? ' aria-current="page"' : '';
    }
}

/* ---- Formatting + slugs ------------------------------------------------------------------------- */

if (!function_exists('formatPhone')) {
    /** Format any 10/11-digit US number as "(508) 989-7101"; $style 'dash' gives "508-989-7101"; 'tel' gives "tel:+15089897101". */
    function formatPhone(string $phone, string $style = 'paren'): string {
        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 11 && $digits[0] === '1') $digits = substr($digits, 1);
        if (strlen($digits) !== 10) return $phone;
        if ($style === 'tel')  return 'tel:+1' . $digits;
        if ($style === 'dash') return substr($digits, 0, 3) . '-' . substr($digits, 3, 3) . '-' . substr($digits, 6);
        return '(' . substr($digits, 0, 3) . ') ' . substr($digits, 3, 3) . '-' . substr($digits, 6);
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}

if (!function_exists('getServiceSlug')) {
    /** "Septic System Installation" -> "septic-system-installation" ("Site Construction / Excavation" -> "site-construction-excavation"). */
    function getServiceSlug(string $name): string {
        return slugify($name);
    }
}

if (!function_exists('getAreaSlug')) {
    /** "Plymouth, MA" -> "plymouth" (anything after a comma is the state and is dropped). */
    function getAreaSlug(string $city): string {
        return slugify(explode(',', $city)[0]);
    }
}

/* ---- Link integrity ----------------------------------------------------------------------------- */

if (!function_exists('areaHref')) {
    /** /areas/{slug}/ once that page exists on disk, otherwise the service-areas hub anchor. Never links to a 404. */
    function areaHref(string $slug): string {
        $dir = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/') . '/areas/' . $slug;
        return is_dir($dir) ? '/areas/' . $slug . '/' : '/service-areas/#' . $slug;
    }
}

/* ---- Icons: inline SVG from references/lucide-icons (no runtime injection) ---------------------- */

if (!function_exists('iconSvg')) {
    /** Returns the raw Lucide <svg> with aria-hidden + width/height, or '' when the icon file is missing. */
    function iconSvg(string $name, int $size = 20, string $class = ''): string {
        static $cache = [];
        $name = preg_replace('/[^a-z0-9-]/', '', strtolower($name));
        if ($name === '') return '';
        if (!isset($cache[$name])) {
            $file = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/') . '/references/lucide-icons/' . $name . '.svg';
            $raw = is_file($file) ? (string) file_get_contents($file) : '';
            $raw = preg_replace('/<!--.*?-->/s', '', $raw);
            $cache[$name] = trim((string) $raw);
        }
        if ($cache[$name] === '') return '';
        $svg = preg_replace('/\s+class="[^"]*"/', '', $cache[$name], 1);
        $svg = preg_replace('/\s+(width|height)="[^"]*"/', '', $svg, 2);
        $attrs = ' width="' . $size . '" height="' . $size . '" aria-hidden="true" focusable="false"' . ($class !== '' ? ' class="' . h($class) . '"' : '');
        return preg_replace('/<svg/', '<svg' . $attrs, $svg, 1);
    }
}

if (!function_exists('icon')) {
    /** Echoes an inline icon. Usage: <?php icon('phone'); ?> or icon('chevron-down', 16, 'chev'). */
    function icon(string $name, int $size = 20, string $class = ''): void {
        echo iconSvg($name, $size, $class);
    }
}

/* ---- Logo detection ----------------------------------------------------------------------------- */

if (!function_exists('siteLogo')) {
    /**
     * Finds the header logo in /assets/images (logo-mark*, then logo*) and sizes it by aspect ratio
     * (LARGE-LOGO STANDARD: wordmark >3:1 -> 120px, combination 1.5-3:1 -> 96px, square -> 88px tall).
     * Returns null when no logo file exists, so header.php/footer.php fall back to the text logo.
     */
    function siteLogo(): ?array {
        static $logo = false;
        if ($logo !== false) return $logo;
        $root = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
        $found = null;
        foreach (['logo-mark*', 'logo*'] as $pattern) {
            $files = glob($root . '/assets/images/' . $pattern . '.{png,webp,svg,jpg,jpeg}', GLOB_BRACE) ?: [];
            sort($files);
            if ($files) { $found = $files[count($files) - 1]; break; }   // highest version suffix wins
        }
        if ($found === null) return $logo = null;
        $info = @getimagesize($found);
        $w = $info[0] ?? 0; $h = $info[1] ?? 0;
        if ($w < 1 || $h < 1) { $w = 4; $h = 3; }
        $ratio = $w / $h;
        $height = $ratio > 3 ? 120 : ($ratio >= 1.5 ? 96 : 88);
        $class = $ratio > 3 ? 'logo--wordmark' : ($ratio < 1.5 ? 'logo--square' : '');
        return $logo = [
            'src' => '/assets/images/' . basename($found),
            'width' => (int) round($height * $ratio), 'height' => $height,
            'class' => $class,
            'navHeight' => $height + 24,
        ];
    }
}

/* ---- SEO: meta tags ----------------------------------------------------------------------------- */

if (!function_exists('requestCanonical')) {
    /** Self-referencing canonical built from the request path: strips index.php/query, trailing slash on directories. */
    function requestCanonical(string $siteUrl): string {
        $path = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/';
        $path = preg_replace('#/index(\.php)?$#', '/', $path);
        $path = preg_replace('#\.php$#', '', $path);
        if ($path === '' || $path[0] !== '/') $path = '/' . $path;
        if (substr($path, -1) !== '/' && !preg_match('#\.[a-z0-9]{2,5}$#i', $path)) $path .= '/';
        return rtrim($siteUrl, '/') . $path;
    }
}

if (!function_exists('generateMetaTags')) {
    /**
     * <title>, meta description, robots, canonical and Open Graph tags. Emits no keywords meta and no X/Twitter card tags (both forbidden).
     * $opts: image (absolute URL), type (default website), site_name, noindex (bool).
     */
    function generateMetaTags(string $title, string $description, string $canonical, array $opts = []): string {
        $type = $opts['type'] ?? 'website';
        $siteName = $opts['site_name'] ?? ($GLOBALS['siteName'] ?? '');
        $out  = '<title>' . h($title) . "</title>\n";
        $out .= '<meta name="description" content="' . h($description) . "\">\n";
        $out .= !empty($opts['noindex'])
            ? "<meta name=\"robots\" content=\"noindex,nofollow\">\n"
            : "<meta name=\"robots\" content=\"index,follow,max-image-preview:large\">\n";
        $out .= '<link rel="canonical" href="' . h($canonical) . "\">\n";
        $out .= '<meta property="og:type" content="' . h($type) . "\">\n";
        $out .= '<meta property="og:title" content="' . h($title) . "\">\n";
        $out .= '<meta property="og:description" content="' . h($description) . "\">\n";
        $out .= '<meta property="og:url" content="' . h($canonical) . "\">\n";
        if (!empty($opts['image'])) $out .= '<meta property="og:image" content="' . h($opts['image']) . "\">\n";
        $out .= '<meta property="og:site_name" content="' . h($siteName) . "\">\n";
        $out .= "<meta property=\"og:locale\" content=\"en_US\">\n";
        return $out;
    }
}

/* ---- SEO: schema -------------------------------------------------------------------------------- */

if (!function_exists('schemaJson')) {
    /** Encodes a schema array as a JSON-LD <script> block (</script>-safe). */
    function schemaJson($data): string {
        if (is_string($data)) return $data === '' ? '' : '<script type="application/ld+json">' . "\n" . $data . "\n</script>\n";
        return '<script type="application/ld+json">' . "\n"
            . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT)
            . "\n</script>\n";
    }
}

if (!function_exists('localBusinessSchema')) {
    /**
     * LocalBusiness node built entirely from config.php. Empty values are omitted (never invented).
     * Street address is omitted when $addressPublic is false. Review ratings are never emitted (self-serving ratings are forbidden).
     */
    function localBusinessSchema(): array {
        global $siteName, $siteUrl, $phoneE164, $email, $businessDescription, $address, $addressPublic, $geo, $gbp,
               $openingHours, $services, $areaPages, $socialLinks, $primaryCounty, $industryLabel;
        $base = rtrim($siteUrl, '/');
        $postal = ['@type' => 'PostalAddress'];
        if (!empty($addressPublic) && !empty($address['street'])) $postal['streetAddress'] = $address['street'];
        $postal += ['addressLocality' => $address['city'], 'addressRegion' => $address['state'], 'postalCode' => $address['zip'], 'addressCountry' => 'US'];

        $node = [
            '@type' => ['LocalBusiness', 'GeneralContractor'],
            '@id' => $base . '/#organization',
            'name' => $siteName,
            'url' => $base . '/',
            'telephone' => $phoneE164,
            'email' => $email,
            'description' => $businessDescription,
            'address' => $postal,
        ];
        if (!empty($geo['lat']) && !empty($geo['lng'])) {
            $node['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => (float) $geo['lat'], 'longitude' => (float) $geo['lng']];
        }
        if (!empty($gbp['share_url'])) $node['hasMap'] = $gbp['share_url'];
        $specs = [];
        foreach ((array) $openingHours as $oh) {
            $specs[] = ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $oh['days'], 'opens' => $oh['opens'], 'closes' => $oh['closes']];
        }
        if ($specs) $node['openingHoursSpecification'] = $specs;

        $logo = siteLogo();
        $ogFile = rtrim((string) $_SERVER['DOCUMENT_ROOT'], '/') . '/assets/images/og-default.jpg';
        if (is_file($ogFile))  $node['image'] = $base . '/assets/images/og-default.jpg';
        if ($logo)             $node['logo'] = $base . $logo['src'];

        $area = [];
        foreach ((array) $areaPages as $ap) $area[] = ['@type' => 'City', 'name' => $ap['name']];
        if (!empty($primaryCounty)) $area[] = ['@type' => 'AdministrativeArea', 'name' => $primaryCounty . ', ' . $address['state']];
        if ($area) $node['areaServed'] = $area;

        $offers = [];
        foreach ((array) $services as $schemaSvc) {
            $offers[] = ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $schemaSvc['name'], 'url' => $base . '/services/' . $schemaSvc['slug'] . '/']];
        }
        if ($offers) $node['hasOfferCatalog'] = ['@type' => 'OfferCatalog', 'name' => $industryLabel . ' services', 'itemListElement' => $offers];

        $same = array_values(array_filter(array_merge([$gbp['url'] ?? ''], array_values((array) $socialLinks))));
        if ($same) $node['sameAs'] = $same;
        return $node;
    }
}

if (!function_exists('generateBreadcrumbSchema')) {
    /** $crumbs: [['name' => 'Home', 'url' => '/'], ['name' => 'Services', 'url' => '/services/'], ...]. */
    function generateBreadcrumbSchema(array $crumbs): array {
        $base = rtrim($GLOBALS['siteUrl'], '/');
        $items = [];
        foreach (array_values($crumbs) as $i => $crumb) {
            $url = $crumb['url'] ?? '';
            if ($url !== '' && $url[0] === '/') $url = $base . $url;
            $items[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $crumb['name'], 'item' => $url];
        }
        return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
}

if (!function_exists('generateServiceSchema')) {
    /**
     * Service node for a $services entry (name, slug, description). Provider points at the homepage @id.
     * Page copy supplies richer descriptions via $service['description'].
     */
    function generateServiceSchema(array $service): array {
        global $siteUrl, $address;
        $base = rtrim($siteUrl, '/');
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['name'],
            'serviceType' => $service['name'],
            'description' => $service['description'] ?? '',
            'url' => $base . '/services/' . $service['slug'] . '/',
            'provider' => ['@id' => $base . '/#organization'],
            'areaServed' => ['@type' => 'City', 'name' => $address['city']],
        ];
    }
}

if (!function_exists('generateFAQSchema')) {
    /** $faqs: [['q' => '...', 'a' => '...'], ...]. FAQPage is an AI comprehension aid only, never a rich-result claim. */
    function generateFAQSchema(array $faqs): array {
        $entities = [];
        foreach ($faqs as $faq) {
            $question = $faq['q'] ?? $faq['question'] ?? '';
            $answer = $faq['a'] ?? $faq['answer'] ?? '';
            if ($question === '' || $answer === '') continue;
            $entities[] = ['@type' => 'Question', 'name' => strip_tags($question),
                           'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($answer)]];
        }
        return ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities];
    }
}

if (!function_exists('servicePageSchema')) {
    /**
     * Schema list for a /services/{slug}/ page (head.php echoes each item; BreadcrumbList comes from $breadcrumbs):
     * Service (@id {url}#service-{slug}, provider = the homepage #organization entity), WebPage with Speakable
     * (h1, .hero-answer, .answer-block). Pages with real FAQs add generateFAQSchema($faqs) themselves.
     */
    function servicePageSchema(array $service, string $summary): array {
        global $siteUrl, $address, $primaryCounty, $pageTitle;
        $base = rtrim($siteUrl, '/');
        $url  = $base . '/services/' . $service['slug'] . '/';
        $svcId = $url . '#service-' . $service['slug'];
        $out = [[
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            '@id' => $svcId,
            'name' => $service['name'],
            'serviceType' => $service['name'],
            'description' => $summary,
            'url' => $url,
            'provider' => ['@id' => $base . '/#organization'],
            'areaServed' => [
                ['@type' => 'City', 'name' => $address['city'] . ', ' . $address['state']],
                ['@type' => 'AdministrativeArea', 'name' => $primaryCounty . ', ' . $address['state']],
            ],
        ], [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $url . '#webpage',
            'url' => $url,
            'name' => (string) $pageTitle,
            'about' => ['@id' => $svcId],
            'isPartOf' => ['@type' => 'WebSite', 'url' => $base . '/'],
            'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
        ]];
        return $out;
    }
}

if (!function_exists('serviceCards')) {
    /** Card copy for the required services-grid component (services hub + "other services" rows). Keyed by slug. */
    function serviceCards(): array {
        return [
            'site-construction-excavation' => ['icon' => 'tractor',
                'desc' => 'Excavation, grading and site preparation for residential and commercial lots.',
                'bullets' => ['Site prep and final grading', 'Foundation and footing digs', 'Drainage and utility trenches']],
            'septic-system-installation' => ['icon' => 'droplets',
                'desc' => 'New and replacement septic systems installed to the approved design.',
                'bullets' => ['Built to the approved plan', 'Board of Health inspections', 'New and replacement systems']],
            'sea-walls' => ['icon' => 'waves',
                'desc' => 'Sea wall construction for waterfront and coastal property.',
                'bullets' => ['Built for waterfront lots', 'Planned around coastal permits', 'Holds back shoreline erosion']],
            'helical-piers' => ['icon' => 'building-2',
                'desc' => 'Steel piers screwed down past loose soil to carry a structure.',
                'bullets' => ['Support for new foundations', 'Additions, decks and porches', 'Far less digging than footings']],
            'title-5-inspections' => ['icon' => 'clipboard-list',
                'desc' => 'Massachusetts Title 5 septic inspections for sales and system checks.',
                'bullets' => ['Required before most sales', 'Completed state inspection form', 'Same team installs septic systems']],
        ];
    }
}

if (!function_exists('serviceBySlug')) {
    /** The $services entry for a slug (config.php), or null. */
    function serviceBySlug(string $slug): ?array {
        foreach ((array) ($GLOBALS['services'] ?? []) as $svcRow) {
            if ($svcRow['slug'] === $slug) return $svcRow;
        }
        return null;
    }
}

/* ---- Legal pages (privacy-policy, terms, cookie-policy, accessibility) ---------------------------- */

if (!function_exists('legalName')) {
    /** Company name plus the entity type from intake when one exists ("BDPM Site Services LLC"); just the name while it is blank. */
    function legalName(): string {
        $name = (string) ($GLOBALS['companyName'] ?? '');
        $type = trim((string) ($GLOBALS['companyEntityType'] ?? ''));
        return $type === '' ? $name : $name . ' ' . $type;
    }
}

if (!function_exists('legalPageSchema')) {
    /** WebPage node for a legal page (BreadcrumbList comes from $breadcrumbs in head.php). */
    function legalPageSchema(string $title, string $description, string $url): array {
        $base = rtrim($GLOBALS['siteUrl'], '/');
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $url . '#webpage',
            'url' => $url,
            'name' => $title,
            'description' => $description,
            'isPartOf' => ['@type' => 'WebSite', 'url' => $base . '/'],
            'publisher' => ['@id' => $base . '/#organization'],
        ];
    }
}

if (!function_exists('legalContactBlock')) {
    /** The standard "Contact Us" block that closes every legal page. Pulls everything from config.php. */
    function legalContactBlock(): string {
        $e = $GLOBALS['companyEmail'];
        $p = $GLOBALS['companyPhone'];
        $t = $GLOBALS['companyPhoneE164'];
        return '<p><strong>' . h(legalName()) . '</strong><br>'
            . 'Email: <a href="mailto:' . h($e) . '">' . h($e) . '</a><br>'
            . 'Phone: <a href="tel:' . h($t) . '">' . h($p) . '</a><br>'
            . 'Address: ' . h($GLOBALS['companyAddress']) . '<br>'
            . 'Hours: ' . h($GLOBALS['businessHours']) . '</p>';
    }
}

/* ---- Lead forms --------------------------------------------------------------------------------- */

if (!function_exists('renderEstimateForm')) {
    /**
     * The FULL estimate form (references/contact-form-standard.md): name, email, phone, service, job address, message,
     * three unbundled consent checkboxes, plus every hidden field from p1_lead_hidden_fields(). Used by the estimate
     * dialog in footer.php (formId 'dialog'), the homepage estimate section and the contact page.
     * $formId must be unique on the page (it becomes form_location + form_id); $idPrefix prefixes every element id.
     */
    function renderEstimateForm(string $formId, string $idPrefix, string $submitLabel = 'Request my estimate'): string {
        global $formAction, $siteName, $contactEmail, $address;
        require_once rtrim((string) $_SERVER['DOCUMENT_ROOT'], '/') . '/includes/p1-form-helpers.php';
        $p = h($idPrefix);
        ob_start();
        ?>
<form action="<?php echo h($formAction); ?>" method="POST" class="estimate-form" id="<?php echo $p; ?>-form">
<?php echo p1_lead_hidden_fields($formId); ?>
<input type="hidden" name="address_state" value="<?php echo h($address['state']); ?>">
  <div class="form-grid">
    <div class="field"><label for="<?php echo $p; ?>-name">Your name *</label><input id="<?php echo $p; ?>-name" type="text" name="name" autocomplete="name" required></div>
    <div class="field"><label for="<?php echo $p; ?>-phone">Phone *</label><input id="<?php echo $p; ?>-phone" type="tel" name="phone" autocomplete="tel" required></div>
    <div class="field full"><label for="<?php echo $p; ?>-email">Email *</label><input id="<?php echo $p; ?>-email" type="email" name="email" autocomplete="email" required></div>
    <div class="field full"><label for="<?php echo $p; ?>-service">Service needed</label><select id="<?php echo $p; ?>-service" name="service"><?php echo p1_service_options(); ?></select></div>
    <div class="field"><label for="<?php echo $p; ?>-street">Job street address</label><input id="<?php echo $p; ?>-street" type="text" name="address_street" autocomplete="street-address"></div>
    <div class="field"><label for="<?php echo $p; ?>-city">Town</label><input id="<?php echo $p; ?>-city" type="text" name="address_city" autocomplete="address-level2"></div>
    <div class="field full"><label for="<?php echo $p; ?>-message">About the job</label><textarea id="<?php echo $p; ?>-message" name="message" rows="4"></textarea></div>
  </div>
  <fieldset class="form-consent-fieldset">
    <legend class="form-consent-legend">Communication Consent</legend>
    <label class="form-consent-item" for="<?php echo $p; ?>-email-opt">
      <input id="<?php echo $p; ?>-email-opt" type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
      <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo h($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email or by emailing <?php echo h($contactEmail); ?>. Message frequency varies.</span>
    </label>
    <label class="form-consent-item" for="<?php echo $p; ?>-sms-opt">
      <input id="<?php echo $p; ?>-sms-opt" type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
      <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo h($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
    </label>
    <label class="form-consent-item form-consent-required" for="<?php echo $p; ?>-terms">
      <input id="<?php echo $p; ?>-terms" type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
      <span class="consent-label">I have read and agree to the <a href="/privacy-policy/">Privacy Policy</a> and <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span></span>
    </label>
  </fieldset>
  <button type="submit" class="btn btn-primary btn-lg btn-block"><?php echo h($submitLabel); ?></button>
</form>
<?php
        return (string) ob_get_clean();
    }
}
