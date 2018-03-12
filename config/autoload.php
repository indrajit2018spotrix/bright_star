<?php

	use config\vortex\view;
	use helper\vortex_log_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	function parsing_ERROR($output){
		$handler['message'] = $output;
		$log_message = $handler['message'];
		vortex_log_library::generate_log_record($log_message);
		$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;
		$view_OBJ = new view();
		return $view_OBJ->render_view("app/500", $handler);
	}

	spl_autoload_register(function($class){

		$prefix = '';

		$length = strlen($prefix);

		$base_directory = '';

		if(strncmp($prefix, $class, $length) !== 0){
			return;
		}

		$relative_class = substr($class, $length);

		$file = $base_directory . str_replace('\\', '/', $relative_class) . '.php';

		if(file_exists($file)){
			$file_verified = 0;
			foreach($GLOBALS['_-_-_fileread_record_-_-_'] as $key=>$val){
				if($key == $file){
					if($val == 1){
						$file_verified = 1;
						break;
					}
				}
			}
			if($file_verified == 0){
				$output = shell_exec('php -l ' . $file);
				$output_array = explode(' in ', $output);
				if($output_array[0] != "No syntax errors detected"){
					$GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_modified_-_-_'] = true;
					$GLOBALS['_-_-_fileread_record_-_-_'][$file] = false;
					$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;
					$app = parsing_ERROR($output);
				}
				else{
					$GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_modified_-_-_'] = true;
					$GLOBALS['_-_-_fileread_record_-_-_'][$file] = true;
				}
			}
		}

		if(file_exists($file)){
			require $file;
		}

	});

?>