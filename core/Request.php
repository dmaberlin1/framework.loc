<?php

namespace PHPFramework;

class Request
{
    public string $uri;

    public function __construct(string $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $this->uri=trim(urldecode($uri),'/');

        dump($this->uri);
    }

    public function getPath():string
    {
        return $this->uri;
    }
    public function getMethod():string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}

?>

<!--<input type="hidden" name="_method" value="DELETE"></input>-->
