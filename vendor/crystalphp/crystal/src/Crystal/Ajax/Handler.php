<?php

namespace Crystal\Ajax;

class Handler{
    public $request;
    private $data;


    public function data($i = null){
        $data = $this->data;

        if($i === null){
            return $data;
        }

        if(isset($data[$i])){
            return $data[$i];
        }
        return null;
    }

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
