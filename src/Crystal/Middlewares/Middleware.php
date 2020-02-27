<?php

namespace Crystal\Middlewares;

use Crystal\App\app;
use Crystal\Http\Request;

class Middleware{
    public static function call_requireds()
    {
        $required_middlewares = app::get_config('http')['middlewares']['required'];
        static::call_list($required_middlewares);
    }

    public static function call_list($middlewares)
    {
        foreach($middlewares as $middleware){
            $middleware_n = '\Middlewares\\' . $middleware;

            if( ! class_exists($middleware_n)){
                throw new \Crystal\Exceptions\MiddlewareNotFound([$middleware]);
            }

            $tmp_obj = new $middleware_n;

            if( ! method_exists($tmp_obj, 'handle')){
                throw new \Crystal\Exceptions\MethodNotFound(['handle' , 'middleware ' . $middleware]);
            }

            $method_reflection = new \ReflectionMethod($tmp_obj, 'handle');
            if( ! $method_reflection->isPublic()){
                throw new \Crystal\Exceptions\MethodTypeError(['handle' , $middleware , 'public']);
            }

            $result = $tmp_obj->handle(new Request);
            if($result !== false){
                \Crystal\Http\Router::$do_finish = false;
                die($result);
            }
        }
    }
}
