<?php

	namespace config;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class manifest{

		public static function system_manifest(){

			return	[
						"_-_-_app_-_-_"								=>	"Bright Star",
						"_-_-_BASE_PATH_-_-_"						=>	"/isg/bright_star",
						"_-_-_DOCUMENT_ROOT_-_-_"					=>	getcwd(),
						"_-_-_HTTP_Port_-_-_"						=>	"80",
						"_-_-_PHP_version_-_-_"						=>	"7.2.1",
						"_-_-_SERVER_PROTOCOL_-_-_"					=>	"HTTP/1.1",
						"_-_-_timezone_-_-_"						=>	"Asia/Kolkata",
						"_-_-_language_-_-_"						=>	"English",
						"_-_-_log_file_extension_-_-_"				=>	".vortex",
						"_-_-_record_session_-_-_"					=>	true,
						"_-_-_session_file_extension_-_-_"			=>	".vortexession",
						"_-_-_delete_previous_logs_-_-_"			=>	false,
						"_-_-_SESSION_auto_expiration_-_-_"			=>	true,
						"_-_-_SESSION_expiration_time_-_-_"			=>	3600,
						"_-_-_SESSION_idle_expiration_-_-_"			=>	true,
						"_-_-_SESSION_idle_expiration_time_-_-_"	=>	1800,
						"_-_-_COOKIE_auto_expiration_-_-_"			=>	true,
						"_-_-_COOKIE_expiration_time_-_-_"			=>	86400,
						"_-_-_fetch_user_info_-_-_"					=>	true
			];

		}

	}

?>