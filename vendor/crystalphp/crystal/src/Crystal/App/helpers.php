<?php

use Crystal\App\app;
use Crystal\Http\Response;
use Crystal\Http\Request;
use Crystal\Utilities\Session;
use Crystal\View\View;
use Crystal\Ajax\Ajax;


function ajax($name , $data_need){
    $data_js = '{';
    foreach($data_need as $key => $value){
        $data_js .= $key . ': ' . "$('{$value}').val() , ";
    }
    $data_js .= 'dsdsdsf:0';
    $data_js .= '}';
    return "ajax('{$name}' , {$data_js})";
}

function form_render($str , $attributes=''){
    $str = explode('@', $str);
    $frm = '\Forms\\' . $str[0];
    return $frm::render($str[1] , $attributes);
}

function view($name, $data = [] , $include=false){
    return View::make($name , $data , $include);
}

function vu($name , $data=[]){
    return view($name , $data , true);
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

function get_csrf_token(){
    $csrf = Session::get('csrf_token');
    return '<input type="hidden" name="csrf_token" value="'.$csrf.'" />';
}



function make_error($message , $file=null , $line=null){
    die($message);
}





function redirect($to){
    header('Location: ' . $to);
    return null;
}




function httpcode($code){
    return Response::httpcode($code);
}


function request(){
    return new Request;
}

function response(){
    return new Response;
}

function session(){
    return new \Crystal\Utilities\Session;
}

function auth(){
    return new \Crystal\Utilities\Auth;
}

function db(){
    return new \Crystal\Database\DB;
}

function chash(){
    return new \Crystal\Utilities\Hash;
}

function cfile(){
    return new \Crystal\Utilities\File;
}
