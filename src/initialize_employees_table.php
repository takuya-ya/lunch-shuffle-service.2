<?php

$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');

// バリデーション
if ($mysqli->connect_error) {
    // 例外クラス：　実行中の一般的なエラー。原因が広範で、他に適切な例外がないときに使われる。
    throw new RuntimeException('mysqli接続エラー：' . $mysqli->connect_error);
}

$mysqli->query('DROP TABLE IF EXISTS employees');

$createTableSql = <<<EOT
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
EOT;
// TIMESTAMP：日付と時刻の型（例：2024-01-01 12:34:56）
// DEFAULT CURRENT_TIMESTAMP：新しいレコード作成時、現在時刻を自動でセット
// DEFAULT は、カラムに値が指定されなかった場合に自動的に使われる初期値を設定するSQLキーワードです。

$mysqli->query($createTableSql);
$mysqli->close();
