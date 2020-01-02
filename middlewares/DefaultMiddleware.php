<?php

namespace Middlewares;

use Crystal\Middlewares\Middleware;
use Crystal\Http\Request;

class DefaultMiddleware extends Middleware
{
	public function handle(Request $r){

		// write your codes and conditions check here...

		return false; // don't delete this line
	}
}
