<?php

namespace Crystal\Console\Cmd;

class start{
	public function handle($args){



		$public = APP_PATH . '/public';
		$port = '8000';
		if(isset($args[0])){
			$port = $args[0];
		}
		
		
		echo 'crystal server started on http://localhost:' . $port . '
';
		if(false){ // check is windows os
			$public = str_replace('/' , '\\' , $public);
			$command = str_replace('/' , '\\' , libs('/Console/start.bat')) . ' ' . $public;
			system($command);
		}else{
			$command = '$SHELL ' . libs('') . '/Console/start.sh ' . $public . ' ' . $port;
			system($command);
		}
		
		
		
		
		
		
	}
}
