<?php

namespace Crystal\App;

use Crystal\Http\Request;
use \Closure;

class AppEventListener{

    private static $on_start = [];
    private static $on_begin_request = [];
    private static $on_error_404 = [];
    private static $on_end_request = [];

    private static $lock = false;

    private static function on($name , Closure $func=null){
        if($func === null){
            foreach(static::$$name as $tmp){
                echo $tmp(new Request);
            }
        }else{
            if( ! static::$lock){
                array_push(static::$$name , $func);
            }
        }
    }


    public static function __callStatic($name , $args){
        if( ! isset(static::$$name)){
            throw new \Crystal\Exceptions\EventNotFound([$name]);
        }

        $func = isset($args[0]) ? $args[0] : null;
        if($func !== null){
            if( ! is_a($func, '\Closure')){
                throw new \Crystal\Exceptions\ArgumentError(["passed argument to AppEventListener should be Closure"]);
            }
        }

        static::on($name , $func);
    }



    public static function lock(){
        static::$lock = true;
    }

}

