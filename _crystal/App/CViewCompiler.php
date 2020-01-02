<?php

namespace Crystal\App;

class CViewCompiler{
	public static function compile_views(){
    	$files = get_directory_tree(app_path('/views'));
    	$first_length = strlen(app_path('/views/'));

    	$fs = [];
    	$dirs = [];

    	foreach($files as $file){
	        $f = $file;
        	$f = substr($f, $first_length);
        	if(is_file($file)){

            	static::compile_once_view($f);

        	}
    	}
    }


	private static function compile_once_view($name){
		$content = fread(fopen(app_path('/views/' . $name) , 'r') , filesize(app_path('/views/' . $name)) + 1);
    	$tmp_name = str_replace('/', '.', $name);
    	$content = static::format_content($content);
    	$target = fopen(app_path('/resources/viewcache/' . $tmp_name), 'w');
    	fwrite($target, $content);
    	fclose($target);
	}

	private static function format_content($content){

        $content = str_replace(')@', ') ?>', $content);
        $content = str_replace('@extends(', '<?php vu(', $content);

		$content = str_replace('@content', '<?php function vu_content($data){ ?>', $content);
		$content = str_replace('@endcontent', '<?php } ?>', $content);
		$content = str_replace('@rendercontent', '<?php vu_content($data); ?>', $content);

        $content = str_replace('@foreach(', '<?php foreach(', $content);
        $content = str_replace('@endforeach', '<?php endforeach; ?>', $content);
        $content = str_replace('):@', '): ?>', $content);


        $content = str_replace('@for(', '<?php for(', $content);
        $content = str_replace('@endfor', '<?php endfor; ?>', $content);

        $content = str_replace('{{', '<?= htmlspecialchars(', $content);
        $content = str_replace('}}', ') ?>', $content);

        $content = str_replace('@vu(', '<?php vu(', $content);

		return $content;
	}
}
