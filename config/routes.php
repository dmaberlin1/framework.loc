<?php




use App\Controllers\ContactController;
use PHPFramework\Application;

/**
 * @var Application $app
 */

$app->router->get('/',function (){
    return view('main',['title'=>'Main page'],);
//    return 'main page';
//    return view()->render('main');

});
$app->router->get('/about',function (){
    return view('about');
});
router()->get('/contact',[ContactController::class,'index']);
router()->post('/contact',[ContactController::class,'send']);
//$app->router->post('/contact',[ContactController::class,'send']);