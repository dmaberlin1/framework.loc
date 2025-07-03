<?php

use App\Controllers\ContactController;
use PHPFramework\Application;

/**
 * @var Application $app
 */

$app->router->get('/',function (){
    return 'Main page';
});
$app->router->get('/about',function (){
    return 'About page';
});
$app->router->get('/contact',[ContactController::class,'index']);
$app->router->post('/contact',[ContactController::class,'send']);