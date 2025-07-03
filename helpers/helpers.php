<?php


use PHPFramework\View;

function app(): \PHPFramework\Application
{
    return \PHPFramework\Application::$app;
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

function router(): \PHPFramework\Router
{
    return app()->router;
}