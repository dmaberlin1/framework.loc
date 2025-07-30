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
        $post=db()->findByIdOrFail('posts',$id);
//        if (!$post) {
//            $this->setErrorFlashMessage('Not found POST');
//            response()->redirect('/framework.loc');
//        }
        if (!$id) {
            $this->setErrorFlashMessage('Not found id');
            response()->redirect('/framework.loc');
        }
        dump($id);
        $post = new Post();
        $post->loadData();
        $post->attributes['id'] = $id;
        if (!$post->validate()) {
            dump($post->getErrors());
            $this->setErrorFlashPost($post);
            response()->redirect("/framework.loc/posts/edit?={$id}");
        }
        dump($post);
        if ($post->update() !== false ) {
            $this->setSuccessFlash($id);
            response()->redirect("/framework.loc/posts/edit?={$id}");
        }else{
            $this->setErrorFlashMessage('Error updating..');
            response()->redirect("/framework.loc/");
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

    public function delete()
    {
        $id=request()->get('id');
        db()->findByIdOrFail('posts',$id);
        $post=new Post();
        if($post->delete($id)){
            $this->setSuccessDeletedFlash($id);
        }
        else{
            $this->setErrorFlashMessage('Deletion error');
        }
        response()->redirect('/framework.loc/');

    }


    /**
     * @param string|null $id
     * @return void
     */
    public function setSuccessFlash(?string $id): void
    {
        session()->setFlash('success', "Post {$id} created");
    }
    public function setSuccessDeletedFlash(?string $id): void
    {
        session()->setFlash('success', "Post {$id} deleted");
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