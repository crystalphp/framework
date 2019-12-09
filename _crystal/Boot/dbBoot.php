<?php

include_once libs('/Database/Model.php');
include_once libs('/Database/Collection.php');
include_once libs('/Database/DB.php');
include_once libs('/Database/Connector.php');
$models = glob(app_path('/models/*.php'));
foreach($models as $model){
    if(is_file($model)){
        include_once $model;
    }
}



$db_conf = app::get_config('database');
if($db_conf['use_db']){
	$db_host = $db_conf['host'];
	$db_user = $db_conf['username'];
	$db_pass = $db_conf['password'];
	$db_name = $db_conf['name'];
	$result = DB::connect($db_host , $db_user , $db_pass , $db_name);
	if($result !== true){
		make_error($result);
	}
}
