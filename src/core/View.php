<?php

class View
{
    protected $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    // TODO　本当はfalseの場合の表示内容をifで指定する必要がある
    public function render($path, $variables, $layout = false)
    {
        // 配列の中の値を変数として展開してくれる
        extract($variables);

        // HTMLの本文部分を即時出力されないように一時取得の為に変数に代入（バッファリング）
        ob_start();
        // echoにするとファイル名の文字列が出力されるだけで、ファイルが実行されないのでHTMLが表示されない
        require $this->baseDir . '/' . $path . '.php';
        //  $content の役割が「レイアウトに埋め込むための中身（本文）」であり、それ自体を直接出力することが目的ではないからreturnしない。出力する必要が無いから。これは出力せず、$layout内で変数展開する。
        $content = ob_get_clean();
        // 以上で、$contentを使用すると バッファした内容が‘文字列‘で出力される。

        ob_start();
        require $this->baseDir . '/' . $layout . '.php';
        // HTMLのレイアウト部分を即時出力されないように一時取得
        $layout = ob_get_clean();

        return $layout;
    }


}
