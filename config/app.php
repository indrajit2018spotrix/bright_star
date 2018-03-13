<?php

	use config\vortex\server_vars;
	use config\manifest;
	use config\vortex\__init__;
	use helper\vortex_datetime_library;
	use helper\vortex_session_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	$GLOBALS = [
		"_-_-_root_-_-_"						=>	"index",
		"_-_-_resource_type_-_-_"				=>	"blade",
		"_-_-_core_-_-_"						=>	[
														"_-_-_server_config_-_-_"		=>	"config/config.php",
														"_-_-___init___-_-_"			=>	"config/autoload.php"
		],
		"_-_-_batch_ini_-_-_"					=>	"Vortex.ini",
		"_-_-_system_syntax_batch_-_-_"			=>	[
														"_-_-_file_-_-_"				=>	"Vortex_Syntax_record.ini",
														"_-_-_modified_-_-_"			=>	false
		],
		"_-_-_fileread_record_-_-_"				=>	[],
		"_-_-_asset_folder_-_-_"				=>	"asset",
		"_-_-_custom_library_path_-_-_"			=>	"helper",
		"_-_-_SESSION_expiration_-_-_"			=>	3600,
		"_-_-_COOKIE_expiration_-_-_"			=>	86400
	];

	require_once $GLOBALS['_-_-_core_-_-_']['_-_-___init___-_-_'];

	$GLOBALS['_-_-_manifest_-_-_'] = manifest::system_manifest();
	$SERVER_VARS = server_vars::server_array();

	$svr_prtcl_arr = explode('/', $SERVER_VARS['SERVER_PROTOCOL']);
	$server_protocol = strtolower($svr_prtcl_arr[0]);
	$GLOBALS['_-_-_SERVER_PROTOCOL_-_-_'] = $server_protocol;

	$GLOBALS['_-_-_REQUEST_URI_-_-_'] = $SERVER_VARS['REQUEST_URI'];

	$flash_request_method = vortex_session_library::get_flush_variable('_-_-_vortex_request_method_-_-_');
	if(isset($flash_request_method))
		$GLOBALS['_-_-_Request_Method_-_-_'] = $flash_request_method;
	else
		$GLOBALS['_-_-_Request_Method_-_-_'] = $SERVER_VARS['REQUEST_METHOD'];

	// die($SERVER_VARS['REQUEST_METHOD']);

	$GLOBALS['_-_-_path_-_-_'] = [
							"_-_-_ini_path_-_-_"					=>	"app/http/illuminate/batch/",
							"_-_-_resource_-_-_"					=>	"resource/",
							"_-_-_asset_-_-_"						=>	[
																"_-_-_css_-_-_"		=>	$server_protocol . "://" . $SERVER_VARS['HTTP_HOST'] . "" . $GLOBALS['_-_-_manifest_-_-_']['_-_-_BASE_PATH_-_-_'] . "/" . $GLOBALS['_-_-_asset_folder_-_-_'] . "/css/",
																"_-_-_font_-_-_"	=>	$server_protocol . "://" . $SERVER_VARS['HTTP_HOST'] . "" . $GLOBALS['_-_-_manifest_-_-_']['_-_-_BASE_PATH_-_-_'] . "/" . $GLOBALS['_-_-_asset_folder_-_-_'] . "/font/",
																"_-_-_img_-_-_"		=>	$server_protocol . "://" . $SERVER_VARS['HTTP_HOST'] . "" . $GLOBALS['_-_-_manifest_-_-_']['_-_-_BASE_PATH_-_-_'] . "/" . $GLOBALS['_-_-_asset_folder_-_-_'] . "/img/",
																"_-_-_js_-_-_"		=>	$server_protocol . "://" . $SERVER_VARS['HTTP_HOST'] . "" . $GLOBALS['_-_-_manifest_-_-_']['_-_-_BASE_PATH_-_-_'] . "/" . $GLOBALS['_-_-_asset_folder_-_-_'] . "/js/"
							],
							"_-_-_app_blade_-_-_"					=>	[
																"_-_-_app_-_-_"	=>	"app/app",
																"_-_-_400_-_-_"	=>	"app/400",
																"_-_-_403_-_-_"	=>	"app/403",
																"_-_-_404_-_-_"	=>	"app/404",
																"_-_-_405_-_-_"	=>	"app/405",
																"_-_-_500_-_-_"	=>	"app/500"
							]
	];

	$GLOBALS['_-_-_syatem_time_-_-_']		=	[
			"_-_-_current_date_-_-_"		=>	vortex_datetime_library::current_time('date'),
			"_-_-_current_time_micro_-_-_"	=>	vortex_datetime_library::current_time('time_micro')
	];

	chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
	if(!file_exists($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_'])){
		$handle = fopen($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_'], 'w');
		fclose($handle);
	}
	$GLOBALS['_-_-_fileread_record_-_-_'] = parse_ini_file($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_']);

	// die(print_r($GLOBALS['fileread_record']));

	__init__::init_routing();

?>