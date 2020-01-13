<?php

$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '8000';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REQUEST_METHOD'] = 'console';
$_SERVER['HTTP_HOST'] = 'localhost';
define('JUST_BOOTLOADERS' , true);

include app_path('/vendor/autoload.php');
\Crystal\Boot\Bootloader::boot();

function cmd_index(){
	echo 'MIT License

Copyright (c) 2020 parsa mpsh <parsa84sh1384@gmail.com> as <crystalphp.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
';
die();
}

function cmd_not_found($inserted_args){
	die('Crystal: Command "'.$inserted_args[0].'" Not Found
');
}



function rm_first_arg($a){
	$args = [];
	for ($i=1; $i < count($a); $i++) { 
		array_push($args, $a[$i]);
	}
	return $args;
}
$args = rm_first_arg($argv);


if(!isset($args[0])){
	cmd_index();
}




$cmd = libs('/Console/cmd/' . $args[0] . '.php');
if( ! is_file($cmd)){
	cmd_not_found($args);
}




include_once $cmd;

cmd_run(rm_first_arg($args));
die('
');

