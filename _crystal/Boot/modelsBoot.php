<?php

include_once libs('/Models/Model.php');
include_once libs('/Models/Collection.php');
include_once libs('/Models/DB.php');
include_once libs('/Models/Connector.php');
$models = glob(app_path('/models/*.php'));
foreach($models as $model){
    if(is_file($model)){
        include_once $model;
    }
}


