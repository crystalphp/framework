<?php

namespace Crystal\Middlewares;

use Crystal\App\app;
use Crystal\Http\Request;

class Middleware{
    public static function call_requireds()
    {
        $required_middlewares = app::get_config()['middlewares']['required'];
        static::call_list($required_middlewares);
    }

    public static function call_list($middlewares)
    {
        foreach($middlewares as $middleware){
            $middleware_n = '\Middlewares\\' . $middleware;

            if( ! class_exists($middleware_n)){
                throw new \Exceptions\MiddlewareNotFound([$middleware]);
            }

            $tmp_obj = new $middleware_n;

            if( ! method_exists($tmp_obj, 'handle')){
                throw new \Exceptions\MethodNotFound(['handle' , 'middleware ' . $middleware]);
            }

            $method_reflection = new \ReflectionMethod($tmp_obj, 'handle');
            if( ! $method_reflection->isPublic()){
                throw new \Exceptions\MethodTypeError(['handle' , $middleware , 'public']);
            }

            $result = $tmp_obj->handle(new Request);
            if($result !== false){
                die($result);
            }
        }
    }
}
