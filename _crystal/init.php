<?php


function app_path($path=''){
    return APP_PATH . $path;
}

function libs($path=''){
    return app_path('/_crystal' . $path);
}


define('CRYSTAL_START_TIME' , microtime());


include_once libs('/Boot/bootloader.php');




