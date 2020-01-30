<?php

namespace App\Providers;

use Crystal\App\Provider;
use Crystal\App\AppEventListener;

class Events extends Provider{
	public function boot(){
		// use AppEventListener class to set some application events

		AppEventListener::on_error_404(function(){
			return httpcode(404);
		});
	}
}
