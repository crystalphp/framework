<?php

namespace Crystal\Console;

class Kernel{
	public function handle($argv){
		$commands = glob(libs('/Console/Cmd/*.php'));
		foreach($commands as $command){
			include_once $command;
		}


        $args = static::rm_first_arg($argv);



        if(!isset($args[0])){
            return static::cmd_index() . '
';
        }


        $cmd = $args[0];
        $cmd = str_replace('-' , '_' , $cmd);

        $cmd_class = '\Crystal\Console\Cmd\\' . $cmd;

        if( ! class_exists($cmd_class)){
        	return static::cmd_not_found($args) . '
';
        }

        $cmd_obj = new $cmd_class;

        return $cmd_obj->handle(static::rm_first_arg($args)) . '
';
    }



    private static function cmd_index(){
        return 'For Show help of commands type "php crystal help"

MIT License
    
Copyright (c) 2020 parsa mpsh <parsa84sh1384@gmail.com> as <crystalphp.com>
    
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
    
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.';
    }







    private static function cmd_not_found($inserted_args){
        return 'Crystal: Command "'.$inserted_args[0].'" Not Found';
    }




    private static function rm_first_arg($a){
        $args = [];
        for ($i=1; $i < count($a); $i++) { 
            array_push($args, $a[$i]);
        }
        return $args;
    }
}
