<?php

namespace Exceptions;

use Crystal\Utilities\File;
use Crystal\Utilities\Str;

class BaseException extends \Exception{
	protected $message;
	protected $file;
	protected $code_line;
	protected $ex_name;

	private $render_output_cache = null;


	protected function handle($message , $file=null , $code_line=null){
		$ex_name = static::class;
		$ex_name = explode('\\', $ex_name);
		$ex_name = $ex_name[count($ex_name) - 1];
		
		$this->ex_name = $ex_name;
		$this->message = $message;
		$this->file = $file;
		$this->code_line = $code_line;

		$ex_handler = new \App\ExceptionHandler;
		echo $ex_handler->handle($this);
		$ex_handler->report($this);
		die();
	}


	public function render(){
		ob_start();
		make_exception_render($this->ex_name , $this->message , $this->file , $this->code_line);
		$this->render_output_cache = ob_get_clean();
		return $this->render_output_cache;
	}


	public function report(\Closure $func=null){
		$do = true;
		if(is_a($func, '\Closure')){
			$do = call_user_func_array($func, [$this]);
		}

		if( ! $do){
			return;
		}


		// report the exception: create that as file in storage/error_reports
		$name = date('Y-m-d') . '__' . time() . '__' . $this->ex_name;

		if($this->render_output_cache === null){
			$this->render_output_cache = $this->render();
		}

		File::create(app_path('/storage/error-reports/' . $name . '.html') , $this->render_output_cache);
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
