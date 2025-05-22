<?php

class shuffleController
{
    public function run($action)
    {
        $this->$action();
    }

    private function index()
    {

        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        // groups作成条件がPOSTでのアクセス。GETの場合はここでgroupsを定義しておかないと未定義になる。
        $groups = [];

        // バリデーション
        if ($mysqli->connect_error) {
            // 例外クラス：　実行中の一般的なエラー。原因が広範で、他に適切な例外がないときに使われる。
            throw new RuntimeException('mysqli接続エラー：' . $mysqli->connect_error);
        }

        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);
        shuffle($employees);
        $cnt = count($employees);

        if ($cnt % 2 === 0) {
            $groups = array_chunk($employees, 2);
        } else {
            $extra = array_pop($employees);
            $groups = array_chunk($employees, 2);
            array_push($groups[0], $extra);
        }
        // 動画に記載無し
        // $mysqli->close();
    
        include __DIR__ . '/../views/index.php';
    }

}

