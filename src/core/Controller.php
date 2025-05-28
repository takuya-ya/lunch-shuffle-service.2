<?php

class Controller
{
    protected $actionName;
    public function run($action)
    {
        $this->actionName = $action;
        // method_exists(オブジェクト, 'メソッド名')
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException('action');
        }
        // actionの実行 responseへ渡す為、変数へその結果(viewsファイルの呼出し)を代入
        $content = $this->$action();
        return $content;
    }

    // MVCの「V（View）」の部分を呼び出して HTML を作り、返すメソッドです。
    // templateはメソッド、アクション名
    protected function render($variables = [], $template = null, $layout = 'layout')
    {
        $view = new View(__DIR__ . '/../views');
        // shuffle, employeeなどが$controllerNameに入る
        $controllerName = strtolower(substr(get_class($this), 0, -10));
        if (is_null($template)) {
            $template = $this->actionName;
        }
        // path＝shuffle / index という形 render()で統合してファイルパスにする
        $path = $controllerName . '/' . $template;
        // 下記でHTMLとしてreturnしている
        return $view->render($path, $variables, $layout);
    }
}
