<?php

	namespace helper;
	use helper\vortex_datetime_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_log_library{

		public static function generate_log_record($log_message){
			chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
			$log_file_name = vortex_datetime_library::current_time('date');
			$log_file_extension = $GLOBALS['_-_-_manifest_-_-_']['_-_-_log_file_extension_-_-_'];
			$log_folder = 'storage/logs/';

			$current_time = vortex_datetime_library::current_time('time_micro');

			if(!file_exists($log_folder))
	            mkdir($log_folder, 0777, true);
	        if(!file_exists($log_folder . "" . $log_file_name . "" . $log_file_extension)){
	        	$handle = fopen($log_folder . "" . $log_file_name . "" . $log_file_extension, 'w');
	        	fclose($handle);
	        }

	        $log_message = $current_time . " ###### " . $log_message . "\n\n";

	        if($GLOBALS['_-_-_manifest_-_-_']['_-_-_delete_previous_logs_-_-_']){
	        	$file_list = scandir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_'] . "/storage/logs/");
	        	foreach($file_list as $key=>$val){
	        		$file_name_ext = explode('.', $val);
	        		if(".".end($file_name_ext) == $GLOBALS['_-_-_manifest_-_-_']['_-_-_log_file_extension_-_-_']){
	        			if($file_name_ext[0] != $log_file_name){
	        				unlink($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_'] . "/storage/logs/" . $val);
	        			}
	        		}
	        	}
	        }

	        file_put_contents($log_folder . "" . $log_file_name . "" . $log_file_extension, $log_message, FILE_APPEND | LOCK_EX);
		}
		
	}

?>