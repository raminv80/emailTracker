<?php
ignore_user_abort(true);

// turn off gzip compression
if ( function_exists( 'apache_setenv' ) ) {
    apache_setenv( 'no-gzip', 1 );
}

ini_set('zlib.output_compression', 0);

// turn on output buffering if necessary
if (ob_get_level() == 0) {
    ob_start();
}

// removing any content encoding like gzip etc.
header('Content-encoding: none', true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // the pixel should not be POSTed to, so do nothing...
    echo ' ';
} else {
    // tell client to interpret the output as jpeg
    header("Content-Type: image/jpeg", true);

    // client should not cache this pixel
    header("Content-Length: 309");
    header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
    header("Expires: Wed, 11 Jan 2000 12:59:00 GMT");
    header("Last-Modified: Wed, 11 Jan 2006 12:59:00 GMT");
    header("Pragma: no-cache");

    // finally send the pixel content
    $file = '../assets/images/pixel.jpg';
    readfile( $file );
}

// flush all output buffers. No reason to make the user wait for OWA.
ob_flush();
flush();
ob_end_flush();

include_once 'Setup.php';
// DO ANALYTICS TRACKING
$token = $_GET['token'];
$pixelTracker = new \APP\PixelTrracker();
$pixelTracker->recordView($token);

// Send GA event
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://www.google-analytics.com/collect?v=1&tid='.GA.'&cid='.rand(1, 100000).'&t=event&ec=email&ea=view&el='.$token,
    CURLOPT_USERAGENT => 'Vanity-URL-Tracker',
));
$resp = curl_exec($curl);
curl_close($curl);
