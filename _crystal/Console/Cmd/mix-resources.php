<?php

namespace Crystal\Console\Cmd;

class mix_resources{
	public function handle($args){

		$js = false;
		$css = false;
	
		if(isset($args[0])){
			if($args[0] == 'js'){
				$js = true;
			}else if($args[0] == 'css'){
				$css = true;
			}else{
				return'Unknow ' . $args[0] . '
';
			}
		}else{
			$js = true;
			$css = true;
		}
	
	
	
	
	
	
	
	
		if($js){
	
			$files = glob(app_path('/resources/js/*.js'));
			$content = '';
			foreach($files as $file){
				$f = fopen($file, 'r');
				$content .= fread($f, filesize($file)+1);
				fclose($f);
			}
			$content = $this->clean_content($content);
	
			$mixed_file = fopen(app_path('/public/js/scripts.js') , 'w');
			fwrite($mixed_file, $content);
			fclose($mixed_file);
	
		}
	
	
		if($css){
	
			$files = glob(app_path('/resources/css/*.css'));
			$content = '';
			foreach($files as $file){
				$f = fopen($file, 'r');
				$content .= fread($f, filesize($file)+1);
				fclose($f);
			}
			$content = $this->clean_content($content);
	
			$mixed_file = fopen(app_path('/public/css/styles.css') , 'w');
			fwrite($mixed_file, $content);
			fclose($mixed_file);
	
		}
	
	
	
	
	return '';
	}


	private function clean_content($content){

		$content = str_replace('	', '', $content);
		$content = str_replace('
	', '', $content);
	
		return $content;
	}
}











