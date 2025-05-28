<?php

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
    protected $request;
    protected $router;
    protected $response;
    protected $databaseManager;

    public function __construct()
    {
        // ルーティングの処理を行うクラス

        $this->request = new Request();
        $this->router = new Router($this->registerRoutes());
        $this->response = new Response();
        $this->databaseManager = new DatabaseManager();
        $this->databaseManager->connect(
            [
                'hostName' => 'db',
                'userName' => 'test_user',
                'password' => 'pass',
                'database' => 'test_database',
            ]
        );

    }

    public function run()
    {
    // Router クラスを使ってルーティング機能（URL解析）を準備
    // アクセスされたURLがルート定義と一致するか確認し、一致すれば対応するコントローラーとアクションを指定するクラス
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundException('ルーティング');
            }
            // $path に対応するコントローラーとアクション（関数）を判定
            $controller = $params['controller'];
            $action = $params['action'];

            $this->runAction($controller, $action);

        } catch (HttpNotFoundException) {
            $this->render404Page();
        }

        $this->response->send();
    }

    // 対応するページを表示するために、コントローラーを生成してアクションの処理を実行する
    private function runAction($controllerName, $action)
    {
        $controllerClass = ucwords($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
                throw new HttpNotFoundException('Controller');
        }

        // Applicationクラス自体を渡す(web/index.phpでインスタンス化している)
        $controller = new $controllerClass($this);
        // run 継承したメソッド。actionを実行する。actionはecho でviewを表示していたいが、それをcontentに代入して渡す
        // 全てのクラスにactionを実行させる為のrunメソッドを共通して実装している
        // メソッドを変数で抽象化により、再利用性の高い状態
        $content = $controller->run($action);
        $this->response->setContent($content);
    }

    // 他のクラスからこのメソッドを使用して、このクラスのプロパティにアクセス
    // プロパティに他のクラスからapplication->requestなどで呼出しも可能　しかし、その場合はプロパティをpublicで扱うようになるので、意図しない変更を防止する為、get系メソッドからアクセスにしている。
    public function getRequest()
    {
        return $this->request;
    }
    public function getDatabaseManager()
    {
        return $this->databaseManager;
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

    private function render404Page()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->setContent(
            <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404</title>
</head>

<body>
<h1>404 Page not found.</h1>
</body>
</html>
EOF
        );
    }
}
