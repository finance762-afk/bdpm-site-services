<?php
/**
 * includes/photos.php — registry of BDPM Site Services' real photos (the 28 photos from the client's previous site,
 * ~/media/bdpm-oldsite/manifest.tsv, converted 2026-10-20). Each entry: alt (manifest text where the manifest had one, lightly
 * edited for accuracy; written from the photo where it was blank), cat (excavation|septic|title5|seawall|piers|crew), w/h (original
 * pixels, used for width/height + aspect ratio), sizes (the -{N}.webp / -{N}.avif widths that exist on disk under /assets/images/),
 * src (the original filename, for traceability). Render through photoPicture() in functions.php. Never add an entry whose files
 * are not on disk. Skipped on purpose: BSS-12/13 (dot patterns), BSS-14 (Google review badge), BSS-9 (1920x100 strip),
 * BSS-000 (57px icon), BSS-00 (200px logo). BSS-0 is the logo (logo-bdpm-site-services-v1.png).
 */
$sitePhotos = [
    // ---- Excavation / site construction ----
    'excavator-foundation-dig-worker-plymouth'   => ['alt' => 'Worker in a hard hat and safety vest guiding an excavator bucket inside a deep foundation excavation', 'cat' => 'excavation', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-16.jpg'],
    'excavator-bucket-digging-trench'            => ['alt' => 'Excavator bucket scooping dirt at a construction site on a sunny day', 'cat' => 'excavation', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-8.jpg'],
    'excavator-backhoe-loader-dirt-site'         => ['alt' => 'Yellow excavator, backhoe and wheel loader lined up on a dirt construction site near stockpiles', 'cat' => 'excavation', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-33.jpg'],
    'foundation-formwork-rebar-site-construction' => ['alt' => 'Wooden formwork with rebar in place, ready for a concrete pour, on a construction site', 'cat' => 'excavation', 'w' => 1920, 'h' => 2880, 'sizes' => [480, 800, 960], 'src' => 'BSS-34.jpg'],
    'excavation-contractor-blueprints-excavator' => ['alt' => 'Construction worker holding rolled blueprints beside a yellow excavator at a job site', 'cat' => 'excavation', 'w' => 1920, 'h' => 1303, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-32.jpg'],
    'site-crew-inspecting-crane-lift'            => ['alt' => 'Three construction workers in hard hats looking up at a crane on a sunny day, one pointing', 'cat' => 'excavation', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-30.jpg'],
    'construction-crew-scaffolding-site-review'  => ['alt' => 'Construction workers in safety vests and hard hats surveying scaffolding under a cloudy sky', 'cat' => 'excavation', 'w' => 1920, 'h' => 1281, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-2.jpg'],
    'aerial-bulldozer-grading-rock-shoreline'    => ['alt' => 'Aerial view of a bulldozer grading gravel behind a rock-armored shoreline at the water\'s edge', 'cat' => 'seawall', 'w' => 1920, 'h' => 1079, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-4.jpg'],

    // ---- Septic system installation ----
    'septic-tanks-installed-pit-orange-pipe'     => ['alt' => 'Two black plastic septic tanks with teal lids set in an excavated pit and joined by orange pipe before backfill', 'cat' => 'septic', 'w' => 1920, 'h' => 1211, 'sizes' => [480, 800, 960, 1600], 'src' => 'Septic-System-1183683898-2880w.jpg'],
    'plastic-septic-tanks-set-in-excavation'     => ['alt' => 'Black plastic septic tanks set in a dirt excavation, connected by orange pipe and ready for backfill', 'cat' => 'septic', 'w' => 1920, 'h' => 1211, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-19.jpg'],
    'concrete-septic-tank-riser-backyard'        => ['alt' => 'Concrete septic tank partially buried in a yard, with its riser and access lid open', 'cat' => 'septic', 'w' => 1920, 'h' => 1282, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-26.jpg'],
    'concrete-septic-tank-open-lid-yard'         => ['alt' => 'Concrete septic tank partially buried in a grassy yard, with its circular access lid open', 'cat' => 'septic', 'w' => 1920, 'h' => 1282, 'sizes' => [480, 800, 960, 1600], 'src' => 'Septic-System-2307496103.jpg'],
    'precast-concrete-septic-riser-rings'        => ['alt' => 'Precast concrete riser rings and a lid staged on red clay soil beside a septic excavation', 'cat' => 'septic', 'w' => 1920, 'h' => 1331, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-21.jpg'],
    'septic-access-covers-concrete-risers'       => ['alt' => 'Two green septic access covers set into concrete risers at grade on bare ground', 'cat' => 'septic', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'Septic-System-2393506637.jpg'],
    'plastic-septic-tanks-trench-connected'      => ['alt' => 'Red and green plastic septic tanks installed side by side in a dirt trench and connected by pipe', 'cat' => 'septic', 'w' => 1920, 'h' => 1439, 'sizes' => [480, 800, 960, 1600], 'src' => 'Septic-System-35227840.jpg'],
    'installing-septic-tee-fitting-concrete-tank' => ['alt' => 'Worker in an orange high-visibility jacket fitting a grey plastic tee pipe into the wall of a concrete septic tank', 'cat' => 'septic', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'Title-5-Septic-Inspections-2668809397.jpg'],

    // ---- Title 5 inspections ----
    'title-5-inspector-clipboard-open-septic-tank' => ['alt' => 'Inspector in coveralls and a hard hat going over a clipboard with a homeowner beside an open septic tank in a backyard', 'cat' => 'title5', 'w' => 1920, 'h' => 1233, 'sizes' => [480, 800, 960, 1600], 'src' => 'Title-5-Septic-Inspections-040826.jpg'],
    'lifting-septic-tank-cover-inspection'       => ['alt' => 'Gloved hand lifting the green plastic cover of a septic tank riser to check the liquid inside', 'cat' => 'title5', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'Title-5-Septic-Inspections-2047328795.jpg'],
    'septic-covers-control-box-landscaped-yard'  => ['alt' => 'Two gray septic tank access covers and a small control box in a landscaped backyard', 'cat' => 'title5', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'Title-5-Septic-Inspections-1105714421.jpg'],
    'green-lid-septic-tank-sandy-lot'            => ['alt' => 'Green-lidded round septic treatment tank set in sandy ground on an open lot', 'cat' => 'title5', 'w' => 1920, 'h' => 1440, 'sizes' => [480, 800, 960, 1600], 'src' => 'Title-5-Septic-Inspections-647496040.jpg'],

    // ---- Sea walls ----
    'concrete-seawall-construction-beach'        => ['alt' => 'Concrete sea wall under construction along a sandy beach, rebar exposed, under a cloudy sky', 'cat' => 'seawall', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-20.jpg'],
    'seawall-repair-timber-supports-waterfront'  => ['alt' => 'Sea wall under repair with timber supports, with a heron and an egret standing along the water', 'cat' => 'seawall', 'w' => 1920, 'h' => 1275, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-28.jpg'],
    'stone-retaining-wall-shoreline-construction' => ['alt' => 'Newly built stone retaining wall on a muddy shoreline, with houses in the background', 'cat' => 'seawall', 'w' => 1920, 'h' => 1440, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-31.jpg'],

    // ---- Helical piers ----
    'helical-pier-auger-drilling-soil'           => ['alt' => 'Auger drilling into dark brown soil, boring the hole for a pier', 'cat' => 'piers', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-17.jpg'],

    // ---- Crew / planning / estimates ----
    'bdpm-crew-member-hard-hat-safety-vest'      => ['alt' => 'Smiling construction worker in an orange hard hat, yellow safety vest and work gloves', 'cat' => 'crew', 'w' => 517, 'h' => 860, 'sizes' => [480], 'src' => 'BSS-10-861h.png'],
    'contractor-client-handshake-estimate'       => ['alt' => 'Contractor and customer shaking hands over a work table with a yellow hard hat and tools', 'cat' => 'crew', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-29.jpg'],
    'reviewing-site-plans-laptop-hard-hat'       => ['alt' => 'Two people discussing architectural plans at a desk with a laptop and a hard hat', 'cat' => 'crew', 'w' => 1920, 'h' => 1280, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-3.jpg'],
    'site-team-planning-blueprints-table'        => ['alt' => 'Construction team in safety vests reviewing blueprints at a table with hard hats, a calculator and a tape measure', 'cat' => 'crew', 'w' => 1920, 'h' => 877, 'sizes' => [480, 800, 960, 1600], 'src' => 'BSS-5.jpg'],
];
