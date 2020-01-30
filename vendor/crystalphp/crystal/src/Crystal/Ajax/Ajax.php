<?php

namespace Crystal\Ajax;

class Ajax{

    protected static $events = [];

    public static function make($name , \Closure $action){
        static::$events[$name] = $action;
    }

    public static function run($name){
        $func = static::$events[$name];
        return $func(new Handler);
    }
}
