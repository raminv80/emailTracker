<?php
require_once __DIR__.'/../vendor/autoload.php';
$dotEnv = new Dotenv\Dotenv(__DIR__.'/../');
$dotEnv->load();
define('SITE_HOME', getenv('SITE_home'));

define('SMTP_PORT', getenv('SMTP_port'));
define('SMTP_HOST', getenv('SMTP_host'));
define('SMTP_USERNAME', getenv('SMTP_username'));
define('SMTP_PASSWORD', getenv('SMTP_password'));
define('SMTP_SECURE', getenv('SMTP_secure'));

define('DB_NAME', getenv('DB_name'));
define('DB_USER', getenv('DB_user'));
define('DB_PASS', getenv('DB_pass'));

define('GA', getenv('GoogleAnalytics'));

include_once __DIR__.'/App.php';
include_once __DIR__.'/PixelTrracker.php';
include_once __DIR__.'/inc/database.php';
