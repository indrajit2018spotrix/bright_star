<?php

	namespace config;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class manifest{

		public static function system_manifest(){

			return	[
						"_-_-_app_-_-_"						=>	"Bright Star",
						"_-_-_BASE_PATH_-_-_"				=>	"/isg/chatroom",
						"_-_-_DOCUMENT_ROOT_-_-_"			=>	getcwd(),
						"_-_-_HTTP_Port_-_-_"				=>	"80",
						"_-_-_PHP_version_-_-_"				=>	"7.2.1",
						"_-_-_SERVER_PROTOCOL_-_-_"			=>	"HTTP/1.1",
						"_-_-_timezone_-_-_"				=>	"Asia/Kolkata",
						"_-_-_language_-_-_"				=>	"English",
						"_-_-_log_file_extension_-_-_"		=>	".vortex",
						"_-_-_delete_previous_logs_-_-_"	=>	true
			];

		}

	}

?>