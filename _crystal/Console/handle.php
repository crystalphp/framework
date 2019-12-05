<?php



function cmd_index(){
	die('
help:
');
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

