<?php

namespace Crystal\View;

use Crystal\App\app;
use Crystal\Utilities\Hash;

class CViewCompiler{
	public static function compile_views(){
    	$files = \Crystal\Utilities\File::get_directory_tree(app_path('/views'));
    	$first_length = strlen(app_path('/views/'));
		
		if( ! is_dir(app_path('/storage/viewcache/'))){
			mkdir(app_path('/storage/viewcache/'));
		}

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
		$tmp_name = Hash::sha256($tmp_name) . '.php';
    	$content = static::format_content($content);
    	$target = fopen(app_path('/storage/viewcache/' . $tmp_name), 'w');
    	fwrite($target, $content);
    	fclose($target);
	}

	private static function format_content($content){

        $random_key = '<' . app::env('APP_NAME') . rand() . time() . 'toreplaceat' . '>';
        while(strpos($content, $random_key)){
            $random_key .= time() . '>';
        }
        $content = str_replace('\@', $random_key, $content);

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

        $content = str_replace('@if(', '<?php if(', $content);
        $content = str_replace('@else', '<?php else: ?>', $content);
        $content = str_replace('@endif', '<?php endif; ?>', $content);

        $content = str_replace('{{', '<?= htmlspecialchars(', $content);
        $content = str_replace('}}', ') ?>', $content);

        $content = str_replace('{!', '<?= ', $content);
        $content = str_replace('!}', ' ?>', $content);

        $content = str_replace('@vu(', '<?php vu(', $content);

        $content = str_replace('@fr(', '<?= form_render(', $content);

        $content = str_replace('@use(', '<?php use ', $content);

        $content = str_replace(');@', '; ?>', $content);

        $content = str_replace('<@', '<?php', $content);
        $content = str_replace('@>', '?>', $content);

        $content = str_replace('@csrf', '<?= get_csrf_token() ?>', $content);





        $content = str_replace($random_key, '@', $content);

		return $content;
	}
}
