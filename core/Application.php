<?php

namespace PHPFramework;

class Application
{

    public string $uri;
    public Request $request;
    public Response $response;
    public Router $router;

    public function __construct()
    {
        //     dump($_SERVER['QUERY_STRING'],$_SERVER['REQUEST_URI'],$_GET);
        $this->uri = ltrim($_SERVER['QUERY_STRING'], 'q=');

        $this->request = new \PHPFramework\Request($this->uri);
        $this->response = new \PHPFramework\Response();
        $this->router = new \PHPFramework\Router($this->request, $this->response);

        //        dump($this->uri);
        //    $_SERVER['QUERY_STRING'] ==  "q=posts&page=3"
    }

    public function run()
    {
        $this->router->dispatch();
    }

}