<?php

namespace Crystal\Utilities;

use Crystal\Utilities\Session;
use Crystal\Http\Cookie;
use Crystal\Utilities\Hash;

class Auth{

	private static $user_cache = null;

	public static function login(\Models\User $user , $remember=false){
		Session::set('login' , $user->id);

		if($remember){
			$str = '';
			$str .= $user->id;
			$str .= rand();
			$str .= time();
			$str .= microtime();
			$str .= $str;
			$str = Hash::sha256($str);
			$str .= Hash::sha256($str . $str);
			$str .= Hash::sha256($str . $str);

			$user->remember_token = $str;
			Cookie::set('remember_login' , $str , 63072000);
			$user->save();
		}
	}

	public static function logout(){
		static::$user_cache = null;
		Session::remove('login');
		Cookie::remove('remember_login');
	}

	public static function user(){
		if(static::$user_cache == null){
			static::$user_cache = \Models\User::find(Session::get('login'));
			if(static::$user_cache === null){
				$rl = Cookie::get('remember_login');
				$u = \Models\User::where('remember_token' , $rl)->first();
				if($u != null){
					Session::get('login' , $u->id);
					return static::user();
				}
			}
		}

		return static::$user_cache;
	}

	public static function id(){
		return Session::get('login');
	}
}
