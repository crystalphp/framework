<?php

function load_once_plugin($plugname){
	$path = app_path('/plugins/' . $plugname);

	// read load list
	$f_ll = fopen($path . '/loadlist.lst', 'r');
	$loadlist = explode('
', fread($f_ll , filesize($path . '/loadlist.lst')+1));


	include_once $path . '/main.php';


	foreach($loadlist as $ll){
		$p = $path . '/src/' . $ll;
		if(is_file($p)){
			include_once $p;
		}
	}
}




//$plugins = glob(app_path('/plugins/*'));
//foreach($plugins as $plugin){
//	$pn_tmp = basename($plugin);
//	load_once_plugin($pn_tmp);
//}



