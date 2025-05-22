<?php


require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/controller/ShuffleController.php';

// アプリ全体のエントリーポイント（起動制御）
// Router を使ってリクエストURLに対応する処理を判断し、コントローラーに渡す
class Application
{
    private $router;
    public function __construct()
    {
        // ルーティングの実際の処理
        $this->router = new Router($this->registerRoutes());
    }

   public function run() 
   {
    // Router クラスを使ってルーティング機能（URL解析）を準備
        $params = $this->router->resolve($this->getPathInfo());
    // $path に対応するコントローラーとアクション（関数）を判定
        $controller = $params['controller'];
        $action = $params['action'];

        $this->runAction($controller, $action);
   }

   private function runAction($controllerName, $action) 
   {
        $controllerClass = ucwords($controllerName) . 'Controller';
        $controller = new $controllerClass();
        $controller->run($action);
   }

   public function registerRoutes() 
   {
        return [
            '/' => [
                'controller' => 'shuffle', 
                'action' => 'index'],
            ];
   }

   public function getPathInfo()
   {
        
        return $_SERVER['REQUEST_URI'];
   }
}