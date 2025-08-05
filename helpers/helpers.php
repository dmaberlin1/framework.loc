<?php


use PHPFramework\Application;
use PHPFramework\Router;
use PHPFramework\Session;
use PHPFramework\View;
use Random\RandomException;

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
    if (!empty($flash)) {
        foreach ($flash as $k => $v) {
            \view()->renderPartial("Includes/alert_{$k}", ["flash_{$k}" => \session()->getFlash($k)]);
        }
    }
}

function get_file_ext($file_name): string
{
    // name.123.demo.ext
    $file_ext = explode('.', $file_name);
    return end($file_ext);

}

/**
 * @throws RandomException
 */
function upload_file($file, $i = false): string|false
{
    $file_ext = ($i === false) ? get_file_ext($file['name']) : get_file_ext($file['name'][$i]);
    $dir = '/' . date('Y') . '/' . date('m') . '/' . date('d'); //2025/08/03
    if (!is_dir(UPLOADS . $dir)) {
        if (!mkdir($concurrentDirectory = $concurrentDirectory = UPLOADS . $dir, 0755, true) && !is_dir($concurrentDirectory)) {
            //            dd(sprintf('Directory "%s" was not created', $concurrentDirectory));
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));

        }
        $letterRand = chr(random_int(97, 122)); // a-z
        $file_name = md5(
            ($i === false) ? $file['name'] : $file['name'][$i]
                . time() . $letterRand);
        $file_path = UPLOADS . "{$dir}/{$file_name}.{$file_ext}";
        $file_url = base_url("/uploads{$dir}/{$file_name}.{$file_ext}");
        if (move_uploaded_file(($i === false) ? $file['tmp_name'] : $file['tmp_name'][$i], $file_path)) {
            return $file_url;
        } else {
            error_log(
                "[" . date('Y-m-d H:i:s') . "] Error uploading file" . PHP_EOL,
                3,
                ERROR_LOG_FILE);
            return false;
        }
    }
}