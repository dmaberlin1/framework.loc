<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends BaseController
{

    public function create()
    {
        if(request()->isPost()){

        }
        $title='Create post';
        return view('Posts/create',['title'=>$title]);
    }

    public function send()
    {
        $post = new Post();
        $post->loadData();
        if(!$post->validate()){
            $title='Create post';
            dump($post->getErrors());
            return view('Posts/create',['title'=>$title]);

        }
//        dump($post);
        $id = $post->save();
        dump($id);
        return 'OK';

    }
}