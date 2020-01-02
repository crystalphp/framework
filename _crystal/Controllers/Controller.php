<?php

namespace Crystal\Controllers;

use Crystal\Middlewares\Middleware;

class Controller{

	public function middleware($middleware_s){
		if(is_string($middleware_s)){
			Middleware::call_list([$middleware_s]);
		}else if(is_array($middleware_s)){
			Middleware::call_list($middleware_s);
		}
	}

}
