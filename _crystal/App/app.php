<?php

namespace Crystal\App;

use Crystal\middlewares\Middleware;
use Crystal\Http\Request;


class app{
    public static function controller($action , $middlewares=[] , $params=[])
    {
        $action = explode('@' , $action);
        Middleware::call_list($middlewares);
        $action[0] = '\Controllers\\' . $action[0];
        $controller_obj = new $action[0];
        $func_name = $action[1];
        $req = new Request;
        echo call_user_func_array([$controller_obj , $func_name], [$req , $params]);
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
        $path = app_path('/storage/viewcache/' . $name . '.cv.php');
        include $path;
        return '';
    }

    public function env($key , $default=null){
        $result = KEVRender::render_by_file(app_path('/.env'));
        if(isset($result[$key])){
            return $result[$key];
        }else{
            return $default;
        }
    }
}

define('APP_URL' , str_replace('{servername}' , $_SERVER['SERVER_NAME'] , app::get_config('app_url'))); 









