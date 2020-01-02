<?php

$ex_s = glob(libs('/Exception/*.php'));
foreach($ex_s as $ex){
	if(basename($ex) != 'include.php'){
		include_once $ex;
	}
}
