<?php

	namespace config\vortex;
	use app\Exceptions\Handler;
	use app\Exceptions\Handler_Channel;
	use helper\vortex_log_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class view{

		public function render_view($view, $vars){

			$GLOBALS['_-_-_viewported_-_-_'] = true;

			if(isset($vars[0]))
				$compact = $vars[0];
			else
				$compact = $vars;

			$handler = Handler::clause_tunnel();
			$file_exists = 1;

			if(isset($handler['error'])){
				unset($compact);
				if(file_exists($GLOBALS['_-_-_path_-_-_']['_-_-_resource_-_-_'] . $GLOBALS['_-_-_path_-_-_']['_-_-_app_blade_-_-_']['_-_-_500_-_-_'] . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php")){
					$compact = $handler;
					$log_message = $compact['type'] . " <------> " . $compact['file'] . " <------> " . $compact['line'] . " <------> " . $compact['message'];
					vortex_log_library::generate_log_record($log_message);
					$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;
					return require_once $GLOBALS['_-_-_path_-_-_']['_-_-_resource_-_-_'] . $GLOBALS['_-_-_path_-_-_']['_-_-_app_blade_-_-_']['_-_-_500_-_-_'] . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php";
				}
				else{
					$compact['message'] = "<i><u>" . $GLOBALS['_-_-_path_-_-_']['_-_-_app_blade_-_-_']['_-_-_500_-_-_'] . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php</u></i> doesn't exist.";
					$file_exists = 0;
				}
			}
			else{
				if(file_exists($GLOBALS['_-_-_path_-_-_']['_-_-_resource_-_-_'] . $view . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php")){
					return Handler_Channel::channelize_view($GLOBALS['_-_-_path_-_-_']['_-_-_resource_-_-_'] . $view . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php", $compact);
				}
				else{
					unset($compact);
					$compact['message'] = "<i><u>" . $view . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php</u></i> doesn't exist.";
					$file_exists = 0;
				}
			}

			if($file_exists == 0){
				$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;
				if(file_exists($GLOBALS['_-_-_path_-_-_']['_-_-_resource_-_-_'] . $GLOBALS['_-_-_path_-_-_']['_-_-_app_blade_-_-_']['_-_-_404_-_-_'] . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php")){
					$log_message = $compact['message'];
					vortex_log_library::generate_log_record($log_message);
					return require_once $GLOBALS['_-_-_path_-_-_']['_-_-_resource_-_-_'] . $GLOBALS['_-_-_path_-_-_']['_-_-_app_blade_-_-_']['_-_-_404_-_-_'] . "." . $GLOBALS['_-_-_resource_type_-_-_'] . ".php";
				}
				else{
					$log_message = "Framework resources missing.";
					vortex_log_library::generate_log_record($log_message);
					return $log_message;
				}
			}

		}

	}

?>