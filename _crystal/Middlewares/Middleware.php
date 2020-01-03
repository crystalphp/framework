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
            $tmp_obj = new $middleware_n;
            $result = $tmp_obj->handle(new Request);
            if($result !== false){
                die($result);
            }
        }
    }
}
