<?php

namespace Crystal\Console\Cmd;

class version{
	public function handle($args){
		$version = 'v0.1';
	        return "You project crystal framework version is {$version}";
	}
}
