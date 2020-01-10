<?php

namespace App;

use Exceptions\BaseException;

class ExceptionHandler{
	public function handle(BaseException $ex){
		return $ex->render();
	}
}
