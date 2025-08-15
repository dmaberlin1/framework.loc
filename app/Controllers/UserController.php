<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{

    public function register()
    {
        $title = 'Registration';

        if (request()->isPost()) {
            $user = new User();
            $user->loadData();
            //            dump($user);
            //            dump($user->validate());
            //            dump($user->getErrors());
            if (!$user->validate()) {
                return view('Users/register', ['title' => $title, 'errors' => $user->getErrors()]);
            }
//            dd($user->getErrors());

            $user->hashPassword();

            if ($user->save()) {
                session()->setFlash('success', 'You have successfully registered');
                response()->redirect(LOGIN_PAGE);
            } else {
                session()->setFlash('error', 'Error registration');
            }
        }
        return view('Users/register', ['title' => $title]);
    }

    public function login()
    {
        $title = 'Login';
        if (request()->isPost()) {
            $user = new User();
            $user->loadData();
            if (!$user->validate($user->attributes, [
                'email' => ['required' => true],
                'password' => ['required' => true],
            ])) {
                return view('Users/login',
                    ['title' => $title,
                        'errors' => $user->getErrors()]);
            };

            if ($user->auth()) {
                session()->setFlash('success', 'You have successfully logged');
                response()->redirect('/framework.loc/');
            } else {
                session()->setFlash('error', 'Incorrect email or password');

            };
        }
        return view('Users/login', ['title' => $title]);

    }

    public function logout()
    {
        logout_from_session();
        response()->redirect('/framework.loc/login');

    }
}