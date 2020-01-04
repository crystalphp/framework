<?php

$files = glob(libs('/Utilities/*.php'));
foreach($files as $file){
	if(is_file($file)){
		include_once $file;
	}
}
