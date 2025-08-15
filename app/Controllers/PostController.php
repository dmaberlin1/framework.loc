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

    public function show()
    {
        $slug = router()->route_params['slug'] ?? '';
        dump($slug);

        $post = db()->findPostBySlug($slug);
        if (!$post) {
            abort("Post by slug {$slug} not found");
        }
        return view('Posts/show', ['title' => 'Show post', 'post' => $post]);
    }

    public function update()
    {
        $id = request()->post('id');
        $post = db()->findByIdOrFail('posts', $id);
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
        if (!$post->validate($post->attributes,[
            'title' => ['required' => true, 'min' => 2, 'max' => 50],
            'content' => ['required' => true, 'min' => 5, 'max' => 200],
            'slug' => ['required' => true,'unique'=>'posts:slug,id'],
        ])) {
            dump($post->getErrors());
            $this->setErrorFlashPost($post);
            response()->redirect("/framework.loc/posts/edit?={$id}");
        }
        dump($post);
        if ($post->update() !== false) {
            $this->setSuccessFlash($id);
            response()->redirect("/framework.loc/posts/edit?={$id}");
        } else {
            $this->setErrorFlashMessage('Error updating..');
            response()->redirect("/framework.loc/");
        }
    }

    public function create()
    {
        //        тест производной валидации
        //        $post = new Post();
        //        dump($post->validate(
        //            [
        //                'name' => 'John',
        //                'email' => '1@gmail.com',
        //                'text' => '123'
        //            ],
        //            [
        //                'name' => ['required' => true],
        //                'email' => ['email' => true],
        //                'text' => ['min' => 10]
        //            ]
        //        ));
        //        dump($post->getErrors());

        $title = 'Create post';
        return view('Posts/create', ['title' => $title]);
    }

    public function store()
    {
        $post = new Post();
        $post->loadData();

        $thumbnail = 'thumbnail';
        if (isset($_FILES[$thumbnail])) {
            $post->attributes[$thumbnail] = $_FILES[$thumbnail];
        } else {
            $post->attributes[$thumbnail] = [];
        }

        $thumbnails = 'thumbnails';
        if (isset($_FILES[$thumbnails])) {
            $post->attributes[$thumbnails] = $_FILES[$thumbnails];
        } else {
            $post->attributes[$thumbnails] = [];
        }

        if (!$post->validate()) {
            $title = 'Create post';
            dump($post->getErrors());
            return view('Posts/create', ['title' => $title]);
        }

        if ($id = $post->savePost()) {
            $this->setSuccessFlash($id);
        } else {
            $this->setErrorFlashMessage('Not found ID');
        }
        response()->redirect('/framework.loc/posts/create');


    }

    public function delete()
    {
        $id = request()->get('id');
        db()->findByIdOrFail('posts', $id);
        $post = new Post();
        if ($post->delete($id)) {
            $this->setSuccessDeletedFlash($id);
        } else {
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
    public function setErrorFlashPost(Post $post = null): void
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