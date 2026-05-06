<?php
header("Content-Type: application/xml; charset=utf-8");

include "../config/db_conn.php";
include "../php/func-device.php";
include "../php/func-category.php";
include "../php/func-brand.php";

$devices = get_all_devices($conn);
$categories = get_all_categories($conn);
$brands = get_all_brand($conn);

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$base_url = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Static Pages
$pages = ['index.php', 'about.php', 'contact.php'];
foreach ($pages as $page) {
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($base_url . '/' . $page) . "</loc>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>0.8</priority>\n";
    echo "  </url>\n";
}

// Device Pages
if ($devices !== 0) {
    foreach ($devices as $device) {
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($base_url . '/device.php?id=' . $device['id']) . "</loc>\n";
        echo "    <changefreq>monthly</changefreq>\n";
        echo "    <priority>0.9</priority>\n";
        echo "  </url>\n";
    }
}

// Category Pages
if ($categories !== 0) {
    foreach ($categories as $category) {
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($base_url . '/category.php?id=' . $category['id']) . "</loc>\n";
        echo "    <changefreq>weekly</changefreq>\n";
        echo "    <priority>0.7</priority>\n";
        echo "  </url>\n";
    }
}

// Brand Pages
if ($brands !== 0) {
    foreach ($brands as $brand) {
        echo "  <url>\n";
        echo "    <loc>" . htmlspecialchars($base_url . '/brand.php?id=' . $brand['id']) . "</loc>\n";
        echo "    <changefreq>weekly</changefreq>\n";
        echo "    <priority>0.7</priority>\n";
        echo "  </url>\n";
    }
}

echo '</urlset>';
?>