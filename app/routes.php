<?php

// use $router variable for create routes.

$router->any('/' , function(){
	return view('hello');
});
