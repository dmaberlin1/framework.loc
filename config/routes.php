<?php




use App\Controllers\ContactController;
use App\Controllers\HomeController;
use PHPFramework\Application;

/**
 * @var Application $app
 */

$app->router->get('/',[HomeController::class,'index']);
$app->router->get('/about',function (){
    return view('about');
});
router()->get('/contact',[ContactController::class,'index']);
router()->post('/contact',[ContactController::class,'send']);
//$app->router->post('/contact',[ContactController::class,'send']);