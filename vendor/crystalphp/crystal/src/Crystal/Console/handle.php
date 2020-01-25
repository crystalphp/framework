<?php

function app_path($path=null){
	return APP_PATH . $path;
}
function libs($path){
	return APP_PATH . '/vendor/crystalphp/crystal/src/Crystal' . $path;
}

$_SERVER['REQUEST_METHOD'] = 'console';
$_SERVER['HTTP_HOST'] = 'localhost';

include app_path('/vendor/autoload.php');
\Crystal\Boot\Bootloader::boot();

$app = new \Crystal\Console\Kernel;
echo $app->handle($argv) . '
';
