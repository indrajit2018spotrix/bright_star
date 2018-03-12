<?php

	namespace config\vortex;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class Host_Config{

		public static function batch(){
			$batch_array = parse_ini_file($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_batch_ini_-_-_'], true);
			return $batch_array;
		}

	}

?>