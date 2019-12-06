<?php

class app{
    public static function controller($action , $middlewares=[])
    {
        $action = explode('@' , $action);
        Middleware::call_list($middlewares);
        $controller_obj = new $action[0];
        $func_name = $action[1];
        echo $controller_obj->$func_name(new Request);
    }

    public static function get_config($key=null)
    {
        $configs = require app_path('/app/config.php');
        if($key !== null){
            return $configs[$key];
        }
        return $configs;
    }

    public static function view($name, $data = null)
    {
        $name = str_replace('.' , '/' , $name);
        include app_path('/views/' . $name . '.cv.php');
        return '';
    }
}

function view($name, $data = null){
    return app::view($name , $data);
}

function vu($name , $data=null){
    view($name , $data);
}



