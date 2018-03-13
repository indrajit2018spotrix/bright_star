<?php

	namespace helper;
	session_start();

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_session_library{

		public static function session_flush($variable, $value){
			$_SESSION['_-_-_vortex_flush_-_-_'][$variable] = $value;
		}

		public static function get_flush_variable($variable){
			if(isset($_SESSION['_-_-_vortex_flush_-_-_'][$variable])){
				$flush_variable = $_SESSION['_-_-_vortex_flush_-_-_'][$variable];
				vortex_session_library::destroy_flush_variable($variable);
				return $flush_variable;
			}
			else
				return null;
		}

		public static function destroy_flush_variable($variable){
			unset($_SESSION['_-_-_vortex_flush_-_-_'][$variable]);
			return true;
		}
		
	}
