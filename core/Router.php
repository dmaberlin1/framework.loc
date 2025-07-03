<?php

namespace PHPFramework;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function get($path, $callback): void
    {
        $path = trim($path, '/');
        $this->routes['GET']["/{$path}"] = $callback;
    }

    public function post($path, $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch():mixed
    {
        $path = $this->request->getPath();
//        dump($path);
        $method = $this->request->getMethod();
        $callback = $this->routes[$method]["/{$path}"] ?? false;

        //        dump($path,$method,$callback);
        if ($callback === false) {
            $this->response->setResponseCode(404);
            return 'Page not found';
        }
//        первый вариант
//        if(is_array($callback)){
//            в 0 индексе создаём екземпляр класса
//            $object=new $callback[0];
//            $action=$callback[1];
//            return $object->$action();
//        }

        if(is_array($callback)){
            $callback[0]=new $callback[0];
        }
//        var_dump($callback);
        return call_user_func($callback);

    }

}