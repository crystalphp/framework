<?php

class AppEventListener{

    private static $on_starts = [];
    private static $on_begin_requests = [];
    private static $on_error_404 = [];
    private static $on_end_requests = [];

    public static function on_start(Closure $func=null)
    {
        if($func === null){
            foreach(static::$on_starts as $on_start_tmp){
                $on_start_tmp(new Request);
            }
        }else{
            array_push(static::$on_starts , $func);
        }
    }

    public static function on_begin_request(Closure $func=null)
    {
        if($func === null){
            foreach(static::$on_begin_requests as $on_tmp){
                $on_tmp(new Request);
            }
        }else{
            array_push(static::$on_begin_requests , $func);
        }
    }

    public static function on_error_404(Closure $func=null)
    {
        if($func === null){
            foreach(static::$on_error_404 as $on_tmp){
                $on_tmp(new Request);
            }
        }else{
            array_push(static::$on_error_404 , $func);
        }
    }

    public static function on_end_request(Closure $func=null)
    {
        if($func === null){
            foreach(static::$on_end_requests as $on_tmp){
                $on_tmp(new Request);
            }
        }else{
            array_push(static::$on_end_requests , $func);
        }
    }
}

