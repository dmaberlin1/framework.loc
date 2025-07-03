<?php

namespace App\Controllers;

use PHPFramework\Application;
use PHPFramework\Controller;
use PHPFramework\View;

class ContactController extends Controller
{
    public function index(): View|string
    {

        //        return 'Contact form GET page';
        //        $view = Application::$app->view->render('Contact/contact');
        //        $view = app()->view->render('Contact/contact');
//        $view = $this->render('Contact/contact');
        //        return $view;
        //        return view()->render('Contact/contact');
        $title = 'Contact page';
        $name = 'Connor';
        return view('Contact/contact',['title'=>$title,'name'=>'Connor']);
//        return view('Contact/contact',compact('title','name'));

    }

    public function send()
    {
        return 'Contact form POST page';
    }
}