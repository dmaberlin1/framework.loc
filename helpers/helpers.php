<?php


use PHPFramework\Application;
use PHPFramework\Router;
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

function response($code=200)
{
    app()->response->setResponseCode($code);
}

function router(): Router
{
    return app()->router;
}