<?php

	namespace helper;
	session_start();
	use helper\vortex_user_info_library;
	use helper\vortex_datetime_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_session_library{

		// MAKE FILE ONLY READABLE WITH SESSION TERMINATION

		public static function session_flush($variable, $value){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				$_SESSION['_-_-_vortex_flush_-_-_'][$variable] = $value;
				return true;
			}
			else
				return false;
		}

		public static function get_flush_variable($variable){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				if(isset($_SESSION['_-_-_vortex_flush_-_-_'][$variable])){
					$flush_variable = $_SESSION['_-_-_vortex_flush_-_-_'][$variable];
					vortex_session_library::destroy_flush_variable($variable);
					return $flush_variable;
				}
				else
					return null;
			}
			else
				return null;
		}

		public static function destroy_flush_variable($variable){
			unset($_SESSION['_-_-_vortex_flush_-_-_'][$variable]);
			return true;
		}

		public static function session_init($push_data){
			if(isset($_SESSION['_-_-_init_time_-_-_']))
				return false;
			else{
				$uid = session_id();
				session_unset();
				session_destroy();

				$user_IP = vortex_user_info_library::getRealIpAddr();

				$data_string = $uid . "" . $user_IP . "" . date('gsmMhHYuia') . "" . rand(100000, 999999);

				foreach($push_data as $key=>$val){
					$data_string .= $val;
				}

				$session_id = sha1(str_shuffle($data_string));
				session_id($session_id);
				session_start();
				$current_time = microtime(true);
				$_SESSION['_-_-_init_time_-_-_'] = $current_time;
				$_SESSION['_-_-_last_activation_time_-_-_'] = $current_time;

				$push_data['user_IP'] = $user_IP;

				if($GLOBALS['_-_-_manifest_-_-_']['_-_-_record_session_-_-_'])
					vortex_session_library::generate_session_record($session_id, $push_data);

				return true;
			}
		}

		public static function session_push($var_array){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				foreach($var_array as $key=>$val){
					$_SESSION[$key] = $val;
				}

				return true;
			}
			else
				return false;
		}

		public static function session_pop($key_array){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				foreach($key_array as $key){
					unset($_SESSION[$key]);
				}

				return true;
			}
			else
				return false;
		}

		public static function session_terminate(){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				$current_time = microtime(true);
				if($GLOBALS['_-_-_manifest_-_-_']['_-_-_record_session_-_-_']){
					vortex_session_library::modify_session_data([
						"session_end"	=>	$current_time,
						"termination_time"	=>	vortex_datetime_library::current_time('datetime_micro')
					]);
				}
				unset($_SESSION);
				session_unset();
	    		session_destroy();

	    	}

	    	return true;
		}

		public static function validate_session(){
			$current_time = microtime(true);
			$response = [
				"success"			=>	1,
				"session_valid"		=>	true
			];

			if(isset($_SESSION['_-_-_init_time_-_-_'])){

				if($GLOBALS['_-_-_manifest_-_-_']['_-_-_SESSION_auto_expiration_-_-_']){
					if($current_time-$_SESSION['_-_-_init_time_-_-_'] >= $GLOBALS['_-_-_manifest_-_-_']['_-_-_SESSION_expiration_time_-_-_']){
						vortex_session_library::session_terminate();

						$response = [
							"success"			=>	0,
							"session_valid"		=>	false
						];
					}
				}

				if($GLOBALS['_-_-_manifest_-_-_']['_-_-_SESSION_idle_expiration_-_-_']){
					if($current_time-$_SESSION['_-_-_last_activation_time_-_-_'] >= $GLOBALS['_-_-_manifest_-_-_']['_-_-_SESSION_idle_expiration_time_-_-_']){
						vortex_session_library::session_terminate();

						$response = [
							"success"			=>	0,
							"session_valid"		=>	false
						];
					}
				}

				if($response['success']==1 && $response['session_valid'])
					$_SESSION['_-_-_last_activation_time_-_-_'] = $current_time;
			}
			else{
				$response = [
					"success"			=>	0,
					"session_valid"		=>	false
				];
			}

			return $response;
		}

		public static function generate_session_record($session_id, $session_data){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				$session_file_name = vortex_datetime_library::current_time('date') . "_" . $session_id;
				$session_file_extension = $GLOBALS['_-_-_manifest_-_-_']['_-_-_session_file_extension_-_-_'];
				$session_folder = 'storage/session/';

				$current_time = vortex_datetime_library::current_time('time_micro');

				chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
				if(!file_exists($session_folder))
		            mkdir($session_folder, 0777, true);
		        if(!file_exists($session_folder . "" . $session_file_name . "" . $session_file_extension)){
		        	$handle = fopen($session_folder . "" . $session_file_name . "" . $session_file_extension, 'w');
		        	fclose($handle);
		        }

		        $data = parse_ini_file($session_folder . "" . $session_file_name . "" . $session_file_extension, true);

		        $session_string = "[".$session_id."]\n";
		        $session_string .= "session_start=".$_SESSION['_-_-_init_time_-_-_']."\n";
		        // $session_string .= "session_last_activated=".$_SESSION['_-_-_last_activation_time_-_-_']."\n";

		        foreach($session_data as $key=>$val){
		        	$session_string .= $key."=".$val."\n";
		        }

		        if($GLOBALS['_-_-_manifest_-_-_']['_-_-_fetch_user_info_-_-_']){
		        	$user_info = vortex_session_library::user_info();
		        	foreach($user_info as $key=>$val){
			        	$session_string .= $key."=".$val."\n";
			        }
		        }

		        $session_string .= "timezone"."=".vortex_datetime_library::get_DateTimeZone()."\n";
		        $session_string .= "start_time"."=".vortex_datetime_library::current_time('datetime_micro')."\n";

		        $session_string .= "\n\n";

		        $session_string = str_replace(";", "", $session_string);
		        $session_string = str_replace("(", "", $session_string);
		        $session_string = str_replace(")", "", $session_string);

		        file_put_contents($session_folder . "" . $session_file_name . "" . $session_file_extension, $session_string, LOCK_EX);

		        return true;

		    }
		    else
		    	return false;
		    
		}

		public static function get_session_ID(){
			$session_id = null;
			if(isset($_SESSION['_-_-_init_time_-_-_']))
				$session_id = session_id();

			return $session_id;
		}

		public static function modify_session_data($modified_data){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				$session_id = vortex_session_library::get_session_ID();
				$session_file_name = vortex_datetime_library::current_time('date') . "_" . $session_id;
				$session_file_extension = $GLOBALS['_-_-_manifest_-_-_']['_-_-_session_file_extension_-_-_'];
				$session_folder = 'storage/session/';
				$session_data = [];

				chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
				if(!file_exists($session_folder))
		            mkdir($session_folder, 0777, true);
		        if(!file_exists($session_folder . "" . $session_file_name . "" . $session_file_extension)){
		        	$handle = fopen($session_folder . "" . $session_file_name . "" . $session_file_extension, 'w');
		        	fclose($handle);
		        }

		        $data = parse_ini_file($session_folder . "" . $session_file_name . "" . $session_file_extension, true);
		        $session_id_found = 0;

		        foreach($data as $key=>$val){
		        	if($key == $session_id){
		        		$session_id_found = 1;

		        		foreach($val as $val_key=>$val_val){
		        			$index_data_found = 0;
		        			$index_data_count = 0;
		        			$key_val_array = [];
		        			foreach($modified_data as $modified_data_key=>$modified_data_val){
		        				$index_data_count++;
		        				$key_val_array = [
		        					"key"	=>	$modified_data_key,
		        					"val"	=>	$modified_data_val
		        				];
		        				if($val_key == $modified_data_key){
		        					$session_data[$val_key] = $modified_data_val;
		        					$index_data_found = 1;
		        					break;
		        				}
		        			}
		        			if($index_data_found==0 && $index_data_count>0){
	        					$session_data[$key_val_array['key']] = $key_val_array['val'];
	        				}
		        		}
		        	}

		        	if($session_id_found == 1)
		        		break;
		        }

		        if(sizeof($session_data) > 0){
		        	foreach($session_data as $key=>$val){
		        		$data[$session_id][$key] = $val;
		        	}
		        }

		        ksort($data[$session_id]);

		        $session_string = "[".$session_id."]\n";

		        foreach($data[$session_id] as $key=>$val){
		        	$session_string .= $key."=".$val."\n";
		        }

		        $session_string .= "\n\n";

		        $session_string = str_replace(";", "", $session_string);
		        $session_string = str_replace("(", "", $session_string);
		        $session_string = str_replace(")", "", $session_string);

		        file_put_contents($session_folder . "" . $session_file_name . "" . $session_file_extension, $session_string, LOCK_EX);

		        return true;
		    }
		    else
		    	return false;
		}

		public static function get_session_data($variable){
			if(isset($_SESSION['_-_-_init_time_-_-_'])){
				if(isset($_SESSION[$variable]))
					return $_SESSION[$variable];
				else
					return null;
			}
			else
				return null;
		}

		public static function user_info(){
			return vortex_user_info_library::get_user_info();
		}
		
	}

?>