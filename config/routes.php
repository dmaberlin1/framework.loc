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

router()->post('/posts/store',[PostController::class,'store']);

router()->get('/posts/edit',[PostController::class,'edit']);

router()->post('/posts/update',[PostController::class,'update']);

router()->get('/posts/delete',[PostController::class,'delete']);

router()->get('/posts/(?P<slug>[a-z0-9-]+)',[PostController::class,'show']);

