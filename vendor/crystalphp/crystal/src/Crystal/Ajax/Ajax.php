<?php

namespace Crystal\Ajax;

class Ajax{

    protected static $events = [];

    public static function make($name , \Closure $action){
        static::$events[$name] = $action;
    }

    public static function run($name){
        $func = static::$events[$name];
        $h = new Handler;
        return \call_user_func_array($func , [$h , $h->data()])->__toString();
    }
}
