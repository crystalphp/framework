<?php

namespace Crystal\Forms;

use Crystal\Utilities\Session;
use Crystal\Utilities\Hash;
use Crystal\App\app;

class Csrf{
	public static function generate(){
		$string = '';
		$string .= Session::get(app::get_config('app_name') . '_session');
		$string .= app::get_config('app_name');
		$string .= CRYSTAL_START_TIME;
		$string .= time();
		$string .= rand();
		$hash = Hash::sha256($string);
		$hash .= Hash::sha256($string . $string);

		return Hash::sha256($hash);
	}

	public static function validate($csrf){
		return Session::get('csrf_token') == $csrf;
	}
}
