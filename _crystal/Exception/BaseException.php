<?php

namespace Exceptions;

use Crystal\Utilities\File;
use Crystal\Utilities\Str;

class BaseException extends \Exception{
	protected $message;
	protected $file;
	protected $code_line;
	protected $ex_name;


	protected function handle($message , $file=null , $code_line=null){
		$ex_name = static::class;
		$ex_name = explode('\\', $ex_name);
		$ex_name = $ex_name[count($ex_name) - 1];
		
		$this->ex_name = $ex_name;
		$this->message = $message;
		$this->file = $file;
		$this->code_line = $code_line;

		$ex_handler = new \App\ExceptionHandler;
		die($ex_handler->handle($this));
	}


	public function render(){
		ob_start();
		make_exception_render($this->ex_name , $this->message , $this->file , $this->code_line);
		return ob_get_clean();
	}


	public function get_line_contains($file , $code , $human_readable=false){
		$content = File::read($file);
		$lines = Str::get_list_from_string($content , false);
		$number = null;
		for($i = 0; $i < count($lines); $i++){
			if(strpos($lines[$i] , $code)){
				$number = $i;
			}
		}

		if($human_readable){
			$number += 1;
		}
		return $number;
	}


	public function message(){
		return $this->__toString();
	}
}
