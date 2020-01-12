<?php

include_once libs('/Controllers/Controller.php');
$controllers = glob(app_path('/controllers/*.php'));
foreach($controllers as $controller){
    if(is_file($controller)){
        include_once $controller;
    }
}
