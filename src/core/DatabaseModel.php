<?php

class DatabaseModel
{
    protected $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function fetchAll($sql)
    {
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($sql,  $params = [])
    {
        // SQL分の準備 mysqli_stmt(プリペアドステートメントを表します。)をreturn
        // ステートメントはSQL文を安全に実行するための準備済みオブジェクト
        // SQLインジェクションを防ぐ（? を使って値をあとで安全に差し込む）
        $stmt = $this->mysqli->prepare($sql);
        // プリペアドステートメントのパラメータに変数をバインドする s = 変数を文字列で指定
        if ($params) {
            $stmt->bind_param(...$params);
        }
        $stmt->execute();
        // close しないと MySQL 側にステートメントが残り続ける（＝リソースリーク）
        $stmt->close();
    }
}
