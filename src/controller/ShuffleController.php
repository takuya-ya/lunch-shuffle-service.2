<?php

class shuffleController extends Controller
{
    public function index()
    {
        // 下記でHTMLとしてreturnする為の処理を呼出している　処理内容は継承先のController.phpのrenderメソッド
        return $this->render([
            'groups' => [],
        ],);
    }

    public function create()
    {
        // groups作成条件がPOSTでのアクセス。GETの場合はここでgroupsを定義しておかないと未定義になる。
        $groups = [];
        // // このrequestは呼出し元のApplicationでインスタンス化した物を渡して置くことで再利用できる
        // // 渡し方の1つとしてクラス全体で共有。他のクラスでも使用するので継承元のControllerのインスタンスで取得
        if (!$this->request->isPost()) {
                throw new HttpNotFoundException('Getでアクセスは出来ません');
        };


        $employees = $this->databaseManager->get('Employee')->fetchAllNames();

        shuffle($employees);
        $cnt = count($employees);

        if ($cnt % 2 === 0) {
            $groups = array_chunk($employees, 2);
        } else {
            $extra = array_pop($employees);
            $groups = array_chunk($employees, 2);
            array_push($groups[0], $extra);
        }

        return $this->render(
            ['groups' => $groups],
            'index'
        );
    }
}
