<?php

namespace PHPFramework;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    public array $route_params = [];

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

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->matchRoute($method, $path);
//        dd($callback);
        if ($callback === false) {
            abort();
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        //        var_dump($callback);
        return call_user_func($callback);

    }

    protected function matchRoute($method, $path)
    {
        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match("#^{$pattern}$#", "/{$path}", $matches)) {
                //                dump($matches);
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $this->route_params[$k] = $v;
                    }
                }
                return $route;
            }
        }
        return false;
    }

}