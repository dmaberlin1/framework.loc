<?php




use App\Controllers\ContactController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use PHPFramework\Application;

/**
 * @var Application $app
 */

$app->router->get('/',[HomeController::class,'index']);
//about
$app->router->get('/about',function (){
    return view('about');
});
//contact
router()->get('/contact',[ContactController::class,'index']);
router()->post('/contact',[ContactController::class,'send']);

//post
router()->get('/posts/create',[PostController::class,'create']);
router()->post('/posts/store',[PostController::class,'send']);

