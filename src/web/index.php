<?php

// このファイルに書いてもいいが、初期化処理をbootstrapにまとめる
require '../bootstrap.php';
require '../Application.php';

$app = new Application();
$app->run();
