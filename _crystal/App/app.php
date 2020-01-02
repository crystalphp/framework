<?php

class app{
    public static function controller($action , $middlewares=[] , $params=[])
    {
        $action = explode('@' , $action);
        Middleware::call_list($middlewares);
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
        $path = app_path('/resources/viewcache/' . $name . '.cv.php');
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

function view($name, $data = null){
    return app::view($name , $data);
}

function vu($name , $data=null){
    return view($name , $data);
}

function url($url=''){
    if(strlen($url) > 1){
        if($url[0] != '/'){
            $url = '/' . $url;
        }
    }
    return APP_URL . $url;
}


function env($key , $default=null){
    return app::env($key , $default);
}

function public_path($path=null){
    return PUBLIC_PATH . $path;
}




function make_error($message , $file=null , $line=null){
    die($message);
}





function redirect($to){
    header('Location: ' . $to);
    return null;
}




function get_directory_tree($path , $files=[]){
    $tmp = glob($path . '/*');
    foreach($tmp as $t){
        if(is_file($t)){
            array_push($files, $t);
        }else if(is_dir($t)){
            array_push($files, $t);
            $files = get_directory_tree($t , $files);
        }
    }

    return $files;
}









