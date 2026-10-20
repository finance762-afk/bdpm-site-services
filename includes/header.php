<?php
/**
 * includes/header.php — skip link, fixed glass header + desktop nav, mobile full-screen menu, opens <main>.
 * Include after head.php. Loop variables are prefixed ($navSvc, $navArea) so they never collide with page variables.
 * Reads (never writes) $currentPage / $serviceSlug from the page.
 */
$navLogo   = siteLogo();
$navPhone  = formatPhone($phone, 'tel');
$navMark   = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $siteName), 0, 2));
$navSvcSlug = $serviceSlug ?? '';
$navOnServices = isActivePage('services');
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header" data-header>
  <nav class="navbar" aria-label="Main navigation">
    <div class="navbar-inner container">
      <a class="site-logo" href="/" aria-label="<?php echo h($siteName); ?> — home">
<?php if ($navLogo): ?>
        <img src="<?php echo h($navLogo['src']); ?>" alt="<?php echo h($siteName); ?>" width="<?php echo (int) $navLogo['width']; ?>" height="<?php echo (int) $navLogo['height']; ?>"<?php echo $navLogo['class'] ? ' class="' . h($navLogo['class']) . '"' : ''; ?> loading="eager" decoding="async">
<?php else: ?>
        <span class="logo-mark" aria-hidden="true"><?php echo h($navMark); ?></span>
        <span class="logo-text">
          <span class="brand-name"><?php echo h($siteName); ?></span>
          <span class="brand-sub"><?php echo h($industryLabel . ' · ' . $address['city'] . ', ' . $address['state']); ?></span>
        </span>
<?php endif; ?>
      </a>

      <ul class="navbar-links">
        <li><a href="/"<?php echo ariaCurrent('home'); ?>>Home</a></li>
        <li class="has-dropdown">
          <a href="/services/" aria-haspopup="true"<?php echo $navOnServices ? ($navSvcSlug === '' ? ' aria-current="page"' : ' aria-current="true"') : ''; ?>>Services <?php icon('chevron-down', 16, 'chev'); ?></a>
          <ul class="dropdown" role="menu" style="display:none">
<?php foreach ($services as $navSvc): ?>
            <li role="none"><a role="menuitem" href="/services/<?php echo h($navSvc['slug']); ?>/"<?php echo ($navOnServices && $navSvcSlug === $navSvc['slug']) ? ' aria-current="page"' : ''; ?>><?php echo h($navSvc['name']); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
        <li class="has-dropdown">
          <a href="/service-areas/" aria-haspopup="true"<?php echo ariaCurrent('service-areas'); ?>>Service Areas <?php icon('chevron-down', 16, 'chev'); ?></a>
          <ul class="dropdown" role="menu" style="display:none">
<?php foreach ($areaPages as $navArea): ?>
            <li role="none"><a role="menuitem" href="<?php echo h(areaHref($navArea['slug'])); ?>"><?php echo h($navArea['name'] . ', ' . $navArea['state']); ?></a></li>
<?php endforeach; ?>
            <li role="none"><a role="menuitem" href="/service-areas/">View all service areas</a></li>
          </ul>
        </li>
        <li><a href="/about/"<?php echo ariaCurrent('about'); ?>>About</a></li>
        <li><a href="/blog/"<?php echo ariaCurrent('blog'); ?>>Blog</a></li>
        <li><a href="/contact/"<?php echo ariaCurrent('contact'); ?>>Contact</a></li>
      </ul>

      <div class="navbar-cta">
        <a class="btn btn-secondary navbar-phone" href="<?php echo h($navPhone); ?>" aria-label="Call <?php echo h($siteName . ' at ' . $phone); ?>"><?php icon('phone', 18); ?><span><?php echo h($phone); ?></span></a>
        <a class="btn btn-primary" href="/contact/" data-open-estimate>Free Estimate</a>
      </div>

      <button class="hamburger" type="button" aria-label="Menu" aria-controls="mobile-menu" aria-expanded="false">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>
    </div>
  </nav>
</header>

<?php /* Mobile menu lives OUTSIDE <header>: the header's backdrop-filter would otherwise become the containing block and shrink this fixed overlay to bar height. */ ?>
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <div class="mobile-menu-inner">
    <nav aria-label="Mobile navigation">
      <ul class="mobile-menu-links">
        <li><a href="/"<?php echo ariaCurrent('home'); ?>>Home</a></li>
        <li>
          <a href="/services/"<?php echo $navOnServices ? ($navSvcSlug === '' ? ' aria-current="page"' : ' aria-current="true"') : ''; ?>>Services</a>
          <ul class="sub">
<?php foreach ($services as $navSvc): ?>
            <li><a href="/services/<?php echo h($navSvc['slug']); ?>/"><?php echo h($navSvc['name']); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
        <li>
          <a href="/service-areas/"<?php echo ariaCurrent('service-areas'); ?>>Service Areas</a>
          <ul class="sub">
<?php foreach ($areaPages as $navArea): ?>
            <li><a href="<?php echo h(areaHref($navArea['slug'])); ?>"><?php echo h($navArea['name']); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
        <li><a href="/about/"<?php echo ariaCurrent('about'); ?>>About</a></li>
        <li><a href="/blog/"<?php echo ariaCurrent('blog'); ?>>Blog</a></li>
        <li><a href="/contact/"<?php echo ariaCurrent('contact'); ?>>Contact</a></li>
      </ul>
    </nav>
    <div class="mobile-menu-cta">
      <a class="btn btn-accent btn-lg" href="<?php echo h($navPhone); ?>"><?php icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
      <a class="btn btn-outline-white btn-lg" href="/contact/">Free Estimate</a>
    </div>
  </div>
</div>

<main id="main-content">
