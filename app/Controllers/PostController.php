<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends BaseController
{
    public function edit()
    {
        $id=request()->get('id');
        $post=db()->findByIdOrFail('posts',$id);
        dump($post);
        return view('Posts/edit',['title'=>'Edit post','post'=>$post]);
    }

    public function update()
    {
        $id=request()->post('id');
        if(!$id){
            session()->setFlash('error','Not found ID');
            response()->redirect('/framework.loc');
        }
        dump($id);
        $post = new Post();
        $post->loadData();
        $post->attributes['id']=$id;
        if(!$post->validate()){
            $title='Create post';
            dump($post->getErrors());
            session()->setFlash('error',$post->listErrors());
            response()->redirect("/framework.loc/posts/edit?={$id}");
        }
        dump($post);
    }

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

        if($id=$post->save()){
            session()->setFlash('success',"Post {$id} created");
        }else{
            session()->setFlash('error','Unknown errors');
        }
        response()->redirect('/framework.loc/posts/create');


    }
}