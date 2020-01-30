<?php

namespace App\Providers;

use Crystal\App\Provider;
use Crystal\Ajax\Ajax as A;

class Ajax extends Provider{
	public function boot(){
        A::make('login' , function($handler){
            if($handler->data(0) == 'parsa' && $handler->data(1) == '123'){
                return $handler->redirect('/profile');
            }

            return $handler->elementset('#name' , ['css:background-color' => 'red']);

            return $handler->alert('invalid username or passsword');
        });
	}
}
