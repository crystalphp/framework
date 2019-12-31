<?php

function cmd_run($args){



$public = APP_PATH . '/public';
$port = '8000';
if(isset($args[0])){
	$port = $args[0];
}
echo 'crystal server started on http://localhost:' . $port;
system('cd "' . $public . '";' . 'php -S localhost:' . $port);




}
