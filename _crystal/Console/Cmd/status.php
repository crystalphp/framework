<?php

namespace Crystal\Console\Cmd;

class status{
	public function handle($args){

		$f = fopen(app_path('/.env'), 'r');
		$content = fread($f , filesize(app_path('/.env')) + 1);
	
		$lines = explode('
', $content);
	
		$status = null;
	
		for($i = 0; $i < count($lines); $i++){
			if(substr($lines[$i], 0 , 11) == 'APP_STATUS='){
				$status = explode('=', $lines[$i]);
				$status = $status[1];
			}
		}
	
	
		if($status == 'up' || $status == 'down'){
	
		}else{
			$status = 'down';
		}
	
		return $status;
	
	}
}


