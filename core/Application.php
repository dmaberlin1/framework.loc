<?php

namespace PHPFramework;

class Application
{

    public string $uri;
    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;
    public Database $db;
    public static Application $app;

    public function __construct()
    {
//             dump($_SERVER['QUERY_STRING'],$_SERVER['REQUEST_URI'],$_GET);
        self::$app=$this;
        $this->uri = ltrim($_SERVER['QUERY_STRING'], 'q=');

        $this->request = new \PHPFramework\Request($this->uri);
        $this->response = new \PHPFramework\Response();
        $this->router = new \PHPFramework\Router($this->request, $this->response);
        $this->view=new View(LAYOUT);
        $this->db=new Database();

        //        dump($this->uri);
        //    $_SERVER['QUERY_STRING'] ==  "q=posts&page=3"
    }

    public function run():void
    {
       echo $this->router->dispatch();
    }

}