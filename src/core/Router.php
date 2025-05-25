<?php

class Router
{
    private $routes;
    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    // アクセスされたURLと登録しているcontrollerとactionが合致するか確認
    public function resolve($pathInfo)
    {
        foreach ($this->routes as $path => $pattern) {
            if ($path === $pathInfo) {
                return $pattern;
            }
        }
        return false;
    }
}
