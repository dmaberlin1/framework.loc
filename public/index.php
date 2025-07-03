<?php


if (PHP_MAJOR_VERSION < 8) {
    die("Require PHP version >=8");
}

require_once __DIR__ . '/../config/init.php';
require_once ROOT . '/vendor/autoload.php';

$app = new \PHPFramework\Application();
require_once CONFIG . '/routes.php';
require_once HELPERS.'/helpers.php';
//dd(\PHPFramework\Application::$app);
//dd(app());
$app->run();



//dump($app->router->getRoutes());
//dump($app->request->get('page'));
//dump($app->request->get('s'));
//dump($app->request->get('s1','abs'));
//$app->router->getRoutes();
//dump($app->router->getRoutes());
//
//echo call_user_func($app->router->getRoutes()['GET']['/']);
//echo ' ';
//echo call_user_func($app->router->getRoutes()['GET']['/about']);
//echo ' ';
//echo call_user_func($app->router->getRoutes()['POST']['/contact']);
//dump($_SERVER);


//new Test();
//print_r("\n");
//new \App\Controllers\Test();
//

//echo '<pre>';
//print_r(CONFIG);
//print_r("\n");
//print_r(APP);
//echo '</pre>';


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

