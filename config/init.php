<?php

define('ROOT',dirname(__DIR__));
const DEBUG=1;
const ERROR_LOG_FILE=ROOT.'/temp/error.log';
const WWW=ROOT.'/public';
const APP=ROOT.'/app';
const CORE=ROOT.'/core';
const HELPERS=ROOT.'/helpers';
const CONFIG=ROOT.'/config';
const VIEWS=APP.'/Views';
const LAYOUT ='default';
const PATH='http://localhost/framework.loc';

const DB=[
    'host'=>'localhost',
    'dbname'=>'fr_loc',
    'username'=>'root',
    'password'=>'root',
    'charset'=>'utf8mb4',
    'options'=>[
      PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
    ],
];