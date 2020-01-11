<?php

use Crystal\App\AppEventListener;

// use AppEventListener class to set some application events

AppEventListener::on_error_404(function(){
	echo httpcode(404);
});
