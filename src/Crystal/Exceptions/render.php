<?php
use Crystal\App\app;
function make_exception_render($ex_name , $message , $file , $code_line=null){
	if(app::get_config('app')['app_debug'] != 'true'){
		echo httpcode(500);
		return;
	}
	if($_SERVER['REQUEST_METHOD'] == 'console'){
		return $ex_name . ':
' . $message . '
' . $file . ':' . $code_line . '
';
	}

	$content = \Crystal\Utilities\File::read($file);
	$lines = \Crystal\Utilities\Str::get_list_from_string($content , false);
	$line_number_space = count($lines);
	$line_number_space = (string) $line_number_space;
	$line_number_space = strlen($line_number_space);
	
	$lns = ' ';
	for($i = 0; $i < $line_number_space; $i++){
		$lns .= ' ';
	}
?>
<title><?= $message . ' : ' . $ex_name ?></title>
<style>
	*{
		padding: 0;
		margin: 0;
	}

	body{
		background-color: black;
	}

	@font-face{
		font-family: mono-space;
		src: url('https://www.fontsquirrel.com/fonts/download/Bitstream-Vera-Sans-Mono');
	}

	.current-line{
		display: inline-block;
		background-color: rgb(150,100,100);
	}

	.line-num{
		padding: 0 5px;
		font-weight: bold;
	}

	header{
		position: relative;
		background-color: rgb(180,90,90);
		padding: 30px;
	}

	header a{
		text-decoration: none;
		color: rgb(18,9,9);
		position: absolute;
		top: 10px;
		right:10px;
	}

	header a:hover{
		color: rgb(64,32,32);
	}
</style>

<header>
	<a href="http://crystalphp.com">crystalphp.com</a>
	<h2><?= $ex_name ?></h2>
	<div><?= $message ?></div>
	<div>in <?= $file ?>:<?= $code_line + 1 ?></div>
</header>

<pre style="margin-top: 10px; margin-left: 30px; overflow: auto; padding: 30px; padding-left: 5px; border-left: solid 1px #fff; background-color: black; color: #fff; font-family: mono-space !important;"><?php 
for($i = 0; $i < count($lines); $i++){
	$line = htmlspecialchars($lines[$i]);
	if($i == $code_line){
		$line = '<div class="current-line">' . $line . '</div>';
	}

	$line = '<span class="line-num">'.($i+1).$lns.'</span>' . $line . '
';

	echo $line;
}
?></pre>


<?php } ?>
