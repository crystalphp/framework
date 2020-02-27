<?php

namespace Crystal\Console\Cmd;

class version{
	public function handle($args){
        $composer_json_contents = cfile()->read(app_path('/composer.json'));
        $composer_json_contents = json_decode($composer_json_contents);
        $version = $composer_json_contents->require->{"crystalphp/framework"};
        $version = str_replace('^' , '' , $version);
        return "You project crystal framework version is {$version}";
	}
}
