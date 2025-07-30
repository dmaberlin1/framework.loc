<?php

namespace App\Controllers;

use PHPFramework\Controller;

class BaseController extends Controller
{

    public function __construct()
    {
        db()->query("SELECT * from posts");
    }

}