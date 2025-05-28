<?php

class DatabaseManager
{
    protected $mysqli;
    protected $models;

    public function connect($params)
    {
        // GETアクセス時にもエラーが出ないよう、groupsを空で初期化しておく。views/index.phpでcreate時の従業員の出力を$groups配列に入れてループで出力している。
        // そのため、この$groupsが無いと、ループで回す配列がないとエラーになる。そのため、エラー回避の為にここで配列定義。本来であれば actionごとに適切なViewを分けて使うのが理想なので後ほど。
        $mysqli = new mysqli($params['hostName'], $params['userName'], $params['password'], $params['database']);
        // バリデーション
        if ($mysqli->connect_error) {
            // 例外クラス：　実行中の一般的なエラー。原因が広範で、他に適切な例外がないときに使われる。
            throw new RuntimeException('mysqli接続エラー：' . $mysqli->connect_error);
        }

        $this->mysqli = $mysqli;
    }

    public function get($modelName)
    {
        if (!isset($this->models[$modelName])) {
        // 各モデルに 個別でDB接続情報を持たせず、共通の DataBaseManager で接続を管理し、モデルに$this->mysqliで注入する
        $model = new $modelName($this->mysqli);
        $this->models[$modelName] = $model;
        };

        return $this->models[$modelName];
    }

    // インスタンスの仕様終了時点で自動で処理をしてくれる
    public function __destruct()
    {
        $this->mysqli->close();
    }
}
