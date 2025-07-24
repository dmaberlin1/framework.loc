<?php

namespace App\Controllers;

use App\Models\Post;

class PostController extends BaseController
{
    public function edit()
    {
        $id = request()->get('id');
        $post = db()->findByIdOrFail('posts', $id);
        dump($post);
        return view('Posts/edit', ['title' => 'Edit post', 'post' => $post]);
    }

    public function update()
    {
        $id = request()->post('id');
        if (!$id) {
            $this->setErrorFlash();
            response()->redirect('/framework.loc');
        }
        dump($id);
        $post = new Post();
        $post->loadData();
        $post->attributes['id'] = $id;
        if (!$post->validate()) {
            dump($post->getErrors());
            $this->setErrorFlash($post);
            response()->redirect("/framework.loc/posts/edit?={$id}");
        }
        dump($post);
        if ($post->update()) {
            $this->setSuccessFlash($id);
            response()->redirect('/framework.loc/posts/edit?={$id}');
        }else{

        }
    }

    public function create()
    {
        if (request()->isPost()) {

        }
        $title = 'Create post';
        return view('Posts/create', ['title' => $title]);
    }

    public function send()
    {
        $post = new Post();
        $post->loadData();
        if (!$post->validate()) {
            $title = 'Create post';
            dump($post->getErrors());
            return view('Posts/create', ['title' => $title]);

        }
        //        dump($post);
        $id = $post->save();

        if ($id = $post->save()) {
            $this->setSuccessFlash($id);
        } else {
           $this->setErrorFlashMessage('Not found ID');
        }
        response()->redirect('/framework.loc/posts/create');


    }

    /**
     * @param string|null $id
     * @return void
     */
    public function setSuccessFlash(?string $id): void
    {
        session()->setFlash('success', "Post {$id} created");
    }

    /**
     * @param Post|null $post
     * @return void
     */
    public function setErrorFlashPost(Post $post=null): void
    {
        if ($post === null) {
            session()->setFlash('error', 'Not found ID');
        } else {
            session()->setFlash('error', $post->listErrors());
        }
    }
    /**
     * @param Post|null $post
     * @return void
     */
    public function setErrorFlashMessage($message): void
    {
            session()->setFlash('error', $message);
    }

}