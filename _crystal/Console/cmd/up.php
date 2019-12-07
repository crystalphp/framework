<?php

function cmd_run($args){

	$f = fopen(app_path('/.env'), 'r');
	$content = fread($f , filesize(app_path('/.env')) + 1);

	$lines = explode('
', $content);



	for($i = 0; $i < count($lines); $i++){
		if(substr($lines[$i], 0 , 12) == 'STATUS_TYPE='){
			$lines[$i] = 'STATUS_TYPE=up';
		}
	}



	$new_content = '';

	foreach($lines as $line){
		$new_content .= $line . '
';
	}

	$f = fopen(app_path('/.env'), 'w');
	fwrite($f, $new_content);


}
