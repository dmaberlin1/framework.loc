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

    public function add($path, $callback, $method): self
    {
        $path = trim($path, '/');
        if (is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
            //            dd($method);
        }
        $this->routes[] = [
            'path' => "/{$path}",
            'callback' => $callback,
            'middleware' => null,
            'method' => $method,
        ];
        //        foreach ($method as $item_method) {
        //            $this->routes[$item_method]["/{$path}"] = [
        //                'callback' => $callback,
        //                'middleware' => null,
        //            ];
        //        }
        //                dump($this->getRoutes());
        return $this;
    }

    public function get($path, $callback)
    {
        return $this->add($path, $callback, 'GET');
        //        $path = trim($path, '/');
        //        $this->routes['GET']["/{$path}"] = $callback;
    }

    public function post($path, $callback)
    {
        return $this->add($path, $callback, 'POST');
        //        $this->routes['POST'][$path] = $callback;
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

        if (is_array($callback['callback'])) {
            $callback['callback'][0] = new $callback['callback'][0];
        }
        return call_user_func($callback['callback']);

    }

    protected function matchRoute($method, $path)
    {
        foreach ($this->routes as $route) {
            if ((preg_match("#^{$route['path']}$#", "/{$path}", $matches))
                &&
                (in_array($this->request->getMethod(), $route['method']))
            ) {
                //                dump($route);
                if ($route['middleware']) {
                    $middleware = MIDDLEWARE[$route['middleware']] ?? false;
                    dump($middleware);
                    //если нет совпадений- пропуск
                    if($middleware){
                        (new $middleware)->handle();
                    }
                }
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

    public function only($middleware): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;

    }

}