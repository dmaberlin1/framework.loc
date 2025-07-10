<?php

namespace App\Controllers;

use App\Models\Contact;
use PHPFramework\Controller;
use PHPFramework\View;

class ContactController extends Controller
{


    public function index()
    {

        $title = 'Contact page';
        $name = 'Connor';
        return view('Contact/contact', ['title' => $title, 'name' => $name]);
        //        return view('Contact/contact',compact('title','name'));

    }

    public function send()
    {
        $model = new Contact();
        $model->loadData();

        if(!$model->validate()){
//         dump($model->getErrors());
            return view('Contact/contact',['title'=>'contact form','errors'=>$model->getErrors()]);
        }
//        response()->redirect('/');
        response()->redirect('/framework.loc/');
        return 'Contact form POST page';
    }

}