<?php

include_once libs('/Middlewares/Middleware.php');
$middlewares = glob(app_path('/middlewares/*.php'));
foreach($middlewares as $middleware){
    if(is_file($middleware)){
        include_once $middleware;
    }
}
