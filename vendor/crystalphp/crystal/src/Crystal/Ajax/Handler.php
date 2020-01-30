<?php

namespace Crystal\Ajax;

class Handler{
    public $request;
    public $data;

    function __construct(){
        $this->request = new \Crystal\Http\Request;
        $this->data = $_GET;
    }



    public function alert($msg){
        return "alert('{$msg}')";
    }

    public function redirect($to){
        return "location.href='{$to}'";
    }

    public function jscode($code){
        return $code;
    }
}
