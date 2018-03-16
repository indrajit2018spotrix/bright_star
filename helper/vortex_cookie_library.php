<?php

	namespace helper;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_cookie_library{

		public static function cookie_flush($var_val_array){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){

				if(isset($_COOKIE["_-_-_cookie_flush_-_-_"])){
					foreach($_COOKIE["_-_-_cookie_flush_-_-_"] as $key=>$val){
						$data[$key] = $val;
					}
				}

				foreach($var_val_array as $key=>$val){
					$data[$key] = $val;
				}

				setcookie('_-_-_cookie_flush_-_-_', $data, time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				return true;
			}
			else
				return false;
		}

		public static function get_flush_value($variable){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				if(isset($_COOKIE["_-_-_cookie_flush_-_-_"])){
					if(isset($_COOKIE["_-_-_cookie_flush_-_-_"][$variable])){
						vortex_cookie_library::destroy_flush_variable($variable);
						setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
						return $_COOKIE["_-_-_cookie_flush_-_-_"][$variable];
					}
					else
						return null;
				}
				else
					return null;
			}
			else
				return null;
		}

		public static function destroy_flush_variable($variable){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				if(isset($_COOKIE["_-_-_cookie_flush_-_-_"])){
					if(isset($_COOKIE["_-_-_cookie_flush_-_-_"][$variable]))
						unset($_COOKIE["_-_-_cookie_flush_-_-_"][$variable]);
				}
			}

			return true;
		}

		public static function cookie_init($push_data){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_']))
				vortex_cookie_library::destroy_cookies();

			$data_string = uniqid('jgu38fr9cftj34ct7t8fcr894', true)."".time()."".date("YMHmhisaugG")."".rand(100000, 999999);
			foreach($push_data as $key=>$val){
				$data_string .= $val;
			}

			$uniqid = sha1(str_shuffle($data_string));
			setcookie("_-_-_vortex_cookie_id_-_-_", $uniqid, time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);

			foreach($push_data as $key=>$val){
				setcookie($key, $val, time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
			}

			return true;
		}

		public static function cookie_push($var_array){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				foreach($var_array as $key=>$val){
					setcookie($key, $val, time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				}
				setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				return true;
			}
			else
				return false;
		}

		public static function cookie_pop($key_array){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				foreach($key_array as $key=>$val){
					if(isset($_COOKIE[$key]))
						unset($_COOKIE[$key]);
				}
				setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				return true;
			}
			else
				return false;
		}

		public static function destroy_cookies(){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				unset($_COOKIE);
	    	}

	    	return true;
		}

		public static function get_cookie_ID(){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_']))
				return $_COOKIE['_-_-_vortex_cookie_id_-_-_'];
	    	else
	    		return null;
		}

		public static function modify_cookie_data($modified_data_array){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				foreach($modified_data_array as $key=>$val){
					setcookie($key, $val, time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				}
				setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);
				return true;
			}
			else
				return false;
		}

		public static function get_all_cookie_data(){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				$data = array();
				foreach($_COOKIE as $key=>$val){
					if($key!='_-_-_vortex_cookie_id_-_-_' && $key!='_-_-_cookie_flush_-_-_')
						$data[$key] = $val;
				}

				setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);

				return $data;
			}
			else
				return null;
		}

		public static function get_cookie_data($variable){
			if(isset($_COOKIE['_-_-_vortex_cookie_id_-_-_'])){
				setcookie("_-_-_vortex_cookie_id_-_-_", $_COOKIE['_-_-_vortex_cookie_id_-_-_'], time()+$GLOBALS['_-_-_manifest_-_-_']['_-_-_COOKIE_expiration_time_-_-_']);

				if(isset($_COOKIE[$variable]))
					return $_COOKIE[$variable];
				else
					return null;
			}
			else
				return null;
		}
		
	}

?>