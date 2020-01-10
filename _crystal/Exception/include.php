<?php

$ex_s = glob(libs('/Exception/Exceptions/*.php'));
include_once libs('/Exception/BaseException.php');
include_once libs('/Exception/render.php');
foreach($ex_s as $ex){
	if(is_file($ex)){
		include_once $ex;
	}
}
