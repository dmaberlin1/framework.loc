<?php


use App\Controllers\ContactController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use PHPFramework\Application;
use PHPFramework\Middleware\Auth;
use PHPFramework\Middleware\Guest;

/**
 * @var Application $app
 */

$app->router->get('/', [HomeController::class, 'index']);
//about
$app->router->get('/about', function () {
    return view('about');
});

const MIDDLEWARE = [
    //псевдонимы
    'auth' => Auth::class,
    'guest' => Guest::class
];
//contact
router()->get('/contact', [ContactController::class, 'index']);

router()->post('/contact', [ContactController::class, 'send']);

//post
router()->get('/posts/create', [PostController::class, 'create'])->only('auth');

router()->post('/posts/store', [PostController::class, 'store'])->only('auth');

router()->get('/posts/edit', [PostController::class, 'edit'])->only('auth');

router()->post('/posts/update', [PostController::class, 'update'])->only('auth');

router()->get('/posts/delete', [PostController::class, 'delete'])->only('auth');

router()->get('/posts/(?P<slug>[a-z0-9-]+)', [PostController::class, 'show']);

//user

//router()->get('/register',[UserController::class,'register']);
//router()->post('/register',[UserController::class,'register']);
router()->add('/register', [UserController::class, 'register'], ['get', 'post'])->only('guest');
//router()->add('/register',[UserController::class,'register'],'post');
router()->add('/login', [UserController::class, 'login'], ['get', 'post'])->only('guest');
router()->add('/logout', [UserController::class, 'logout'], ['get'])->only('auth');
