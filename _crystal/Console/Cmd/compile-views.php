<?php

namespace Crystal\Console\Cmd;

class compile_views{
	public function handle($args){
		\Crystal\View\CViewCompiler::compile_views();
		return 'all of views compiled';
	}
}
