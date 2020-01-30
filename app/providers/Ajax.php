<?php

namespace App\Providers;

use Crystal\App\Provider;
use Crystal\Ajax\Ajax as A;

class Ajax extends Provider{
	public function boot(){
        A::make('btn_click' , function($handler){
            return $handler->alert('the new username ' . $handler->data[0] . ' registered');
        });
	}
}
