<?php

	namespace config\vortex;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class server_vars{

		public static function server_array(){
			return [
						'HTTP_HOST' 			=> 	$_SERVER['HTTP_HOST'],
						'SERVER_PORT'			=>	$_SERVER['SERVER_PORT'],
						'SERVER_PROTOCOL' 		=> 	$_SERVER['SERVER_PROTOCOL'],
						'REQUEST_METHOD' 		=> 	$_SERVER['REQUEST_METHOD'],
						'REQUEST_TIME_FLOAT' 	=> 	$_SERVER['REQUEST_TIME_FLOAT'],
						'REQUEST_URI' 			=> 	$_SERVER['REQUEST_URI'],
						'USER_AGENT_INFO'		=>	$_SERVER['HTTP_USER_AGENT']
			];
		}

	}

?>