<?php


use PHPFramework\Application;
use PHPFramework\Router;
use PHPFramework\Session;
use PHPFramework\View;

function app(): Application
{
    return Application::$app;
}

function view($view = '', $data = [], $layout = ''): string|View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}

function responseCode($code = 200)
{
    app()->response->setResponseCode($code);
}

function router(): Router
{
    return app()->router;
}

function request(): \PHPFramework\Request
{
    return app()->request;
}

function response(): \PHPFramework\Response
{
    return app()->response;
}


function base_url($path = ''): string
{
    return PATH . $path;
}

function h($str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function old($fieldname): string
{
    $post_fieldname = $_POST[$fieldname];
    return isset($post_fieldname) ? h($post_fieldname) : '';
}

function get_errors($fieldname, $errors = []): string
{
    $output = '';
    if (isset($errors[$fieldname])) {
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled">';
        foreach ($errors[$fieldname] as $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= '</ul></div>';
    }
    var_dump($output);
    return $output;
}

function get_validation_class($fieldname, $errors = []): string
{
    if (empty($errors)) {
        return '';
    }
    return isset($errors[$fieldname]) ? 'is-invalid' : 'is-valid';
}

function abort($error = '', $code = 404)
{
    responseCode($code);
    $notFound = 404;
    if (DEBUG || $code == $notFound) {
        dump(view("Errors/{$code}", ['error' => $error], false));
        dump("error: ", $error);
        echo view("Errors/{$code}", ['error' => $error], false);
    }
    die;
}

function db(): \PHPFramework\Database
{
    return app()->db;
}

function session(): Session
{
    return app()->session;
}

function get_alerts(): void
{
    $flash = $_SESSION['flash'];
    if(!empty($flash)){
        foreach ($flash as $k=>$v){
                    \view()->renderPartial("Includes/alert_{$k}", ["flash_{$k}" => \session()->getFlash($k)]);
        }
    }


    //    два варианта -выше вариант на расширение
    //    if ($flash_success = \session()->getFlash('success')) {
    //        \view()->renderPartial('Includes/alert_success', compact('flash_success'));
    //    }
    //    if ($flash_error = \session()->getFlash('error')) {
    //        \view()->renderPartial('Includes/alert_error', compact('flash_error'));
    //    }
}