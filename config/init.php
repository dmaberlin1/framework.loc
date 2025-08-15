<?php

define('ROOT', dirname(__DIR__));
const DEBUG = 1;
//1 час по дефолту
const CACHE_TIME = 3600;
const ERROR_LOG_FILE = ROOT . '/temp/error.log';
const WWW = ROOT . '/public';
const UPLOADS = WWW . '/uploads';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const HELPERS = ROOT . '/helpers';
const CONFIG = ROOT . '/config';
const VIEWS = APP . '/Views';
const LAYOUT = 'default';
const PATH = 'http://localhost/framework.loc';
const LOGIN_PAGE = PATH . '/login';
const CACHE = ROOT.'/temp/cache';

const DB = [
    'host' => 'localhost',
    'dbname' => 'fr_loc',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ],
];

const EMAIL=[
    'host' => 'sandbox.smtp.mailtrap.io',
    'auth' => 'true',
    'username' => '7531eeb222f01f',
    'password' => '39a5f5983958cd',
    'secure' => 'tls',  //возможно ssl
    'port' => 587,  //допускается 25 465 2525
    'from_email'=>'6291251803-908c2d+user1@inbox.mailtrap.io',
    'add_address'=>'6291251803-908c2d+user1@inbox.mailtrap.io',
    'is_html'=>true,
    'charset'=>'UTF-8',
    'debug'=>0,
];