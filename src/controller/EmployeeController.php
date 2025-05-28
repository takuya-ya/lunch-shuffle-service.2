<?php

class EmployeeController extends Controller
{
    public function index()
    {
        $errors = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        // バリデーション
        if ($mysqli->connect_error) {
            // 例外クラス：　実行中の一般的なエラー。原因が広範で、他に適切な例外がないときに使われる。
            throw new RuntimeException('mysqli接続エラー：' . $mysqli->connect_error);
        };

        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        $mysqli->close();
        // 受け取ったあと、Responseで出力するので一旦返す
        return $this->render(
            [
                'title' => '社員の登録',
                'errors' => $errors,
                'employees' => $employees,
            ],
            'index',
        );
    }

    public function create()
    {
        $errors = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        // バリデーション
        if ($mysqli->connect_error) {
            // 例外クラス：　実行中の一般的なエラー。原因が広範で、他に適切な例外がないときに使われる。
            throw new RuntimeException('mysqli接続エラー：' . $mysqli->connect_error);
        };

        if (!strlen($_POST['name'])) {
        $errors['name'] = '名前を入力してください';
        } elseif (strlen($_POST['name']) > 100) {
        $errors['name'] = '社員名は100文字以内で入力してください';
        }

        if (!count($errors)) {
        // SQL分の準備 mysqli_stmt(プリペアドステートメントを表します。)をreturn
        // ステートメントはSQL文を安全に実行するための準備済みオブジェクト
        // SQLインジェクションを防ぐ（? を使って値をあとで安全に差し込む）
        $stmt = $mysqli->prepare('INSERT INTO employees (name) VALUES (?)' );
        // プリペアドステートメントのパラメータに変数をバインドする s = 変数を文字列で指定
        $stmt->bind_param('s', $_POST['name']);
        $stmt->execute();
        // close しないと MySQL 側にステートメントが残り続ける（＝リソースリーク）
        $stmt->close();
        // 「即時リダイレクトされる」わけではなく、HTTPレスポンスの一部として指示されるだけです。
        // PHP側でURLに移動するのではなく、ブラウザに「移動してね」と伝えるだけです。その指示をブラウザが受け取って初めて実際の遷移が起こります。
        // header('Location: /employee');
        }

        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        $mysqli->close();

        return $this->render(
            [
                'errors' => $errors,
                'employees' => $employees,
            ],
            'index',
        );
    }


}
