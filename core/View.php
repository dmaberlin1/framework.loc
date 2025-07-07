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

    public function render($view, $data = [], $layout = '')
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
            response(500);
            return view('Errors/500');
        }
//        if (!$layout)
//            Сработает при любом "пустом" значении:
//
//false, '', null, 0, '0', []
        if ($layout === false) {
            return  $this->content;
        }

        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php";
        dd($layout_file);
    }
}