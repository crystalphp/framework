<?php

namespace Middlewares;

use Crystal\Middlewares\Middleware;
use Crystal\Http\Request;

use Crystal\Forms\Csrf;

class ValidateCsrfToken extends Middleware
{
	public function handle(Request $r){
		if($r->requestMethod() == 'POST'){
			if( ! Csrf::validate($r->post('csrf_token'))){
				return httpcode(419);
			}
		}

		return false; // don't delete this line
	}
}
