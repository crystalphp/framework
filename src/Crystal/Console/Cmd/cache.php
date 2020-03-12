<?php

namespace Crystal\Console\Cmd;

class cache{
    private $index_msg = 'cache manager:
cache list  : show list of cache items
cache clear : clear all of cache items';
	public function handle($args){
        if(!isset($args[0])){
            return $this->index_msg;
        }

        if($args[0] == 'clear'){
        }

        if($args[0] == 'list'){
            $all = cache()->all();
            print "--------------------------------------
";
            print "| Name       | Type      | Size      |
--------------------------------------
";
            foreach($all as $key => $one){
                // TODO : get type and size of object in here
                $name = $key;
                $type = 'native';
                $size = 'size';
                echo "| {$name}        | {$type}       | {$size}       |
";
            }
        }
	}		
}
