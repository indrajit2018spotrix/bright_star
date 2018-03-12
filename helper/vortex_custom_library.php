<?php

	namespace helper;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_custom_library{

		public static function save_log($this_file_name, $logFile_name, $signature, $start_time, $end_time){

			$doc_root = env('DOC_ROOT','');
			$cron_log_folder =  $doc_root . "/storage/cron_logs/";
			$cron_log_file = $doc_root . "/storage/cron_logs/" . $logFile_name;

			if(!file_exists($cron_log_folder))
				mkdir($cron_log_folder, 0777, true);

	    	if(!file_exists($cron_log_file))
	    		fopen($cron_log_file, 'w');

	    	$log_content = $this_file_name . " #### " . $signature . " #### " . $start_time . " #### " . $end_time . "\n";

			file_put_contents($cron_log_file, $log_content, FILE_APPEND | LOCK_EX);

		}

	}

?>