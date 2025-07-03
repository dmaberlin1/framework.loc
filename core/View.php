<?php

namespace PHPFramework;

class View
{

    public string $layout;
    public string $content='';

    public function __construct($layout)
    {
        $this->layout=$layout;
    }

    public function render($view,$data=[],$layout='')
    {
        $view_file=VIEWS."/{$view}.php";
        if (is_file($view_file)){
            require $view_file;
        }else{
            return "Not found view {$view_file}";
        }
    }
}