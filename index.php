<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'app/Setup.php';

//setup application routes
$app = new  App([ 'entries', 'home', 'ajax-submit' ], 'home');

$route = isset($_GET['route']) ? trim($_GET['route']) : false;

//process user requested route
$app->request($route);
