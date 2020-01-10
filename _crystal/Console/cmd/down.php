<?php

function cmd_run($args){

	$f = fopen(app_path('/.env'), 'r');
	$content = fread($f , filesize(app_path('/.env')) + 1);

	$lines = explode('
', $content);



	for($i = 0; $i < count($lines); $i++){
		if(substr($lines[$i], 0 , 11) == 'APP_STATUS='){
			$lines[$i] = 'APP_STATUS=down';
		}
	}



	$new_content = '';

	foreach($lines as $line){
		$new_content .= $line . '
';
	}
	$new_content = substr($new_content, 0 , strlen($new_content) - 1);

	$f = fopen(app_path('/.env'), 'w');
	fwrite($f, $new_content);


}
