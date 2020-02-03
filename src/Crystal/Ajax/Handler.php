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



    public function __call($name , $args){
        $res = new Response;
        return call_user_func_array([$res , $name], $args);
    }
}
