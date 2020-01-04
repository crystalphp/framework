<?php

namespace Crystal\Utilities;

use Crystal\Utilities\Session;

class Auth{

	private static $user_cache = null;

	public static function login(\Models\User $user){
		Session::set('login' , $user->id);
		die(Session::get('login'));
	}

	public static function logout(){
		static::$user_cache = null;
		Session::remove('login');
	}

	public static function user(){
		if(static::$user_cache == null){
			static::$user_cache = \Models\User::find(Session::get('login'));
		}

		return static::$user_cache;
	}

	public static function id(){
		return Session::get('login');
	}
}
