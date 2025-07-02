<?php

namespace PHPFramework;

class Request
{
    public string $uri;

    public function __construct(string $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $this->uri = trim(urldecode($uri), '/');

        //        dump($this->uri);
    }

    public function getPath(): string
    {
        //        return $this->uri;
        return $this->removeQueryString();
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function removeQueryString(): string
    {
        if ($this->uri) {
            $params=explode('&',$this->uri);
            if(!str_contains($params[0], '=')){
                return trim($params[0],'/');
            }
//            dump($params);
        }
        return '';
    }

    public function get($name,$default=null):?string
    {
        return $_GET[$name]??$default;
    }

}
