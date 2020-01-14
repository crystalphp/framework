<?php

namespace Crystal\Console\Cmd;

class compile_views{
	public function handle($args){
		\Crystal\App\CViewCompiler::compile_views();
		return 'all of views compiled';
	}
}
