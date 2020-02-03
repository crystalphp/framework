<?php

namespace Crystal\Ajax;

class Ajax{

    protected static $events = [];
    protected static $before_name = '';

    public static function make($name , \Closure $action){
        static::$events[static::$before_name.$name] = $action;
    }

    public static function group($name , \Closure $func){
    	static::$before_name = $name . '.';
    	$func();
    	static::$before_name = '';
    }

    public static function run($name){
        $func = static::$events[static::$before_name.$name];
        $h = new Handler;
        return \call_user_func_array($func , [$h , $h->data()])->__toString();
    }
}
