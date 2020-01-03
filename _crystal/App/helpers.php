<?php

use Crystal\App\app;
use Crystal\Http\Response;

function form_render($str , $attributes=''){
    $str = explode('@', $str);
    $frm = '\Forms\\' . $str[0];
    return $frm::render($str[1] , $attributes);
}

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



function httpcode($code){
    return Response::httpcode($code);
}

