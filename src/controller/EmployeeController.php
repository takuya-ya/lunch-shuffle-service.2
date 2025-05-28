<?php

class EmployeeController extends Controller
{
    public function index()
    {
        $errors = [];

        // $result = $mysqli->query('SELECT name FROM employees');
        // $employees = $result->fetch_all(MYSQLI_ASSOC);

        $employees = $this->databaseManager->get('Employee')->fetchAllNames();
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

        if (!$this->request->isPost()) {
            throw new HttpNotFoundException('Getでアクセスは出来ません');
        };

        $employee = $this->databaseManager->get('Employee');
        $employees = $employee->fetchAllNames();

        if (!strlen($_POST['name'])) {
        $errors['name'] = '名前を入力してください';
        } elseif (strlen($_POST['name']) > 100) {
        $errors['name'] = '社員名は100文字以内で入力してください';
        }

        if (!count($errors)) {
            $employee->insert($_POST['name']);
        }
        // 「即時リダイレクトされる」わけではなく、HTTPレスポンスの一部として指示されるだけです。
        // PHP側でURLに移動するのではなく、ブラウザに「移動してね」と伝えるだけです。その指示をブラウザが受け取って初めて実際の遷移が起こります。
        // header('Location: /employee');

        $employees = $this->databaseManager->get('Employee')->fetchAllNames();

        return $this->render(
            [
                'errors' => $errors,
                'employees' => $employees,
            ],
            'index',
        );
    }


}
