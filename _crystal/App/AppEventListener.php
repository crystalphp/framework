<?php

namespace Crystal\App;

use Crystal\Http\Request;
use \Closure;

class AppEventListener{

    private static $on_start = [];
    private static $on_begin_request = [];
    private static $on_error_404 = [];
    private static $on_end_request = [];

    private static function on($name , Closure $func=null){
        if($func === null){
            foreach(static::$$name as $tmp){
                $tmp(new Request);
            }
        }else{
            array_push(static::$$name , $func);
        }
    }


    public function on_error_404($func=null){
        static::on('on_error_404' , $func);
    }

    public function on_begin_request($func=null){
        static::on('on_begin_request' , $func);
    }

    public function on_start($func=null){
        static::on('on_start' , $func);
    }

    public function on_end_request($func=null){
        static::on('on_end_request' , $func);
    }

}

