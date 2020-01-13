<?php

if(is_file($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'])){
        return FALSE;
}

$app_path = dirname(__DIR__ , 1);

define('APP_PATH' , $app_path);
define('PUBLIC_PATH', __DIR__);
include_once APP_PATH . '/_crystal/init.php';
