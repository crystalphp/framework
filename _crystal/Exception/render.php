<?php
function make_exception_render($ex_name , $message , $file , $code_line=null){
	$content = \Crystal\Utilities\File::read($file);
	$lines = \Crystal\Utilities\Str::get_list_from_string($content , false);
?>

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
</style>

<header style="background-color: rgb(200,100,200); padding: 30px;">
	<h2><?= $ex_name ?></h2>
	<div><?= $message ?></div>
	<div>in <?= $file ?>:<?= $code_line + 1 ?></div>
</header>

<pre style="margin-top: 10px; margin-left: 30px; overflow: auto; padding: 30px; padding-left: 5px; border-left: solid 1px #fff; background-color: black; color: #fff; font-family: mono-space !important;"><?php 
for($i = 0; $i < count($lines); $i++){
	$line = htmlspecialchars($lines[$i]);
	if($i == $code_line){
		$line = '<div class="current-line" style="display: inline-block; background-color: rgb(150,100,100);">' . $line . '</div>';
	}

	$line = '<span style="padding: 0 5px; font-weight: bold;">'.($i+1).'</span>' . $line . '
';

	echo $line;
}
?></pre>


<?php } ?>