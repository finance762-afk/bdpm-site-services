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
