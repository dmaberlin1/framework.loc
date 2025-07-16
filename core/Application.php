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
    public Session $session;
    public static Application $app;

    public function __construct()
    {
//             dump($_SERVER['QUERY_STRING'],$_SERVER['REQUEST_URI'],$_GET);
        self::$app=$this;
        $this->uri = ltrim($_SERVER['QUERY_STRING'], 'q=');

        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view=new View(LAYOUT);
        $this->db=new Database();
        $this->session = new Session();

    }

    public function run():void
    {
       echo $this->router->dispatch();
    }

}