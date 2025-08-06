<?php

namespace App\Controllers;

use PHPFramework\Application;
use PHPFramework\Pagination;

class HomeController extends BaseController
{

    public function index()
    {
        $title = 'main page';
        $table = 'posts';
        $page = request()->get('page', 1);
        $per_page = 3;
        $total = db()->count($table);
        $pagination = new Pagination((int)$page, $per_page, $total);
        $start = $pagination->getStart();
//        $posts = db()->findAll($table);
        $posts = db()->query("select * from {$table} order by id desc limit $start,$per_page")->get();


        return view('main', ['title' => $title, 'posts' => $posts,'pagination'=>$pagination]);
    }
}