<?php





function cmd_run($args){
	include_once libs('/init.php');
	\Crystal\App\CViewCompiler::compile_views();
	echo 'all of views compiled';
}
