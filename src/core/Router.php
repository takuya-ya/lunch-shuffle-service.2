<?php

class Router
{
    private $routes;
    // クラス内で引数を再利用する為に、プロパティ化する事が多い印象
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
