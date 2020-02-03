<?php

namespace Crystal\Console\Cmd;

class make{

	function handle($args){

		$items = [
			'controller',
			'model',
			'middleware',
			'form',
			'migration',
		];
		
		
		
		
		if( ! isset($args[0])){
			echo 'Make: With This command You Can create:
';
			foreach ($items as $item) {
				echo '	' . $item . '
';
			}
		
			echo '---------------------------
';
			echo 'for use this command write:
php crystal make <item-name>';
		
		
		
			return '';
		}
		
		
		
		
		if(in_array($args[0], $items)){
			
		
		
			if(isset($args[1])){
				$path = APP_PATH . '/'.$args[0].'s/' . $args[1] . '.php';
				if(file_exists($path)){
					return 'This '.$args[0].' Already is Exist.
';
				}else{
		
					$f = fopen($path , 'w');
					$ftemplate = fopen(libs('/Console/make_templates/' . $args[0] . '.php'), 'r');
					$content = fread($ftemplate , filesize(libs('/Console/make_templates/' . $args[0] . '.php')));
					$content = str_replace('ClassName', $args[1], $content);
		
					if($args[0] == 'model'){
						$tbl_name = strtolower($args[1]) . 's';
						$content = str_replace('TableName', $tbl_name, $content);
					}
		
					fwrite($f, $content);
		
					return $args[0].' Created Successfuly.
';
		
				}
			}else{
				return 'Parameter Name is required.
';
			}
		
		
		
		
		
		}else{
			echo 'unknow ' . $args[0] . ' for make
valid items:
';
		foreach ($items as $item) {
				echo '	' . $item . '
';
		}
		return '';
		}
		
		
		
		
		
		
		}
}


