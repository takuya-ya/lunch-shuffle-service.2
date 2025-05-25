<?php

class Controller
{
    public function run($action)
    {
        if (!method_exists($this, $action)) {
            throw new HttpNotFoundException('action');
        }
        // actionの実行
        $this->$action();
    }
}
