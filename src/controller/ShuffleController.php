<?php

require_once __DIR__ . '/../core/Controller.php';

class shuffleController extends Controller
{
    public function index()
    {

    // GETアクセス時にもエラーが出ないよう、groupsを空で初期化しておく。views/index.phpでcreate時の従業員の出力を$groups配列に入れてループで出力している。そのため、この$groupsが無いと、ループで回す配列がないとエラーになる。そのため、エラー回避の為にここで配列定義。本来であれば actionごとに適切なViewを分けて使うのが理想なので後ほど。
        $groups = [];

        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        // バリデーション
        if ($mysqli->connect_error) {
            // 例外クラス：　実行中の一般的なエラー。原因が広範で、他に適切な例外がないときに使われる。
            throw new RuntimeException('mysqli接続エラー：' . $mysqli->connect_error);
        }

        include __DIR__ . '/../views/index.php';
    }

    public function create()
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
        $mysqli->close();

        include __DIR__ . '/../views/index.php';
        }

}
