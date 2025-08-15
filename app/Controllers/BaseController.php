<?php

namespace App\Controllers;

use PHPFramework\Controller;

class BaseController extends Controller
{

    public function __construct()
    {
        $users=cache()->getOrIfNotExistSetAndGet('users');
//        $users=cache()->get('users');
//            if(!$users){
//                $users=db()->findAll('users');
//                cache()->set('users',$users);
//            }
        app()->set('users',$users);
        dump($users);
    }

}