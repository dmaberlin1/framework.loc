<?php

/**
 * @var \PHPFramework\Application $app
*/
$app->router->get('/',function (){
    return 'Main page';
});
$app->router->get('/about',function (){
    return 'About page';
});
$app->router->get('/contact',function (){
    return 'Contact form GET page';
});
$app->router->post('/contact',function (){
    return 'Contact form POST page';
});