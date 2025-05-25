<?php


require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/controller/ShuffleController.php';
require_once __DIR__ . '/controller/EmployeeController.php';

// アプリ全体のエントリーポイント（起動制御）
// // Application クラスがインスタンス化される（__construct() が呼ばれる）
// 　→ registerRoutes() を使ってルート定義を作成し、Router クラスを初期化。

// run() メソッドが呼ばれる
// 　→ 現在のリクエストURL を getPathInfo() で取得。
// 　→ Router::resolve() を使ってコントローラー名とアクション名を特定。

// runAction() が実行される
// 　→ 指定されたコントローラークラスを生成。
// 　→ そのコントローラーの run() メソッドにアクション名を渡して処理を実行。

class Application
{
    private $router;
    public function __construct()
    {
    // ルーティングの処理を行うクラス
        $this->router = new Router($this->registerRoutes());
    }

    public function run()
    {
    // Router クラスを使ってルーティング機能（URL解析）を準備
    // アクセスされたURLがルート定義と一致するか確認し、一致すれば対応するコントローラーとアクションを指定するクラス
        $params = $this->router->resolve($this->getPathInfo());
    // $path に対応するコントローラーとアクション（関数）を判定
        $controller = $params['controller'];
        $action = $params['action'];

        $this->runAction($controller, $action);
    }

    // 対応するページを表示するために、コントローラーを生成してアクションの処理を実行する
    private function runAction($controllerName, $action)
    {
        $controllerClass = ucwords($controllerName) . 'Controller';
        $controller = new $controllerClass();
        $controller->run($action);
    }

    public function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/shuffle' => ['controller' => 'shuffle', 'action' => 'create'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
            '/employee/create' => ['controller' => 'employee', 'action' => 'create'],

        ];
    }

    public function getPathInfo()
    {

        return $_SERVER['REQUEST_URI'];
    }
    }
