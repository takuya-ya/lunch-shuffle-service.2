<?php

class HttpNotFoundException extends Exception
{

    public function __construct($place)
    {
        echo $place . 'でエラー発生';
    }
};
