<?php

namespace PHPFramework;

class View
{

    public string $layout;
    public string $content = '';

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $data = [], $layout = ''):string
    {
        extract($data, EXTR_SKIP);
        $view_file = VIEWS . "/{$view}.php";
        if (is_file($view_file)) {
            //            буферизация выводы
            ob_start();
            require $view_file;
            $this->content = ob_get_clean();
        } else {
            //            app()->response->setResponseCode(400);
            responseCode(500);
            return view('Errors/500',['error'=>"Not found view {$view_file}"],false);
        }
        //        if (!$layout)
        //            Сработает при любом "пустом" значении:  false, '', null, 0, '0', []
        if ($layout === false) {
            return $this->content;
        }

        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/Layouts/{$layout_file_name}.php";

        if (is_file($layout_file)) {
            //            буферизация выводы
            ob_start();
            require_once $layout_file;
            return ob_get_clean();
        } else {
            //            app()->response->setResponseCode(400);
            responseCode(500);
            return view('Errors/500',['error'=>"Not found layout {$layout_file}"],false);
        }


    }
}