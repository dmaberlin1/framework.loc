<?php

if(PHP_MAJOR_VERSION<8){
    die("Require PHP version >=8");
}

require_once __DIR__.'/../config/init.php';
require_once CORE.'/Test.php';

new \core\Test();


echo '<pre>';
print_r(CONFIG);
print_r("\n");
print_r(APP);
echo '</pre>';


//echo '<pre>';
//print_r($_SERVER['REQUEST_URI']);
//echo '</pre>';
//
//echo '<pre>';
//print_r($_SERVER['QUERY_STRING']);
//echo '</pre>';
//
//echo '<pre>';
//print_r($_GET);
//echo '</pre>';

