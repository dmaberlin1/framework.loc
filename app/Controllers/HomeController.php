<?php

namespace App\Controllers;

use PHPFramework\Application;

class HomeController extends BaseController
{

    public function index()
    {
//        dump(db());
        session()->set('name','Tom');

        $title = 'main page';
//        $posts = db()->query("SELECT * FROM posts where id >?",[2])->get();
        $table = 'posts';
        $posts = db()->findAll($table);
//        $post=db()->findById($table,1);
        $postFail=db()->findByIdOrFail($table,2);
//        dump($posts[0]['content']);
//        dump($posts);
//        dump($post);
//        dump($postFail);
        return view('main',['title'=> $title,'posts'=>$posts]);
    }
}