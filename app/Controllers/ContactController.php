<?php

namespace App\Controllers;

use PHPFramework\Application;

class ContactController extends Controller
{
    public function index()
    {

//        return 'Contact form GET page';
        $view = Application::$app->view->render('Contact/contact');
        return $view;

    }
    public function send()
    {
        return 'Contact form POST page';
    }
}